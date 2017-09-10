<?php
/**
 * @package api
 * @subpackage ps2
 */
class addhshowAction extends defPartnerservices2Action
{
	public function describe()
	{
		return
			array (
				"display_name" => "addHShow",
				"desc" => "" ,
				"in" => array (
					"mandatory" => array (
						"hshow" 				=> array ("type" => "hshow", "desc" => "hshow"),
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
					APIErrors::DUPLICATE_HSHOW_BY_NAME
				)
			);
	}
/*
	protected function ticketType ()
	{
		return self::REQUIED_TICKET_ADMIN;
	}
*/
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
		$hshows_from_db = null;
		// works in one of 2 ways:
		// 1. get no requested name - will create a new hshow and return its details
		// 2. get some name - tries to fetch by name. if already exists - return it

		// get the new properties for the kuser from the request
		$hshow = new hshow();

		$allow_duplicate_names = $this->getP ( "allow_duplicate_names" , true , true );
		if ( $allow_duplicate_names === "false" || $allow_duplicate_names === 0 ) $allow_duplicate_names = false;

		$return_metadata = $this->getP ( "metadata" , false );
		$detailed = $this->getP ( "detailed" , false );
		$level = ( $detailed ? objectWrapperBase::DETAIL_LEVEL_DETAILED : objectWrapperBase::DETAIL_LEVEL_REGULAR );

		$obj_wrapper = objectWrapperBase::getWrapperClass( $hshow , 0 );

		$fields_modified = baseObjectUtils::fillObjectFromMap ( $this->getInputParams() , $hshow , "hshow_" , $obj_wrapper->getUpdateableFields() );
		// check that mandatory fields were set
		// TODO
		$hshow->setName( trim ( $hshow->getName() ) );
		// ASSUME - the name is UNIQUE per partner_id !

		if ( $hshow->getName() )
		{
			if ( myPartnerUtils::shouldForceUniqueHshow( $partner_id , $allow_duplicate_names ) )
			{
				// in this case willsearch for an existing hshow with this name and return with an error if found
				$hshows_from_db = hshowPeer::getHshowsByName ( trim ( $hshow->getName() ) );
				if ( $hshows_from_db )
				{
					$hshow_from_db = $hshows_from_db[0];
					$this->addDebug ( "already_exists_objects" , count ( $hshows_from_db ) );
					$this->addError ( APIErrors::DUPLICATE_HSHOW_BY_NAME, $hshow->getName() ) ;// This field in unique. Please change ");
					if( myPartnerUtils::returnDuplicateHshow( $partner_id ))
					{
						$this->addMsg ( "hshow" , objectWrapperBase::getWrapperClass( $hshow_from_db , $level  ) );
					}
					return;
				}
			}
		}


		// the first kuser to create this hshow will be it's producer
		$producer_id =   $puser_kuser->getKuserId();
		$hshow->setProducerId( $producer_id );
		// moved to the update - where there is

		$hshow->setPartnerId( $partner_id );
		$hshow->setSubpId( $subp_id );
		$hshow->setViewPermissions( hshow::HSHOW_PERMISSION_EVERYONE );

		// by default the permissions should be public
		if ( $hshow->getPermissions () === null )
		{ 
			$hshow->setPermissions( hshow::PERMISSIONS_PUBLIC );
		}
		
		// have to save the hshow before creating the default entries
		$hshow->save();
		$show_entry = $hshow->createEntry( entry::ENTRY_MEDIA_TYPE_SHOW , $producer_id , "&auto_edit.jpg" , $hshow->getName() ); // roughcut
		$hshow->createEntry( entry::ENTRY_MEDIA_TYPE_VIDEO , $producer_id ); // intro
/*
		$sample_text = $hshow->getName();
		$host = requestUtils::getHost();
*/
		$sample_text = "";
		myEntryUtils::modifyEntryMetadataWithText ( $show_entry , $sample_text , "" );

		// set the roughcut to false so the update iwll override with better data
		$hshow->setHasRoughcut( false );

		$hshow->initFromTemplate ( $producer_id , $sample_text);

		$hshow->save();

		myNotificationMgr::createNotification( kNotificationJobData::NOTIFICATION_TYPE_HSHOW_ADD , $hshow );

		$this->addMsg ( "hshow" , objectWrapperBase::getWrapperClass( $hshow ,  $level  ) );

		if ( $return_metadata )
		{
			$this->addMsg ( "metadata" , $hshow->getMetadata() );
		}

		$this->addDebug ( "added_fields" , $fields_modified );
		if ( $hshows_from_db )
			$this->addDebug ( "already_exists_objects" , count ( $hshows_from_db ) );

	}
}
?>