<?php

/**
 * @package plugins.elasticSearch
 * @subpackage lib.entitlement
 */
class kEntryElasticEntitlement extends kBaseElasticEntitlement
{
    
    public static $kuserId = null;
    public static $privacyContext = null;
    public static $privacy = null;
    public static $userEntitlement = false;
    public static $userCategoryToEntryEntitlement = false;
    public static $entriesDisabledEntitlement = array();
    public static $publicEntries = false; //active + pending
    public static $publicActiveEntries = false; //active
    public static $parentEntitlement = false;
    public static $entryInSomeCategoryNoPC = false; //active + pending
    
    protected static function initialize()
    {
        parent::initialize();
        $partner = PartnerPeer::retrieveByPK(self::$partnerId);

        //disable the entitlement checks for partner
        if(!$partner->getDefaultEntitlementEnforcement())
            return;

        self::initializeParentEntitlement();
        self::initializeDisableEntitlement(self::$hs);
        self::$kuserId = self::getKuserIdForEntitlement(self::$partnerId, self::$kuserId, self::$hs);
        self::initializeUserEntitlement(self::$hs);

        if(self::$hs)
            self::$privacyContext = self::$hs->getPrivacyContext();

        self::initializePublicEntryEntitlement(self::$hs);
        self::initializeUserCategoryEntryEntitlement(self::$hs);
        
        self::$isInitialized = true;
    }

    private static function initializeParentEntitlement()
    {
        if(!(PermissionPeer::isValidForPartner(PermissionName::FEATURE_DISABLE_PARENT_ENTRY_SECURITY_INHERITANCE, self::$partnerId)))
        {
            //we need to add entitlement check on the parent
            self::$parentEntitlement = true;
        }
    }

    private static function initializeDisableEntitlement($hs)
    {
        if($hs && count($hs->getDisableEntitlementForEntry()))
        {
            //disable entitlement for entries
            $entries = $hs->getDisableEntitlementForEntry();
            self::$entriesDisabledEntitlement = $entries;
        }
    }

    private static function initializeUserEntitlement($hs)
    {
        if($hs && self::$kuserId)
        {
            self::$userEntitlement = true;
        }
    }

    private static function initializePublicEntryEntitlement($hs)
    {
        if(!$hs)
        {
            self::$publicActiveEntries = true; //add entries that are not in any active category
        }
        else //hs
        {
            if(!PermissionPeer::isValidForPartner(PermissionName::FEATURE_DISABLE_CATEGORY_LIMIT, self::$partnerId) && !self::$privacyContext)
                self::$publicEntries = true; //return entries that are not in any active/pending category
        }
    }

    private static function initializeUserCategoryEntryEntitlement($hs)
    {
        if(PermissionPeer::isValidForPartner(PermissionName::FEATURE_DISABLE_CATEGORY_LIMIT, self::$partnerId))
        {
            if(!self::$privacyContext)//add entries that are in some category and doesnt have pc
                self::$entryInSomeCategoryNoPC = true;
        }

        if(self::$kuserId)
        {
            $privacy = array(category::formatPrivacy(PrivacyType::ALL, self::$partnerId));
            if($hs && !$hs->isAnonymousSession())
                $privacy[] = category::formatPrivacy(PrivacyType::AUTHENTICATED_USERS, self::$partnerId);

            self::$privacy = $privacy;

            self::$userCategoryToEntryEntitlement = true;
        }
    }

    private static function getKuserIdForEntitlement($partnerId, $kuserId = null, $hs = null)
    {
        if($hs && !$kuserId)
        {
            $kuser = kuserPeer::getKuserByPartnerAndUid($partnerId, kCurrentContext::$hs_uid, true);
            if($kuser)
                $kuserId = $kuser->getId();
        }

        return $kuserId;
    }
}
