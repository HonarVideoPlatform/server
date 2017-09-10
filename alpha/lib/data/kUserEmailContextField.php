<?php
/**
 * Represents the current session user e-mail address context 
 * @package Core
 * @subpackage model.data
 */
class kUserEmailContextField extends hStringField
{
	/* (non-PHPdoc)
	 * @see hStringField::getFieldValue()
	 */
	protected function getFieldValue(hScope $scope = null) 
	{
		if(!$scope)
			$scope = new hScope();
			
		$kuser = kuserPeer::getKuserByPartnerAndUid($scope->getHs()->partner_id, $scope->getHs()->user);
		return $kuser->getEmail();
	}
}