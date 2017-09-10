<?php
/**
 * kEntitlementUtils is all utils needed for entitlement use cases.
 * @package Core
 * @subpackage utils
 *
 */
class kEntitlementUtils
{
	const DEFAULT_CONTEXT = 'DEFAULTPC';
	const NOT_DEFAULT_CONTEXT = 'NOTDEFAULTPC';
	const TYPE_SEPERATOR = "TYPE";
	const ENTRY_PRIVACY_CONTEXT = 'ENTRYPC';
	const PARTNER_ID_PREFIX = 'pid';

	protected static $initialized = false;
	protected static $entitlementEnforcement = false;
	protected static $entitlementForced = null;
	protected static $privacyContextSearch = null;
	protected static $categoryModeration = false;

	public static function getDefaultContextString( $partnerId )
	{
		return self::getPartnerPrefix($partnerId) . self::DEFAULT_CONTEXT;
	}

	public static function getPartnerPrefix($partnerId)
	{
		return kEntitlementUtils::PARTNER_ID_PREFIX . $partnerId;
	}

	public static function addPrivacyContextsPrefix($privacyContextsArray, $partnerId )
	{
		if ( is_null($privacyContextsArray) || is_null($partnerId))
		{
			KalturaLog::err("can't handle privacy context for privacyContextsArray: $privacyContextsArray and partnerId: $partnerId.");
			return $privacyContextsArray;
		}
		$prefix = self::getPartnerPrefix($partnerId);

		foreach ($privacyContextsArray as &$value)
		{
			$value = $prefix . $value;
		}

		return $privacyContextsArray;

	}

	public static function getEntitlementEnforcement()
	{
		return self::$entitlementEnforcement;
	}

	public static function getCategoryModeration ()
	{
		return self::$categoryModeration;
	}

	public static function getInitialized()
	{
		return self::$initialized;
	}

	public static function isHsPrivacyContextSet()
	{
		$hs = hs::fromSecureString(kCurrentContext::$hs);

		if(!$hs || !$hs->getPrivacyContext())
			return false;

		return true;
	}

	/**
	 * Returns true if kuser or current kuser is entitled to entryId
	 * @param entry $entry
	 * @param int $kuser
	 * @return bool
	 */
	public static function isEntryEntitled(entry $entry, $kuserId = null)
	{
		if($entry->getSecurityParentId())
		{
			$entry = $entry->getParentEntry();
			if(!$entry)
			{
				KalturaLog::log('Parent entry not found, cannot validate entitlement');
				return false;
			}
		}

		$hs = hs::fromSecureString(kCurrentContext::$hs);

		if(self::$entitlementForced === false)
		{
			KalturaLog::log('Entitlement forced to be disabled');
			return true;
		}

		// entry is entitled when entitlement is disable
		// for actions with no hs - need to check if partner have default entitlement feature enable.
		if(!self::getEntitlementEnforcement() && $hs)
		{
			KalturaLog::log('Entry entitled: entitlement disabled');
			return true;
		}

		$partner = $entry->getPartner();

		if(!$hs && !$partner->getDefaultEntitlementEnforcement())
		{
			KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: no hs and default is with no enforcement');
			return true;
		}

		if($hs && in_array($entry->getId(), $hs->getDisableEntitlementForEntry()))
		{
			KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: hs disble entitlement for this entry');
			return true;
		}

		$kuserId = self::getKuserIdForEntitlement($kuserId, $hs);

		if($hs && $kuserId)
		{
			// kuser is set on the entry as creator or uploader
			if ($kuserId != '' && ($entry->getKuserId() == $kuserId))
			{
				KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: hs user is the same as entry->kuserId or entry->creatorKuserId [' . $kuserId . ']');
				return true;
			}

			// kuser is set on the entry entitled users edit or publish
			if($entry->isEntitledKuserEdit($kuserId) || $entry->isEntitledKuserPublish($kuserId))
			{
				KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: hs user is the same as entry->entitledKusersEdit or entry->entitledKusersPublish');
				return true;
			}
		}

		if(!$hs)
		{
			// entry that doesn't belong to any category is public
			//when hs is not provided - the entry is still public (for example - download action)
			$categoryEntry = categoryEntryPeer::retrieveOneActiveByEntryId($entry->getId());
			if(!$categoryEntry)
			{
				KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: entry does not belong to any category');
				return true;
			}
		}

		$hsPrivacyContexts = null;
		if($hs)
			$hsPrivacyContexts = $hs->getPrivacyContext();

		$allCategoriesEntry = array();

		if(PermissionPeer::isValidForPartner(PermissionName::FEATURE_DISABLE_CATEGORY_LIMIT, $partner->getId()))
		{
			if(!$hsPrivacyContexts || trim($hsPrivacyContexts) == '')
			{
				$categoryEntry = categoryEntryPeer::retrieveOneByEntryIdStatusPrivacyContextExistance($entry->getId(), array(CategoryEntryStatus::PENDING, CategoryEntryStatus::ACTIVE));
				if($categoryEntry)
				{
					KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: entry belongs to public category and privacy context on the hs is not set');
					return true;
				}
			}
			else
				$allCategoriesEntry = categoryEntryPeer::retrieveActiveAndPendingByEntryIdAndPrivacyContext($entry->getId(), $hsPrivacyContexts);
		}
		else
		{
			$allCategoriesEntry = categoryEntryPeer::retrieveActiveAndPendingByEntryId($entry->getId());
			if($hs && (!$hsPrivacyContexts || trim($hsPrivacyContexts) == '') && !count($allCategoriesEntry))
			{
				// entry that doesn't belong to any category is public
				KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: entry does not belong to any category and privacy context on the hs is not set');
				return true;
			}
		}

		return self::isMemberOfCategory($allCategoriesEntry, $entry, $partner, $kuserId, $hs, $hsPrivacyContexts);
	}

