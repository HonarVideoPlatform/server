<?php

/**
 * @package Core
 * @subpackage externalServices
 */
abstract class oauth2Action extends sfAction{

	const EXPIRY_SECONDS = 1800; // 30 minutes

	private function generateHs($partnerId, $additionalData, $privileges)
	{
		$partner = $this->getPartner($partnerId);
		$limitedHs = '';
		$result = hSessionUtils::startHSession($partnerId, $partner->getAdminSecret(), '', $limitedHs, self::EXPIRY_SECONDS, hSessionBase::SESSION_TYPE_ADMIN, '', $privileges, null, $additionalData);
		if ($result < 0)
			throw new Exception('Failed to create limited session for partner '.$partnerId);

		return $limitedHs;
	}

	protected function generateTimeLimitedHsWithData($partnerId, $stateData)
	{
		$privileges = hSessionBase::PRIVILEGE_ACTIONS_LIMIT.':0';
		$additionalData =  json_encode($stateData);
		return $this->generateHs($partnerId, $additionalData, $privileges);
	}

	protected function generateTimeLimitedHs($partnerId)
	{
		return $this->generateHs($partnerId, null, null);
	}

	protected function getPartner($partnerId)
	{
		$partner = PartnerPeer::retrieveByPK($partnerId);
		if (is_null($partner))
			throw new Exception('Partner id '. $partnerId.' not found');

		return $partner;
	}

	protected function processHs($hsStr, $requiredPermission = null)
	{
		try
		{
			kCurrentContext::initHsPartnerUser($hsStr);
		}
		catch(Exception $ex)
		{
			KalturaLog::err($ex);
			return false;
		}

		if (kCurrentContext::$hs_object->type != hs::SESSION_TYPE_ADMIN)
		{
			KalturaLog::err('Hs is not admin');
			return false;
		}

		try
		{
			kPermissionManager::init(kConf::get('enable_cache'));
		}
		catch(Exception $ex)
		{
			if (strpos($ex->getCode(), 'INVALID_ACTIONS_LIMIT') === false) // allow using limited hs
			{
				KalturaLog::err($ex);
				return false;
			}
		}
		if ($requiredPermission)
		{
			if (!kPermissionManager::isPermitted(PermissionName::ADMIN_PUBLISHER_MANAGE))
			{
				KalturaLog::err('Hs is missing "ADMIN_PUBLISHER_MANAGE" permission');
				return false;
			}
		}

		return true;
	}

}
