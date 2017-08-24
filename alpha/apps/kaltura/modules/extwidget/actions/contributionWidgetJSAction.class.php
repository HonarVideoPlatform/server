<?php
/**
 * @package Core
 * @subpackage externalWidgets
 */
require_once ( MODULES . "/partnerservices2/actions/startsessionAction.class.php" );

/**
 * @package Core
 * @subpackage externalWidgets
 */
class contributionWidgetJSAction extends kalturaAction
{
	public function execute()
	{
		$this->getResponse()->setHttpHeader("Content-Type", "application/x-javascript");
		
		$hshow_id = $this->getRequestParameter('hshow_id', 0);
		$uid = kuser::ANONYMOUS_PUSER_ID;
		$hshow = hshowPeer::retrieveByPK($hshow_id);
	
		if (!$hshow)
			return sfView::ERROR;
		
		// hshow_id might be a string (something like "15483str") but it will be returned using retriveByPK anyways
		// lets make sure we pass just the id to the contribution wizard
		$hshow_id = $hshow->getId();
		
		$partner_id = $hshow->getPartnerId();
		
		$partner = PartnerPeer::retrieveByPK($partner_id);
		$subp_id = $hshow->getSubpId();
		$partner_secret = $partner->getSecret();
		$partner_name = $partner->getPartnerName();
				
		$kaltura_services = new startsessionAction();
		$kaltura_services->setInputParams( 
			array (
				"format" => kalturaWebserviceRenderer::RESPONSE_TYPE_PHP_ARRAY, 
				"partner_id" => $partner_id, 
				"subp_id" => $subp_id, 
				"uid" => $uid, 
				"secret" => $partner_secret
			)
		);
		
		$result = $kaltura_services->internalExecute() ;
		
		$this->ks = @$result["result"]["ks"];
		$this->widget_host = requestUtils::getHost();
		$this->hshow_id = $hshow_id;
		$this->uid = $uid;
		$this->partner_id = $partner_id;
		$this->subp_id = $subp_id;
		$this->partner_name  = $partner_name;
	
		return sfView::SUCCESS;
	}
}
