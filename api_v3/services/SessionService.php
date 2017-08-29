<?php

/**
 * Session service
 *
 * @service session
 * @package api
 * @subpackage services
 */
class SessionService extends KalturaBaseService
{
    
	
	protected function partnerRequired($actionName)
	{
		if ($actionName === 'startWidgetSession') {
			return false;
		}
		return parent::partnerRequired($actionName);
	}
	
	
	/**
	 * Start a session with Kaltura's server.
	 * The result HS is the session key that you should pass to all services that requires a ticket.
	 * 
	 * @action start
	 * @param string $secret Remember to provide the correct secret according to the sessionType you want
	 * @param string $userId
	 * @param KalturaSessionType $type Regular session or Admin session
	 * @param int $partnerId
	 * @param int $expiry HS expiry time in seconds
	 * @param string $privileges 
	 * @return string
	 * @hsIgnored
	 *
	 * @throws APIErrors::START_SESSION_ERROR
	 */
	function startAction($secret, $userId = "", $type = 0, $partnerId = null, $expiry = 86400 , $privileges = null )
	{
		KalturaResponseCacher::disableCache();
		// make sure the secret fits the one in the partner's table
		$hs = "";
		$result = hSessionUtils::startHSession ( $partnerId , $secret , $userId , $hs , $expiry , $type , "" , $privileges );

		if ( $result >= 0 )
	{
		return $hs;
	}
		else
		{
			throw new KalturaAPIException ( APIErrors::START_SESSION_ERROR ,$partnerId );
		}
	}
	
	
	/**
	 * End a session with the Kaltura server, making the current HS invalid.
	 * 
	 * @action end
	 * @hsOptional
	 */
	function endAction()
	{
		KalturaResponseCacher::disableCache();
		
		$hs = $this->getHs();
		if($hs)
			$hs->kill();
	}

	/**
	 * Start an impersonated session with Kaltura's server.
	 * The result HS is the session key that you should pass to all services that requires a ticket.
	 * 
	 * @action impersonate
	 * @param string $secret - should be the secret (admin or user) of the original partnerId (not impersonatedPartnerId).
	 * @param int $impersonatedPartnerId
	 * @param string $userId - impersonated userId
	 * @param KalturaSessionType $type
	 * @param int $partnerId
	 * @param int $expiry HS expiry time in seconds
	 * @param string $privileges 
	 * @return string
	 * @hsIgnored
	 *
	 * @throws APIErrors::START_SESSION_ERROR
	 */
	function impersonateAction($secret, $impersonatedPartnerId, $userId = "", $type = KalturaSessionType::USER, $partnerId = null, $expiry = 86400 , $privileges = null )
	{
		KalturaResponseCacher::disableCache();
		
		// verify that partnerId exists and is in correspondence with given secret
		$result = myPartnerUtils::isValidSecret($partnerId, $secret, "", $expiry, $type);
		if ($result !== true)
		{
			throw new KalturaAPIException ( APIErrors::START_SESSION_ERROR, $partnerId );
		}
				
		// verify partner is allowed to start session for another partner
		$impersonatedPartner = null;
		if (!myPartnerUtils::allowPartnerAccessPartner($partnerId, $this->partnerGroup(), $impersonatedPartnerId))
		{
		    $c = PartnerPeer::getDefaultCriteria();
		    $c->addAnd(PartnerPeer::ID, $impersonatedPartnerId);
		    $impersonatedPartner = PartnerPeer::doSelectOne($c);
		}
		else 
		{
    		// get impersonated partner
    		$impersonatedPartner = PartnerPeer::retrieveByPK($impersonatedPartnerId);
		}
		
		if(!$impersonatedPartner)
		{
			// impersonated partner could not be fetched from the DB
			throw new KalturaAPIException ( APIErrors::START_SESSION_ERROR ,$partnerId );
		}
		
		// set the correct secret according to required session type
		if($type == KalturaSessionType::ADMIN)
		{
			$impersonatedSecret = $impersonatedPartner->getAdminSecret();
		}
		else
		{
			$impersonatedSecret = $impersonatedPartner->getSecret();
		}
		
		// make sure the secret fits the one in the partner's table
		$hs = "";
		$result = hSessionUtils::startHSession ( $impersonatedPartner->getId() , $impersonatedSecret, $userId , $hs , $expiry , $type , "" , $privileges, $partnerId );

		if ( $result >= 0 )
		{
			return $hs;
		}
		else
		{
			throw new KalturaAPIException ( APIErrors::START_SESSION_ERROR ,$partnerId );
		}
	}

