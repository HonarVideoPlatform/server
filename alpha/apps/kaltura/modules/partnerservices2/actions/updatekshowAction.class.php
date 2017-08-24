<?php
/**
 * @package api
 * @subpackage ps2
 */
class updatehshowAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "updateHShow",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array ( 
						"hshow_id"				=> array ("type" => "string", "desc" => ""),
						"hshow" 				=> array ("type" => "hshow", "desc" => ""),
						),
					"optional" => array (
						"detailed" 				=> array ("type" => "boolean", "desc" => ""),
						"allow_duplicate_names" => array ("type" => "boolean", "desc" => "")
						)
					),
				"out" => array (
					"hshow" => array ("type" => "hshow", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_USER_ID , 
					APIErrors::INVALID_HSHOW_ID ,
					APIErrors::DUPLICATE_HSHOW_BY_NAME ,
					APIErrors::ERROR_HSHOW_ROLLBACK
				)
			); 
	}
	
	// ask to fetch the kuser from puser_kuser
	public function needKuserFromPuser ( )	{		return self::KUSER_DATA_KUSER_ID_ONLY;	}
	public function requiredPrivileges () { return "edit:<hshow_id>" ; }

	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		if ( ! $puser_kuser )
		{
			$this->addError ( APIErrors::INVALID_USER_ID ,  $puser_id );
			return;
		}

		// get the new properties for the hshow from the request
		$hshow_update_data = new hshow();

		$start_obj_creation = microtime( true );
		$hshow = new hshow();
		$obj_wrapper = objectWrapperBase::getWrapperClass( $hshow  , 0 );
//		$this->addDebug ( "timer_getWrapperClass1" , ( microtime( true ) - $start_obj_creation ) );

		$timer = microtime( true );
		$fields_modified = baseObjectUtils::fillObjectFromMap ( $this->getInputParams() ,
			$hshow ,
			"hshow_" ,
			$obj_wrapper->getUpdateableFields() );

//		$this->addDebug ( "timer_fillObjectFromMap" , ( microtime( true ) - $timer ) );

		$hshow->setName( trim ( $hshow->getName() ) );

		$hshow_id = $this->getPM ( "hshow_id");
		$detailed = $this->getP ( "detailed" , false );
		$allow_duplicate_names = $this->getP ( "allow_duplicate_names" , true , true );
		if ( $allow_duplicate_names === "false" || $allow_duplicate_names === 0 ) $allow_duplicate_names = false;

		if ( count ( $fields_modified ) > 0 )
		{
			$timer = microtime( true );
			$hshow_from_db = hshowPeer::retrieveByPK( $hshow_id );
			if ( ! $hshow_from_db )
			{
				// hshow with this id does not exists in the DB
				$this->addError ( APIErrors::INVALID_HSHOW_ID ,  $hshow_id );

				return;
			}

			if ( ! $this->isOwnedBy ( $hshow_from_db , $puser_kuser->getKuserId() ) )
				$this->verifyPrivileges ( "edit" , $hshow_id ); // user was granted explicit permissions when initiatd the ks

							
			if ( myPartnerUtils::shouldForceUniqueHshow( $partner_id , $allow_duplicate_names ) )
			{
				$hshow_with_name_from_db = hshowPeer::getFirstHshowByName( $hshow->getName() );
				if ( $hshow_with_name_from_db && $hshow_with_name_from_db->getId() != $hshow_id )
				{
					$this->addError( APIErrors::DUPLICATE_HSHOW_BY_NAME ,   $hshow->getName() );
					$level = ( $detailed ? objectWrapperBase::DETAIL_LEVEL_DETAILED : objectWrapperBase::DETAIL_LEVEL_REGULAR );
					if( myPartnerUtils::returnDuplicateHshow( $partner_id ))
					{
						$this->addMsg ( "hshow" , objectWrapperBase::getWrapperClass( $hshow_from_db , $level  ) );
					}					
					return;
				}
			}

			$this->addMsg ( "old_hshow" , objectWrapperBase::getWrapperClass( $hshow_from_db->copy() , objectWrapperBase::DETAIL_LEVEL_REGULAR ) );

//			$this->addDebug ( "timer_db_retrieve" , ( microtime( true ) - $timer ) );

			$timer = microtime( true );
			// copy relevant fields from $hshow -> $hshow_update_data
			baseObjectUtils::fillObjectFromObject( $obj_wrapper->getUpdateableFields() ,
				$hshow ,
				$hshow_from_db ,
				baseObjectUtils::CLONE_POLICY_PREFER_NEW , null , BasePeer::TYPE_PHPNAME );

//			$this->addDebug ( "timer_fillObjectFromObject" , ( microtime( true ) - $timer ) );

			$timer = microtime( true );

			// TODO - move to some generic place myHshowUtils / hshow.php
			// TODO - this should be called only for the first time or whenever the user wants to force overriding the sample_text
			$force_sample_text = $this->getP ( "force_sample_text" , false );
			$force_sample_text = false;

			$kuser_id = $puser_kuser->getKuserId();
/*
			$sample_text = "This is a collaborative video for &#xD;'" . $hshow_from_db->getIndexedCustomData3() . "'.&#xD;Click 'Add to Video' to get started";
			$hshow_from_db->initFromTemplate ( $kuser_id ,$sample_text );
*/
			// be sure to save the $hshow_from_db and NOT $hshow - this will create a new entry in the DB
			$hshow_from_db->save();
			
			// update the name of the roughcut too
			$show_entry_id = $hshow_from_db->getShowEntryId();
			$showEntry = entryPeer::retrieveByPK($show_entry_id);
			if ($showEntry)
			{
				$showEntry->setName($hshow_from_db->getName());
				$showEntry->save();
			}


			// TODO - decide which of the notifications should be called
			myNotificationMgr::createNotification( kNotificationJobData::NOTIFICATION_TYPE_HSHOW_UPDATE_INFO , $hshow_from_db );
			// or
			//myNotificationMgr::createNotification( notification::NOTIFICATION_TYPE_HSHOW_UPDATE_PERMISSIONS , $hshow_from_db );

//			$this->addDebug ( "timer_db_save" , ( microtime( true ) - $timer ) );


			$end_obj_creation = microtime( true );
			$this->addDebug ( "obj_creation_time" , ( $end_obj_creation - $start_obj_creation ) );
		}
		else
		{
			$hshow_from_db = $hshow;
			// no fiends to update !
		}


		// see if trying to rollback
		$desired_version = $this->getP ( "hshow_version");
		if ( $desired_version )
		{
			$result = $hshow_from_db->rollbackVersion ( $desired_version );

			if ( ! $result )
			{
				$this->addError ( APIErrors::ERROR_HSHOW_ROLLBACK , $hshow_id , $desired_version);
			}
		}

		$this->addMsg ( "hshow" , objectWrapperBase::getWrapperClass( $hshow_from_db , objectWrapperBase::DETAIL_LEVEL_REGULAR ) );
		$this->addDebug ( "modified_fields" , $fields_modified );

	}
}
?>
