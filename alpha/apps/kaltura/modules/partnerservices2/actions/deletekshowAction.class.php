<?php
/**
 * After making sure the ticket is a valid admin ticket - the setrvice is allowed and no other validations should be done
 * 
 * @package api
 * @subpackage ps2
 */
class deletehshowAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "deleteHShow",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"hshow_id" => array ("type" => "string", "desc" => "")
						),
					"optional" => array (
						)
					),
				"out" => array (
					"deleted_hshow" => array ("type" => "hshow", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_HSHOW_ID ,
				)
			); 
	}
	
	protected function ticketType()			{		return self::REQUIED_TICKET_ADMIN;	}
	// ask to fetch the kuser from puser_kuser - so we can tel the difference between a 
	public function needKuserFromPuser ( )	{		return self::KUSER_DATA_KUSER_ID_ONLY;	}
	
	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$hshow_id_to_delete = $this->getPM ( "hshow_id" );
		
		$hshow_to_delete = hshowPeer::retrieveByPK( $hshow_id_to_delete );
		
		if ( ! $hshow_to_delete )
		{
			$this->addError( APIErrors::INVALID_HSHOW_ID , $hshow_id_to_delete );
			return;		
		}

		$hshow_to_delete->delete();

		myNotificationMgr::createNotification( kNotificationJobData::NOTIFICATION_TYPE_HSHOW_DELETE , $hshow_to_delete );
		
		$this->addMsg ( "deleted_hshow" , objectWrapperBase::getWrapperClass( $hshow_to_delete , objectWrapperBase::DETAIL_LEVEL_REGULAR) );
	}
}
?>