	/**
	 * Start an impersonated session with Kaltura's server.
	 * The result HS info contains the session key that you should pass to all services that requires a ticket.
	 * Type, expiry and privileges won't be changed if they're not set
	 * 
	 * @action impersonateByHs
	 * @param string $session The old HS of the impersonated partner
	 * @param KalturaSessionType $type Type of the new HS 
	 * @param int $expiry Expiry time in seconds of the new HS
	 * @param string $privileges Privileges of the new HS
	 * @return KalturaSessionInfo
	 *
	 * @throws APIErrors::START_SESSION_ERROR
	 */
	function impersonateByHsAction($session, $type = null, $expiry = null , $privileges = null)
	{
		KalturaResponseCacher::disableCache();
		
		$oldHS = null;
		try
		{
			$oldHS = hs::fromSecureString($session);
		}
		catch(Exception $e)
		{
			KalturaLog::err($e->getMessage());
			throw new KalturaAPIException(APIErrors::START_SESSION_ERROR, $this->getPartnerId());
		}
		$impersonatedPartnerId = $oldHS->partner_id;
		$impersonatedUserId = $oldHS->user;
		$impersonatedType = $oldHS->type; 
		$impersonatedExpiry = $oldHS->valid_until - time(); 
		$impersonatedPrivileges = $oldHS->privileges;
		
		if(!is_null($type))
			$impersonatedType = $type;
		if(!is_null($expiry)) 
			$impersonatedExpiry = $expiry;
		if($privileges) 
			$impersonatedPrivileges = $privileges;
		
		// verify partner is allowed to start session for another partner
		$impersonatedPartner = null;
		if(!myPartnerUtils::allowPartnerAccessPartner($this->getPartnerId(), $this->partnerGroup(), $impersonatedPartnerId))
		{
			$c = PartnerPeer::getDefaultCriteria();
			$c->addAnd(PartnerPeer::ID, $impersonatedPartnerId);
			$impersonatedPartner = PartnerPeer::doSelectOne($c);
		}
		else
		{
			// get impersonated partner
			$impersonatedPartner = PartnerPeer::retrieveByPK($impersonatedPartnerId);
		}
		
		if(!$impersonatedPartner)
		{
			KalturaLog::err("Impersonated partner [$impersonatedPartnerId ]could not be fetched from the DB");
			throw new KalturaAPIException(APIErrors::START_SESSION_ERROR, $this->getPartnerId());
		}
		
		// set the correct secret according to required session type
		if($impersonatedType == KalturaSessionType::ADMIN)
		{
			$impersonatedSecret = $impersonatedPartner->getAdminSecret();
		}
		else
		{
			$impersonatedSecret = $impersonatedPartner->getSecret();
		}
		
		$sessionInfo = new KalturaSessionInfo();
		
		$result = hSessionUtils::startHSession($impersonatedPartnerId, $impersonatedSecret, $impersonatedUserId, $sessionInfo->hs, $impersonatedExpiry, $impersonatedType, '', $impersonatedPrivileges, $this->getPartnerId());
		if($result < 0)
		{
			KalturaLog::err("Failed starting a session with result [$result]");
			throw new KalturaAPIException(APIErrors::START_SESSION_ERROR, $this->getPartnerId());
		}
	
		$sessionInfo->partnerId = $impersonatedPartnerId;
		$sessionInfo->userId = $impersonatedUserId;
		$sessionInfo->expiry = $impersonatedExpiry;
		$sessionInfo->sessionType = $impersonatedType;
		$sessionInfo->privileges = $impersonatedPrivileges;
		
		return $sessionInfo;
	}

	/**
	 * Parse session key and return its info
	 * 
	 * @action get
	 * @param string $session The HS to be parsed, keep it empty to use current session.
	 * @return KalturaSessionInfo
	 *
	 * @throws APIErrors::START_SESSION_ERROR
	 */
	function getAction($session = null)
	{
		KalturaResponseCacher::disableCache();
		
		if(!$session)
			$session = kCurrentContext::$hs;
		
		$hs = hs::fromSecureString($session);
		
		if (!myPartnerUtils::allowPartnerAccessPartner($this->getPartnerId(), $this->partnerGroup(), $hs->partner_id))
			throw new KalturaAPIException(APIErrors::PARTNER_ACCESS_FORBIDDEN, $this->getPartnerId(), $hs->partner_id);
		
		$sessionInfo = new KalturaSessionInfo();
		$sessionInfo->partnerId = $hs->partner_id;
		$sessionInfo->userId = $hs->user;
		$sessionInfo->expiry = $hs->valid_until;
		$sessionInfo->sessionType = $hs->type;
		$sessionInfo->privileges = $hs->privileges;
		
		return $sessionInfo;
	}
	
