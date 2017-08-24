<?php
/**
 * @package api
 * @subpackage ps2
 */
class rollbackhshowAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "rollbackHShow",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"hshow_id" => array ("type" => "string", "desc" => ""),
						"hshow_version" => array ("type" => "integer", "desc" => "")
						),
					"optional" => array (
						)
					),
				"out" => array (
					"hshow" => array ("type" => "hshow", "desc" => "")
					),
				"errors" => array (
					APIErrors::ERROR_HSHOW_ROLLBACK , 
					APIErrors::INVALID_USER_ID , 
					APIErrors::INVALID_HSHOW_ID ,
				)
			); 
	}
	
	// ask to fetch the kuser from puser_kuser
	public function needKuserFromPuser ( )
	{
		return self::KUSER_DATA_KUSER_ID_ONLY;
	}

	// TODO - merge with updatehshow and add the functionality of rollbackVersion
	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		if ( ! $puser_kuser )
		{
			$this->addError ( APIErrors::INVALID_USER_ID ,  $puser_id);
			return;
		}

		$hshow_id = $this->getPM ( "hshow_id");
		
		$hshow = hshowPeer::retrieveByPK( $hshow_id );

		// even in case of an error - return the hshow object
		if ( ! $hshow )
		{
			$this->addError ( APIErrors::INVALID_HSHOW_ID , $hshow_id );
			return;
		}
		else
		{
			$desired_version = $this->getPM ( "hshow_version");
			$result = $hshow->rollbackVersion ( $desired_version );
		
			if ( ! $result )
			{
				$this->addError ( APIErrors::ERROR_HSHOW_ROLLBACK , $hshow_id ,$desired_version );
				return ;
			}
		}

		// after calling this method - most probably the state of the hshow has changed in the cache
		$wrapper = objectWrapperBase::getWrapperClass( $hshow , objectWrapperBase::DETAIL_LEVEL_REGULAR ) ;
		$wrapper->removeFromCache( "hshow" , $hshow_id );
		$this->addMsg ( "hshow" , $wrapper );
	}
}
?>