	private static function getKuserIdForEntitlement($kuserId = null, $hs = null)
	{
		if($hs && !$kuserId)
		{
			$partnerId = kCurrentContext::$partner_id ? kCurrentContext::$partner_id : kCurrentContext::$hs_partner_id;
			$kuser = kuserPeer::getKuserByPartnerAndUid($partnerId, kCurrentContext::$hs_uid, true);
			if($kuser)
				$kuserId = $kuser->getId();
		}

		return $kuserId;
	}

	private static function isMemberOfCategory($allCategoriesEntry, entry $entry, Partner $partner, $kuserId = null, $hs = null, $hsPrivacyContexts = null)
	{
		$categories = array();
		foreach($allCategoriesEntry as $categoryEntry)
			$categories[] = $categoryEntry->getCategoryId();

		//if entry doesn't belong to any category.
		$categories[] = category::CATEGORY_ID_THAT_DOES_NOT_EXIST;

		$c = KalturaCriteria::create(categoryPeer::OM_CLASS);
		$c->add(categoryPeer::ID, $categories, Criteria::IN);

		$privacy = array(category::formatPrivacy(PrivacyType::ALL, $partner->getId()));
		if($hs && !$hs->isAnonymousSession())
			$privacy[] = category::formatPrivacy(PrivacyType::AUTHENTICATED_USERS, $partner->getId());

		$crit = $c->getNewCriterion (categoryPeer::PRIVACY, $privacy, Criteria::IN);

		if($hs)
		{
			if (!$hsPrivacyContexts || trim($hsPrivacyContexts) == '')
				$hsPrivacyContexts = self::getDefaultContextString( $partner->getId());
			else
			{
				$hsPrivacyContexts = explode(',', $hsPrivacyContexts);
				$hsPrivacyContexts = self::addPrivacyContextsPrefix( $hsPrivacyContexts, $partner->getId() );
			}

			$c->add(categoryPeer::PRIVACY_CONTEXTS, $hsPrivacyContexts, KalturaCriteria::IN_LIKE);

			// kuser is set on the category as member
			// this ugly code is temporery - since we have a bug in sphinxCriteria::getAllCriterionFields
			if($kuserId)
			{
				// get the groups that the user belongs to in case she is not associated to the category directly
				$kgroupIds = KuserKgroupPeer::retrieveKgroupIdsByKuserId($kuserId);
				$kgroupIds[] = $kuserId;
				$membersCrit = $c->getNewCriterion ( categoryPeer::MEMBERS , $kgroupIds, KalturaCriteria::IN_LIKE);
				$membersCrit->addOr($crit);
				$crit = $membersCrit;
			}
		}
		else
		{
			//no hs = set privacy context to default.
			$c->add(categoryPeer::PRIVACY_CONTEXTS, array( self::getDefaultContextString( $partner->getId() )) , KalturaCriteria::IN_LIKE);
		}

		$c->addAnd($crit);

		//remove default FORCED criteria since categories that has display in search = public - doesn't mean that all of their entries are public
		KalturaCriterion::disableTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);
		$category = categoryPeer::doSelectOne($c);
		KalturaCriterion::restoreTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);

		if($category)
		{
			KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] entitled: hs user is a member of this category or category privacy is set to public of authenticated');
			return true;
		}

		KalturaLog::info('Entry [' . print_r($entry->getId(), true) . '] not entitled');
		return false;
	}

	/**
	 * Set Entitlement Enforcement - if entitelement is enabled \ disabled in this session
	 * @param int $categoryId
	 * @param int $kuser
	 * @return bool
	 */
	public static function initEntitlementEnforcement($partnerId = null, $enableEntit = null)
	{
		self::$initialized = true;
		self::$entitlementForced = $enableEntit;

		if(is_null($partnerId))
			$partnerId = kCurrentContext::getCurrentPartnerId();

		if(is_null($partnerId) || $partnerId == Partner::BATCH_PARTNER_ID)
			return;

		$partner = PartnerPeer::retrieveByPK($partnerId);
		if (!$partner)
			return;

		$hs = null;
		$hsString = kCurrentContext::$hs ? kCurrentContext::$hs : '';
		if ($hsString != '') // for actions with no HS or when creating hs.
		{
			$hs = hs::fromSecureString($hsString);
		}

		self::initCategoryModeration($hs);

		if(!PermissionPeer::isValidForPartner(PermissionName::FEATURE_ENTITLEMENT, $partnerId))
			return;

		$partnerDefaultEntitlementEnforcement = $partner->getDefaultEntitlementEnforcement();

		// default entitlement scope is true - enable.
		if(is_null($partnerDefaultEntitlementEnforcement))
			$partnerDefaultEntitlementEnforcement = true;

		self::$entitlementEnforcement = $partnerDefaultEntitlementEnforcement;

		if ($hs) // for actions with no HS or when creating hs.
		{
			$enableEntitlement = $hs->getDisableEntitlement();
			if ($enableEntitlement)
				self::$entitlementEnforcement = false;

			$enableEntitlement = $hs->getEnableEntitlement();
			if ($enableEntitlement)
				self::$entitlementEnforcement = true;

		}

		if(!is_null($enableEntit))
		{
			if($enableEntit)
				self::$entitlementEnforcement = true;
			else
				self::$entitlementEnforcement = false;
		}

		if (self::$entitlementEnforcement)
		{
			KalturaCriterion::enableTag(KalturaCriterion::TAG_ENTITLEMENT_ENTRY);
			KalturaCriterion::enableTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);
		}
	}

	public static function getPrivacyForHs($partnerId)
	{
		$hs = hs::fromSecureString(kCurrentContext::$hs);
		if(!$hs || $hs->isAnonymousSession())
			return array(category::formatPrivacy(PrivacyType::ALL, $partnerId));

		return array(category::formatPrivacy(PrivacyType::ALL, $partnerId),
			category::formatPrivacy(PrivacyType::AUTHENTICATED_USERS, $partnerId));
	}

	public static function getPrivacyContextSearch()
	{
		$partnerId = kCurrentContext::$partner_id ? kCurrentContext::$partner_id : kCurrentContext::$hs_partner_id;

		if (self::$privacyContextSearch)
			return self::$privacyContextSearch;

		$privacyContextSearch = array();

		$hs = hs::fromSecureString(kCurrentContext::$hs);
		if(!$hs)
			return array( self::getDefaultContextString( $partnerId ) . self::TYPE_SEPERATOR . PrivacyType::ALL);

		$hsPrivacyContexts = $hs->getPrivacyContext();

		if(is_null($hsPrivacyContexts))
		{   // setting $hsPrivacyContexts only with DEFAULT_CONTEXT string (to resolve conflicts)
			// since prefix will be add in the addPrivacyContextsPrefix bellow
			$hsPrivacyContexts = self::DEFAULT_CONTEXT;
		}

		$hsPrivacyContexts = explode(',', $hsPrivacyContexts);

		foreach ($hsPrivacyContexts as $hsPrivacyContext)
		{
			$privacyContextSearch[] = $hsPrivacyContext . self::TYPE_SEPERATOR . PrivacyType::ALL;

			if (!$hs->isAnonymousSession())
				$privacyContextSearch[] = $hsPrivacyContext . self::TYPE_SEPERATOR  . PrivacyType::AUTHENTICATED_USERS;
		}

		self::$privacyContextSearch = self::addPrivacyContextsPrefix( $privacyContextSearch, $partnerId );

		return self::$privacyContextSearch;
	}

	public static function setPrivacyContextSearch($privacyContextSearch)
	{
		self::$privacyContextSearch = array($privacyContextSearch . self::TYPE_SEPERATOR . PrivacyType::ALL);
	}

	public static function getPrivacyContextForEntry(entry $entry)
	{
		$privacyContexts = array();

		if(PermissionPeer::isValidForPartner(PermissionName::FEATURE_DISABLE_CATEGORY_LIMIT, $entry->getPartnerId()))
			$privacyContexts = self::getPrivacyContextsByCategoryEntries($entry);
		else
			$privacyContexts = self::getPrivacyContextsByAllCategoryIds($entry);

		//Entry That doesn't assinged to any category is public.
		if (!count($privacyContexts))
			$privacyContexts[self::DEFAULT_CONTEXT] = PrivacyType::ALL ;

		$entryPrivacyContexts = array();
		foreach ($privacyContexts as $categoryPrivacyContext => $Privacy)
			$entryPrivacyContexts[] = $categoryPrivacyContext . self::TYPE_SEPERATOR . $Privacy;

		KalturaLog::info('Privacy by context: ' . print_r($entryPrivacyContexts,true));

		return $entryPrivacyContexts;
	}

	private static function getCategoriesByIds($categoriesIds)
	{
		$c = KalturaCriteria::create(categoryPeer::OM_CLASS);
		KalturaCriterion::disableTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);
		$c->add(categoryPeer::ID, $categoriesIds, Criteria::IN);
		KalturaCriterion::restoreTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);
		$c->dontCount();

		KalturaCriterion::disableTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);
		$categories = categoryPeer::doSelect($c);
		KalturaCriterion::restoreTag(KalturaCriterion::TAG_ENTITLEMENT_CATEGORY);

		return $categories;
	}

	private static function getPrivacyContextsByAllCategoryIds(entry $entry)
	{
		$privacyContexts = array();

		$allCategoriesIds = $entry->getAllCategoriesIds(true);
		if (count($allCategoriesIds))
		{
			$categories = self::getCategoriesByIds($allCategoriesIds);
			foreach ($categories as $category)
			{
				$categoryPrivacy = $category->getPrivacy();
				$categoryPrivacyContexts = $category->getPrivacyContexts();
				if($categoryPrivacyContexts)
				{
					$categoryPrivacyContexts = explode(',', $categoryPrivacyContexts);

					foreach ($categoryPrivacyContexts as $categoryPrivacyContext)
					{
						if(trim($categoryPrivacyContext) == '')
							$categoryPrivacyContext = self::DEFAULT_CONTEXT;

						if(!isset($privacyContexts[$categoryPrivacyContext]) || $privacyContexts[$categoryPrivacyContext] > $categoryPrivacy)
							$privacyContexts[trim($categoryPrivacyContext)] = $categoryPrivacy;
					}
				}
				else
				{
					$privacyContexts[self::DEFAULT_CONTEXT] = PrivacyType::ALL;
				}
			}
		}

		return $privacyContexts;
	}

	private static function getPrivacyContextsByCategoryEntries(entry $entry)
	{
		$privacyContexts = array();
		$categoriesIds = array();

		//get category entries that have privacy context
		$categoryEntries = categoryEntryPeer::retrieveByEntryIdStatusPrivacyContextExistance($entry->getId(), null, true);
		foreach ($categoryEntries as $categoryEntry)
		{
			$categoriesIds[] = $categoryEntry->getCategoryId();
		}

		$categories = self::getCategoriesByIds($categoriesIds);
		foreach ($categories as $category)
		{
			$categoryPrivacy = $category->getPrivacy();
			$categoryPrivacyContext = $category->getPrivacyContexts();
			if(!isset($privacyContexts[$categoryPrivacyContext]) || $privacyContexts[$categoryPrivacyContext] > $categoryPrivacy)
				$privacyContexts[trim($categoryPrivacyContext)] = $categoryPrivacy;
		}

		$noPrivacyContextCategory = categoryEntryPeer::retrieveOneByEntryIdStatusPrivacyContextExistance($entry->getId());
		if($noPrivacyContextCategory)
			$privacyContexts[ self::DEFAULT_CONTEXT ] = PrivacyType::ALL;

		return $privacyContexts;
	}

	public static function getEntitledKuserByPrivacyContext()
	{
		$partnerId = kCurrentContext::$partner_id ? kCurrentContext::$partner_id : kCurrentContext::$hs_partner_id;

		$privacyContextSearch = array();

		$hs = hs::fromSecureString(kCurrentContext::$hs);
		$hsPrivacyContexts = null;
		if ($hs)
			$hsPrivacyContexts = $hs->getPrivacyContext();

		if(is_null($hsPrivacyContexts) || $hsPrivacyContexts == '')
			$hsPrivacyContexts = self::DEFAULT_CONTEXT . $partnerId;

		$hsPrivacyContexts = explode(',', $hsPrivacyContexts);

		$privacyContexts = $hsPrivacyContexts;
		$privacyContexts[] = self::ENTRY_PRIVACY_CONTEXT;

		// get the groups that the user belongs to in case she is not associated to the category directly
		$kuserIds = KuserKgroupPeer::retrieveKgroupIdsByKuserId(kCurrentContext::getCurrentHsKuserId());
		$kuserIds[] = kCurrentContext::getCurrentHsKuserId();
		foreach ($privacyContexts as $privacyContext){
			foreach ( $kuserIds as $kuserId){
				$privacyContextSearch[] = $privacyContext . '_' . $kuserId;
			}
		}

		return $privacyContextSearch;
	}
	public static function getHsPrivacyContext()
	{
		$partnerId = kCurrentContext::$hs_partner_id ? kCurrentContext::$hs_partner_id : kCurrentContext::$partner_id;

		$hs = hs::fromSecureString(kCurrentContext::$hs);
		if(!$hs)
			return array(self::getDefaultContextString( $partnerId ) );

		$hsPrivacyContexts = $hs->getPrivacyContext();
		if(is_null($hsPrivacyContexts) || $hsPrivacyContexts == '')
			return array(self::getDefaultContextString( $partnerId ));
		else
		{
			$hsPrivacyContexts = explode(',', $hsPrivacyContexts);
			$hsPrivacyContexts = self::addPrivacyContextsPrefix( $hsPrivacyContexts, $partnerId);
		}

		return $hsPrivacyContexts;
	}

	/**
	 * Function returns the privacy context(s) found on the HS, if none are found returns array containing DEFAULT_PC
	 */
	public static function getHsPrivacyContextArray()
	{
		$partnerId = kCurrentContext::$hs_partner_id ? kCurrentContext::$hs_partner_id : kCurrentContext::$partner_id;

		$hs = hs::fromSecureString(kCurrentContext::$hs);
		if(!$hs)
			return array(self::DEFAULT_CONTEXT);

		$hsPrivacyContexts = $hs->getPrivacyContext();
		if(is_null($hsPrivacyContexts) || $hsPrivacyContexts == '')
			return array(self::DEFAULT_CONTEXT);

		return explode(',', $hsPrivacyContexts);
	}

	protected static function initCategoryModeration (hs $hs = null)
	{
		if (!$hs)
			return;

		$enableCategoryModeration = $hs->getEnableCategoryModeration();
		if ($enableCategoryModeration)
			self::$categoryModeration = true;
	}

	/**
	 * @param entry $dbEntry
	 * @return bool if current user is admin / entry's owner / co-editor
	 */
	public static function isEntitledForEditEntry( entry $dbEntry )
	{
		if ( kCurrentContext::$is_admin_session || kCurrentContext::getCurrentHsKuserId() == $dbEntry->getKuserId())
			return true;

		return $dbEntry->isEntitledKuserEdit(kCurrentContext::getCurrentHsKuserId());
	}
}
