<?php


/**
 * Skeleton subclass for performing query and update operations on the 'invalid_session' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package Core
 * @subpackage model
 */
class invalidSessionPeer extends BaseinvalidSessionPeer {
	
	/**
	 * @param      hs $hs
	 * @param	   int $limit
	 * @return     invalidSession
	 */
	public static function actionsLimitHs(hs $hs, $limit)
	{
		$invalidSession = new invalidSession();
		$invalidSession->setHs($hs->getHash());
		$invalidSession->setActionsLimit($limit);
		$invalidSession->setHsValidUntil($hs->valid_until);
		$invalidSession->setType(invalidSession::INVALID_SESSION_TYPE_HS);
		$invalidSession->save();
		
		return $invalidSession;
	}
	
	/**
	 * @param      hs $hs
	 * @return     invalidSession
	 */
	public static function invalidateHs(hs $hs, PropelPDO $con = null)
	{
		$result = self::invalidateByKey($hs->getHash(), invalidSession::INVALID_SESSION_TYPE_HS, $hs->valid_until, $con);
		$sessionId = $hs->getSessionIdHash();
		if($sessionId) {
			self::invalidateByKey($sessionId, invalidSession::INVALID_SESSION_TYPE_SESSION_ID, time() + (24 * 60 * 60), $con);
		}
		
		return $result;
	}
	
	public static function invalidateByKey($key, $type, $validUntil, PropelPDO $con = null) {
		$criteria = new Criteria();
		$criteria->add(invalidSessionPeer::HS, $key);
		$criteria->add(invalidSessionPeer::TYPE, $type);
		$invalidSession = invalidSessionPeer::doSelectOne($criteria, $con);
		
		if(!$invalidSession){
			$invalidSession = new invalidSession();
			$invalidSession->setHs($key);
			$invalidSession->setType($type);
			$invalidSession->setHsValidUntil($validUntil);
		}
		
		$invalidSession->setActionsLimit(null);
		$invalidSession->save();
		
		return $invalidSession;
	}
	
	public static function getCacheInvalidationKeys()
	{
		return array(array("invalidSession:hs=%s", self::HS));		
	}
	
} // invalidSessionPeer
