<?php
/**
 * @package api
 * @subpackage ps2
 */
class updatehshowownerAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "updateHshowOwner",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"hshow_id" => array ("type" => "string", "desc" => "")
						),
					"optional" => array (
						"detailed" => array ("type" => "boolean", "desc" => "")
						)
					),
				"out" => array (
					"hshow" => array ("type" => "hshow", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_HSHOW_ID,
					APIErrors::INVALID_USER_ID,
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
		$hshow_id = $this->getPM ( "hshow_id" );
		$target_puser_id = $this->getPM ( "user_id" );
		$detailed = $this->getP ( "detailed" , false );
		$hshow_indexedCustomData3 = $this->getP ( "indexedCustomData3" );
		$hshow = null;
		if ( $hshow_id )
		{
			$hshow = hshowPeer::retrieveByPK( $hshow_id );
		}
		elseif ( $hshow_indexedCustomData3 )
		{
			$hshow = hshowPeer::retrieveByIndexedCustomData3( $hshow_indexedCustomData3 );
		}

		if ( ! $hshow )
		{
			$this->addError ( APIErrors::INVALID_HSHOW_ID , $hshow_id );
		}
		else
		{
			$new_puser_kuser = PuserKuserPeer::retrieveByPartnerAndUid( $partner_id , null , $target_puser_id );
			if ( ! $new_puser_kuser )
			{
				$this->addError ( APIErrors::INVALID_USER_ID , $target_puser_id );
				return;
			}
 			$hshow->setProducerId ( $new_puser_kuser->getKuserId() );
 			$hshow->save();

 			$level = ( $detailed ? objectWrapperBase::DETAIL_LEVEL_DETAILED : objectWrapperBase::DETAIL_LEVEL_REGULAR );
			$wrapper = objectWrapperBase::getWrapperClass( $hshow , $level );
			// TODO - remove this code when cache works properly when saving objects (in their save method)
			$wrapper->removeFromCache( "hshow" , $hshow->getId() );
			$this->addMsg ( "hshow" , $wrapper ) ;
		}
	}
}
?>