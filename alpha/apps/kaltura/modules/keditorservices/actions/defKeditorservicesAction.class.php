<?php
/**
 * @package    Core
 * @subpackage kEditorServices
 */
class defKeditorservicesAction extends kalturaAction
{
	//	protected $hshow_id;
	//	protected $hshow;
	// the objects bellow are actually the user's session 
	protected $partner_id;
	protected $subp_id;
	protected $hs_str;
	protected $uid; 
	
	protected function fetchHshow()
	{
		return true;
	}
	/**
	 * This function will be implemented in eash of the derived convrete classes which represent a service
	 * for Keditor.
	 * To simplifu work - it will be passed the $this->hshow which will never be null.
	 */
/*
	abstract protected function executeImpl( $hshow ); 

	abstract protected function noSuchHshow ( $hshow_id );
	*/
		
	public function execute()
	{
		//$this->debug = @$_REQUEST["debug"];
		$this->debug = false;

		$entry_id = @$_REQUEST["entry_id"];
		if ( $entry_id == NULL || !$entry_id || $entry_id < 0 )
		{
			$hshow_id = @			$kshow_id = @$_REQUEST["kshow_id"];REQUEST["hshow_id"];
			if ($hshow_id)
			{
				$hshow = hshowPeer::retrieveByPK( $hshow_id );
				if ( ! $hshow ) return; // request for non-existing hshow_id
				$entry_id = $hshow->getShowEntryId();
			}
		}
		
		if ( $entry_id == NULL || !$entry_id || $entry_id < 0 )
			return;
		
		$this->partner_id = $this->getRequestParameter( "partner_id" ); 
		$this->subp_id = $this->getRequestParameter( "subp_id" );
		$this->hs_str = $this->getRequestParameter( "hs" );
		$this->uid = $this->getRequestParameter( "uid" );
		
		$this->entry_id = $entry_id;
		$entry = entryPeer::retrieveByPK($entry_id);
		
		if ( $entry == NULL )
		{
			$this->noSuchEntry( $entry_id );
			return;
		}
		
		if ( $this->fetchHshow() )
		{
			$hshow_id = $entry->getHshowId();
			
			//$hshow_id = @			//$kshow_id = @$_REQUEST["kshow_id"];REQUEST["hshow_id"];
			$this->hshow_id = $hshow_id;
	
			if ( $hshow_id == NULL || !$hshow_id ) return;
	
			$hshow = hshowPeer::retrieveByPK( $hshow_id );
	// TODO - PRIVILEGES
	/*		$user_ok = $this->forceEditPermissions( $hshow , $hshow_id , false);
			
			if ( ! $user_ok )
			{
				return $this->securityViolation( $hshow_id ); 
			}
	*/
			if ( $hshow == NULL )
			{
				$this->noSuchHshow ( $hshow_id );
				return;
			}
		}
		else
		{
			
			$hshow = new hshow();
			$hshow_id = $entry->getHshowId();
			$this->hshow_id = $hshow_id;
		}
		
		// TODO
		// validate editor has proper privileges !
		//$this->forceAuthentication();

		$this->entry = $entry;
		$this->hshow = $hshow;
		$duration = 0;
		
//		$this->logMessage ( __CLASS__ . " 888 $hshow_id"  , "err");
		
		$result = $this->executeImpl( $this->hshow, $this->entry );
		
		if ( $result != NULL )
		{
			$this->getResponse()->setHttpHeader ( "Content-Type" , $result );
		}
		else
		{
			$this->getResponse()->setHttpHeader ( "Content-Type" , "text/xml; charset=utf-8" );
		}
		
		$this->getController()->setRenderMode ( sfView::RENDER_CLIENT );
	}
	
	protected function executeImpl( hshow $hshow, entry &$entry)
	{
		return "text/html; charset=utf-8";
	}

	protected function noSuchEntry ( $entry_id )
	{
		$this->xml_content = "No such entry [$entry_id]";
	}
	
	protected function noSuchHshow ( $hshow_id )
	{
		$this->xml_content = "No such show [$hshow_id]";
	}
	
	
	protected function  securityViolation( $hshow_id )
	{
		$xml = "<xml><hshow id=\"$hshow_id\" securityViolation=\"true\"/></xml>";
		$this->getResponse()->setHttpHeader ( "Content-Type" , "text/xml; charset=utf-8" );
		$this->getController()->setRenderMode ( sfView::RENDER_NONE );
		return $this->renderText( $xml );
	}
	
	
	/**
	 * Supports backward compatibility
	 * returns all kusers of the puser
	 */
	protected function getLoggedInUserIds ( )
	{
		$ret = array($this->getLoggedInPuserId());
		
		$c = new Criteria();
		$c->add(kuserPeer::PUSER_ID, $this->uid);
		$kusers = kuserPeer::doSelect($c);
		
		foreach($kusers as $kuser)
			$ret[] = $kuser->getId();
			
		return $ret;
	}
	
	protected function getLoggedInUserId ( )
	{
		if ( $this->partner_id )
		{
			// this part overhere should be in a more generic place - part of the services
			$hs = "";
			// TODO - for now ignore the session
			$valid = true; // ( 0 >= hSessionUtils::validateHSession ( $this->partner_id , $this->uid , $this->hs_str ,&$hs ) );
			if ( $valid )
			{
				$puser_id = $this->uid;
				// actually the better user indicator will be placed in the hs - TODO - use it !! 
				// $puser_id = $hs->user; 
				
				$kuser_name = $puser_name = $this->getP ( "user_name" );
				if ( ! $puser_name )
				{
					$kuser_name = myPartnerUtils::getPrefix( $this->partner_id ) . $puser_id;
				}
				// will return the existing one if any, will create is none
				$puser_kuser = PuserKuserPeer::createPuserKuser ( $this->partner_id , $this->subp_id, $puser_id , $kuser_name , $puser_name, false  );
				$likuser_id = $puser_kuser->getKuserId(); // from now on  - this will be considered the logged in user
				return $likuser_id;
			}

		}
		else
		{	
			return parent::getLoggedInUserId();
		}
	}
	
	protected function 	allowMultipleRoughcuts ( )
	{	
		$this->logMessage( "allowMultipleRoughcuts: [" . $this->partner_id . "]");
		if ( $this->partner_id == null ) return true;
		else
		{
			// this part overhere should be in a more generic place - part of the services
			$multiple_roghcuts = Partner::allowMultipleRoughcuts( $this->partner_id );
			return $multiple_roghcuts;
		}
	}		
}


?>
