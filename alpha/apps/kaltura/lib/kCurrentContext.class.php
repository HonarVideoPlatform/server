<?php
/**
 * Will hold the current context of the API call / current running batch.
 * The inforamtion is static per call and can be used from anywhare in the code. 
 */
class kCurrentContext
{
	/**
	 * @var string
	 */
	public static $hs;
	
	/**
	 * @var hs
	 */
	public static $hs_object;
	
	/**
	 * @var string
	 */
	public static $hs_hash;
	
	/**
	 * This value is populated only in case of impersonation using partnerId in the request.
	 * It's used by the batch abd the admin console only.
	 * 
	 * @var int
	 */
	public static $partner_id;

	/**
	 * @var int
	 */
	public static $hs_partner_id;

	/**
	 * @var int
	 */
	public static $master_partner_id;
	
	/**
	 * @var string
	 */
	public static $uid;
	
	
	/**
	 * @var string
	 */
	public static $hs_uid;
	
	/**
	 * @var int
	 */
	public static $hs_kuser_id = null;
	
	/**
	 * @var string
	 */
	public static $hs_kuser;

	/**
	 * @var string
	 */
	public static $ps_vesion;
	
	/**
	 * @var string
	 */
	public static $call_id;
	
	/**
	 * @var string
	 */
	public static $service;
	
	/**
	 * @var string
	 */
	public static $action;
	
	/**
	 * @var string
	 */
	public static $host;
	
	/**
	 * @var string
	 */
	public static $client_version;
	
	/**
	 * @var string
	 */
	public static $client_lang;
	
	/**
	 * @var string
	 */
	public static $user_ip;
	
	/**
	 * @var bool
	 */
	public static $is_admin_session;
	
	/**
	 * @var bool
	 */
	public static $hsPartnerUserInitialized = false;
	
	/**
	 * @var int
	 */
	public static $multiRequest_index = 1;
	
	/**
	 * @var callable
	 */	
	public static $serializeCallback;

	/**
	 * @var int
	 */
	public static $HTMLPurifierBehaviour = null;

	/**
	 * @var bool
	 */
	public static $HTMLPurifierBaseListOnlyUsage = null;
	
	public static function getEntryPoint()
	{
		if(self::$service && self::$action)
			return self::$service . '::' . self::$action;
			
		if(isset($_SERVER['SCRIPT_NAME']))
			return $_SERVER['SCRIPT_NAME'];
			
		if(isset($_SERVER['PHP_SELF']))
			return $_SERVER['PHP_SELF'];
			
		if(isset($_SERVER['SCRIPT_FILENAME']))
			return $_SERVER['SCRIPT_FILENAME'];
			
		return '';
	}
	
	public static function isApiV3Context()
	{		
		if (kCurrentContext::$ps_vesion == 'ps3') {
			return true;
		}
		
		return false;
	}
	
	public static function initPartnerByEntryId($entryId)
	{		
		$entry = entryPeer::retrieveByPKNoFilter($entryId);
		if(!$entry)
			return null;
			
		kCurrentContext::$hs = null;
		kCurrentContext::$hs_object = null;
		kCurrentContext::$hs_hash = null;
		kCurrentContext::$hs_partner_id = $entry->getPartnerId();
		kCurrentContext::$hs_uid = null;
		kCurrentContext::$master_partner_id = null;
		kCurrentContext::$partner_id = $entry->getPartnerId();
		kCurrentContext::$uid = null;
		kCurrentContext::$is_admin_session = false;
		
		return $entry;
	}
	
	public static function initPartnerByAssetId($assetId)
	{		
		KalturaCriterion::disableTags(array(KalturaCriterion::TAG_ENTITLEMENT_ENTRY, KalturaCriterion::TAG_WIDGET_SESSION));
		$asset = assetPeer::retrieveByIdNoFilter($assetId);
		KalturaCriterion::restoreTags(array(KalturaCriterion::TAG_ENTITLEMENT_ENTRY, KalturaCriterion::TAG_WIDGET_SESSION));
		
		if(!$asset)
			return null;
			
		kCurrentContext::$hs = null;
		kCurrentContext::$hs_object = null;
		kCurrentContext::$hs_hash = null;
		kCurrentContext::$hs_partner_id = $asset->getPartnerId();
		kCurrentContext::$hs_uid = null;
		kCurrentContext::$master_partner_id = null;
		kCurrentContext::$partner_id = $asset->getPartnerId();
		kCurrentContext::$uid = null;
		kCurrentContext::$is_admin_session = false;
		
		return $asset;
	}
	
