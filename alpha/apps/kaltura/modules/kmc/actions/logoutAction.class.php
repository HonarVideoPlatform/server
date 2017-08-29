<?php
/**
 * @package    Core
 * @subpackage KMC
 */
class logoutAction extends kalturaAction
{
	public function execute ( ) 
	{
		$hsStr = $this->getP("hs");
		if($hsStr) {
			$hsObj = null;
			try
			{
				$hsObj = hs::fromSecureString($hsStr);
			}
			catch(Exception $e)
			{				
			}
				
			if ($hsObj)
			{
				$partner = PartnerPeer::retrieveByPK($hsObj->partner_id);
				if (!$partner)
					KExternalErrors::dieError(KExternalErrors::PARTNER_NOT_FOUND);
						
				if (!$partner->validateApiAccessControl())
					KExternalErrors::dieError(KExternalErrors::SERVICE_ACCESS_CONTROL_RESTRICTED);
				
				$hsObj->kill();
			}
			KalturaLog::info("Killing session with hs - [$hsStr], decoded - [".base64_decode($hsStr)."]");
		}
		else {
			KalturaLog::err('logoutAction called with no HS');
		}
		
		setcookie('pid', "", 0, "/");
		setcookie('subpid', "", 0, "/");
		setcookie('kmchs', "", 0, "/");

		return sfView::NONE; //redirection to kmc/kmc is done from java script
	}
}
