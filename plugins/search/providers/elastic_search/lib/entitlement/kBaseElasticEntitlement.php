<?php

/**
 * @package plugins.elasticSearch
 * @subpackage lib.entitlement
 */
abstract class kBaseElasticEntitlement
{
    public static $isInitialized = false;
    public static $partnerId;
    public static $hs;

    public static function init()
    {
        if(!self::$isInitialized)
            static::initialize();
    }
    
    protected static function initialize()
    {
        self::$hs = hs::fromSecureString(kCurrentContext::$hs);
        self::$partnerId = kCurrentContext::$partner_id ? kCurrentContext::$partner_id : kCurrentContext::$hs_partner_id;
    }
    
}
