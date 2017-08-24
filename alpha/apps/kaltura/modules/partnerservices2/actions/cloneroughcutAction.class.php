<?php
/**
 * @package api
 * @subpackage ps2
 */
class cloneroughcutAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "cloneRoughcut",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"entry_id" => array ("type" => "string", "desc" => "")
						),
					"optional" => array (
						"detailed" => array ("type" => "boolean", "desc" => "")
						)
					),
				"out" => array (
					"entry" => array ("type" => "entry", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_ENTRY_ID,
					APIErrors::HSHOW_CLONE_FAILED ,
				)
			); 
	}
	
	protected function ticketType ()
	{
		return self::REQUIED_TICKET_ADMIN;
	}

	// check to see if already exists in the system = ask to fetch the puser & the kuser
	// don't ask for  KUSER_DATA_KUSER_DATA - because then we won't tell the difference between a missing kuser and a missing puser_kuser
	public function needKuserFromPuser ( )
	{
		return self::KUSER_DATA_KUSER_ID_ONLY;
	}

	protected function addUserOnDemand ( )
	{
		return self::CREATE_USER_FROM_PARTNER_SETTINGS;
	}
	
	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$entry_id = $this->getPM ( "entry_id" );
		$detailed = $this->getP ( "detailed" , false );
		
		$entry = null;
		if ( $entry_id )
		{
			$entry = entryPeer::retrieveByPK( $entry_id );
		}
		
		if ( !$entry)
		{
			$this->addError ( APIErrors::INVALID_ENTRY_ID , $entry_id );
		}
		else
		{
			$hshow_id = $entry->getHshowId();
			$hshow = $entry->getHshow();
		
			if ( ! $hshow )
			{
				$this->addError ( APIErrors::INVALID_HSHOW_ID , $hshow_id );
			}
			else
			{
				$newHshow = myHshowUtils::shalowCloneById( $hshow_id , $puser_kuser->getKuserId() );
				
				if (!$newHshow)
				{
					$this->addError ( APIErrors::HSHOW_CLONE_FAILED , $hshow_id );
				}
				else
				{
					$newEntry = $newHshow->getShowEntry();
					
					$level = ( $detailed ? objectWrapperBase::DETAIL_LEVEL_DETAILED : objectWrapperBase::DETAIL_LEVEL_REGULAR );
					$wrapper = objectWrapperBase::getWrapperClass( $newEntry , $level );
					// TODO - remove this code when cache works properly when saving objects (in their save method)
					$wrapper->removeFromCache( "entry" , $newEntry->getId() );
					$this->addMsg ( "entry" , $wrapper ) ;
				}
			}
		}
	}
}
?>