	public static function initHsPartnerUser($hsString, $requestedPartnerId = null, $requestedPuserId = null)
	{		
		if (!$hsString)
		{
			kCurrentContext::$hs = null;
			kCurrentContext::$hs_object = null;
			kCurrentContext::$hs_hash = null;
			kCurrentContext::$hs_partner_id = null;
			kCurrentContext::$hs_uid = null;
			kCurrentContext::$master_partner_id = null;
			kCurrentContext::$partner_id = $requestedPartnerId;
			kCurrentContext::$uid = $requestedPuserId;
			kCurrentContext::$is_admin_session = false;
		}
		else
		{
			try { $hsObj = hSessionUtils::crackHs ( $hsString ); }
			catch(Exception $ex)
			{
				if (strpos($ex->getMessage(), "INVALID_STR") !== null)
					throw new kCoreException($ex->getMessage(), kCoreException::INVALID_HS, $hsString);
				else 
					throw $ex;
			}
		
			kCurrentContext::$hs = $hsString;
			kCurrentContext::$hs_object = $hsObj;
			kCurrentContext::$hs_hash = $hsObj->getHash();
			kCurrentContext::$hs_partner_id = $hsObj->partner_id;
			kCurrentContext::$hs_uid = $hsObj->user;
			kCurrentContext::$master_partner_id = $hsObj->master_partner_id ? $hsObj->master_partner_id : kCurrentContext::$hs_partner_id;
			kCurrentContext::$is_admin_session = $hsObj->isAdmin();
			
			if($requestedPartnerId == PartnerPeer::GLOBAL_PARTNER && self::$hs_partner_id > PartnerPeer::GLOBAL_PARTNER)
				$requestedPartnerId = null;
			
			kCurrentContext::$partner_id = $requestedPartnerId;
			kCurrentContext::$uid = $requestedPuserId;
		}

		// set partner ID for logger
		if (kCurrentContext::$partner_id) {
			$GLOBALS["partnerId"] = kCurrentContext::$partner_id;
		}
		else if (kCurrentContext::$hs_partner_id) {
			$GLOBALS["partnerId"] = kCurrentContext::$hs_partner_id;
		}
		
		self::$hsPartnerUserInitialized = true;
	}
	
	public static function getCurrentHsKuser($activeOnly = true)
	{
		if(!kCurrentContext::$hs_kuser)
		{			
			kCurrentContext::$hs_kuser = kuserPeer::getKuserByPartnerAndUid(kCurrentContext::$hs_partner_id, kCurrentContext::$hs_uid, true);
		}
		
		if(kCurrentContext::$hs_kuser &&
		   $activeOnly && 
		   kCurrentContext::$hs_kuser->getStatus() != KuserStatus::ACTIVE)
		   	return null;
			
		return kCurrentContext::$hs_kuser;
	}

	public static function getCurrentSessionType()
	{
		if(!self::$hs_object)
			return hSessionBase::SESSION_TYPE_NONE;
			
		if(self::$hs_object->isAdmin())
			return hSessionBase::SESSION_TYPE_ADMIN;
			
		if(self::$hs_object->isWidgetSession())
			return hSessionBase::SESSION_TYPE_WIDGET;
			
		return hSessionBase::SESSION_TYPE_USER;
	}

	public static function getCurrentPartnerId()
	{
		if(isset(self::$partner_id))
			return self::$partner_id;
			
		return self::$hs_partner_id;
	}

	public static function getCurrentHsKuserId()
	{
		if (!is_null(kCurrentContext::$hs_kuser_id))
			return kCurrentContext::$hs_kuser_id;
			
		$hsKuser = kCurrentContext::getCurrentHsKuser(false);
		if($hsKuser)
			kCurrentContext::$hs_kuser_id = $hsKuser->getId();
		else 
			kCurrentContext::$hs_kuser_id = 0;
			
		return kCurrentContext::$hs_kuser_id;
	}
}
