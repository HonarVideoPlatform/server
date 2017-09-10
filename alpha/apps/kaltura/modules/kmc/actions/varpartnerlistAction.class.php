<?php
/**
 * Test page for adding JW player to KMC
 *
 * @package    Core
 * @subpackage KMC
 */
class varpartnerlistAction extends kalturaAction
{
	public function execute ( )
	{
		$email = @$_GET['email'];
		$screenName = @$_GET['screen_name'];
		$partner_id = $this->getP('partner_id', null);
		if($partner_id === null)
		{
			header("Location: /index.php/kmc/varlogin");
			die;
		}

		sfView::SUCCESS;

		$this->me = PartnerPeer::retrieveByPK($this->getP('partner_id', null));
		if(!$this->me || $this->me->getPartnerGroupType() != PartnerGroupType::VAR_GROUP)
		{
			die('You are not an wuthorized VAR. If you are a VAR, Please contact us at support@kaltura.com');
		}

		$hs = hSessionUtils::crackHs($this->getP('hs'));
		$user = $hs->user;
		$res = hSessionUtils::validateHSession2(hSessionUtils::REQUIED_TICKET_ADMIN, $partner_id, $user, $this->getP('hs'), $hs);
		if($res != hs::OK)
		{
			header("Location: /index.php/kmc/varlogin");
			die;
		}

		$c = new Criteria;
		$c->addAnd(PartnerPeer::PARTNER_PARENT_ID, $this->me->getId());
		// add extra filtering if required
		//$c->addAnd(PartnerPeer::STATUS, 1);
		$partners = PartnerPeer::doSelect($c);
		$this->partners = array();
		$partner_id_param_name = 'pid';
		$subpid_param_name = 'subpid';
		if($this->me->getKmcVersion() == 1)
		{
			$partner_id_param_name = 'partner_id';
			$subpid_param_name = 'subp_id';
		}
		$kmc2Query = '?'.$partner_id_param_name.'='.$this->me->getId().'&'.$subpid_param_name.'='.($this->me->getId()*100).'&hs='.$_GET['hs'].'&email='.$email.'&screen_name='.$screenName;
		$this->varKmcUrl = 'http://'.kConf::get('www_host').'/index.php/kmc/kmc'.$this->me->getKmcVersion().$kmc2Query;
		foreach($partners as $partner)
		{
			$hs = null;
			hSessionUtils::createHSessionNoValidations ( $partner->getId() ,  $partner->getAdminUserId() , $hs , 30 * 86400 , 2 , "" , "*" );
			$adminUser_email = $partner->getAdminEmail();
			$partner_id_param_name = 'pid';
			$subpid_param_name = 'subpid';
			if($partner->getKmcVersion() == 1)
			{
				$partner_id_param_name = 'partner_id';
				$subpid_param_name = 'subp_id';
			}
			$kmc2Query = '?'.$partner_id_param_name.'='.$partner->getId().'&'.$subpid_param_name.'='.($partner->getId()*100).'&hs='.$hs.'&email='.$adminUser_email.'&screen_name=varAdmin';
			//$kmcLink = url_for('index.php/kmc/kmc2'.$kmc2Query);
//			$kmcLink = 'http://'.kConf::get('www_host').'/index.php/kmc/kmc'.$partner->getKmcVersion().$kmc2Query;
			$kmcLink = 'http://'.kConf::get('www_host')."/index.php/kmc/extlogin?hs=$hs&partner_id=" . $partner->getId();
			$this->partners[$partner->getId()] = array(
				'name' => $partner->getPartnerName(),
				'kmcLink' => $kmcLink,
			);
		}
	}
}