	/**
	 * Start a session for Kaltura's flash widgets
	 * 
	 * @action startWidgetSession
	 * @param string $widgetId
	 * @param int $expiry
	 * @return KalturaStartWidgetSessionResponse
	 * @hsIgnored
	 * 
	 * @throws APIErrors::INVALID_WIDGET_ID
	 * @throws APIErrors::MISSING_HS
	 * @throws APIErrors::INVALID_HS
	 * @throws APIErrors::START_WIDGET_SESSION_ERROR
	 */	
	function startWidgetSession ( $widgetId , $expiry = 86400 )
	{
		// make sure the secret fits the one in the partner's table
		$hsStr = "";
		$widget = widgetPeer::retrieveByPK( $widgetId );
		if ( !$widget )
		{
			throw new KalturaAPIException ( APIErrors::INVALID_WIDGET_ID , $widgetId );
		}

		$partnerId = $widget->getPartnerId();

		//$partner = PartnerPeer::retrieveByPK( $partner_id );
		// TODO - see how to decide if the partner has a URL to redirect to


		// according to the partner's policy and the widget's policy - define the privileges of the hs
		// TODO - decide !! - for now only view - any hshow
		$privileges = "view:*,widget:1";
		
		if(PermissionPeer::isValidForPartner(PermissionName::FEATURE_ENTITLEMENT, $partnerId) &&
			!$widget->getEnforceEntitlement() && $widget->getEntryId())
			$privileges .= ','. hSessionBase::PRIVILEGE_DISABLE_ENTITLEMENT_FOR_ENTRY . ':' . $widget->getEntryId();
			
		if(PermissionPeer::isValidForPartner(PermissionName::FEATURE_ENTITLEMENT, $partnerId) &&
			!is_null($widget->getPrivacyContext()) && $widget->getPrivacyContext() != '' )
			$privileges .= ','. hSessionBase::PRIVILEGE_PRIVACY_CONTEXT . ':' . $widget->getPrivacyContext();

		$userId = 0;

		// if the widget has a role, pass it in $privileges so it will be embedded in the HS
		// only if we also have an entry to limit the role operations to
		if ($widget->getRoles() != null)
		{
			$roles = explode(",", $widget->getRoles());
			foreach($roles as $role) {
				$privileges .= ',' . hSessionBase::PRIVILEGE_SET_ROLE . ':' . $role;
			}
		}

		if ($widget->getEntryId() != null)
		{
			$privileges .= ',' . hSessionBase::PRIVILEGE_LIMIT_ENTRY . ':' . $widget->getEntryId();
		}

		/*if ( $widget->getSecurityType() == widget::WIDGET_SECURITY_TYPE_FORCE_HS )
		{
			$user = $this->getKuser();
			if ( ! $this->getHS() )// the one from the base class
				throw new KalturaAPIException ( APIErrors::MISSING_HS );

			$widget_partner_id = $widget->getPartnerId();
			$res = hSessionUtils::validateHSession2 ( 1 ,$widget_partner_id  , $user->getId() , $hs_str , $this->hs );
			
			if ( 0 >= $res )
			{
				// chaned this to be an exception rather than an error
				throw new KalturaAPIException ( APIErrors::INVALID_HS , $hs_str , $res , hs::getErrorStr( $res ));
			}			
		}
		else
		{*/
			// 	the session will be for NON admins and privileges of view only
			$result = hSessionUtils::createHSessionNoValidations ( $partnerId , $userId , $hsStr , $expiry , false , "" , $privileges );
		//}

		if ( $result >= 0 )
		{
			$response = new KalturaStartWidgetSessionResponse();
			$response->partnerId = $partnerId;
			$response->hs = $hsStr;
			$response->userId = $userId;
			return $response;
		}
		else
		{
			// TODO - see that there is a good error for when the invalid login count exceed s the max
			throw new  KalturaAPIException  ( APIErrors::START_WIDGET_SESSION_ERROR ,$widgetId );
		}		
	}
}
