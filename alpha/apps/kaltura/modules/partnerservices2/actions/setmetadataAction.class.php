<?php
/**
 * @package api
 * @subpackage ps2
 */
class setmetadataAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "setMetaData",
				"desc" => "",
				"in" => array (
					"mandatory" => array ( 
						"entry_id" => array ("type" => "string", "desc" => ""),
						"hshow_id" => array ("type" => "string", "desc" => ""),
						"HasRoughCut" => array ("type" => "boolean", "desc" => ""),
						"xml" => array ("type" => "xml", "desc" => "")
						),
					"optional" => array (
						)
					),
				"out" => array (
					"saved_entry" => array ("type" => "string", "desc" => ""),
					"xml" => array ("type" => "xml", "desc" => "")
					),
				"errors" => array (
					APIErrors::INVALID_HSHOW_ID , 
					APIErrors::INVALID_ENTRY_ID ,				
				)
			); 
	}
	
	public function addUserOnDemand ( )		{	return self::CREATE_USER_FORCE;	}
	public function needKuserFromPuser ( )	{	return self::KUSER_DATA_KUSER_ID_ONLY;	}
	public function requiredPrivileges () 	{ 	return "edit:<hshow_id>" ; }

	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$entry_id = $this->getP ( "entry_id" );
		$hshow_id =  $this->getP ( "hshow_id" );
		
		list ( $hshow , $entry , $error , $error_obj ) = myHshowUtils::getHshowAndEntry( $hshow_id  , $entry_id );

		if ( $error_obj )
		{
			$this->addError ( $error_obj );
			return ;
		}

		$hshow_id = $hshow->getId();

		if ($hshow_id === hshow::SANDBOX_ID)
		{
			$this->addError ( APIErrors::SANDBOX_ALERT );
			return ;
		}
		
		// TODO -  think what is the best way to verify the privileges - names and parameters that are initially set by the partner at
		// startsession time
		if ( ! $this->isOwnedBy ( $hshow , $puser_kuser->getKuserId() ) )
			$this->verifyPrivileges ( "edit" , $hshow_id ); // user was granted explicit permissions when initiatd the ks

		// this part overhere should be in a more generic place - part of the services
		$multiple_roghcuts = Partner::allowMultipleRoughcuts( $partner_id );
		$likuser_id = $puser_kuser->getKuserId();

		$isIntro = $hshow->getIntroId() == $entry->getId();

		if ( $multiple_roghcuts )
		{
			// create a new entry in two cases:
			// 1. the user saving the roughcut isnt the owner of the entry
			// 2. the entry is an intro and the current entry is not show (probably an image or video)
			if ($entry->getKuserId() != $likuser_id || $isIntro && $entry->getMediaType() != entry::ENTRY_MEDIA_TYPE_SHOW)
			{
				// TODO: add security check to whether multiple roughcuts are allowed

				// create a new roughcut entry by cloning the original entry
				$entry = myEntryUtils::deepClone($entry, $hshow_id, false);
				$entry->setKuserId($likuser_id);
				$entry->setCreatorKuserId($puser_kuser->getKuserId() );
				$entry->setCreatedAt(time());
				$entry->setMediaType(entry::ENTRY_MEDIA_TYPE_SHOW);
				$entry->save();
			}
		}

		$xml_content = "<xml><EntryID>".$entry->getId()."</EntryID></xml>";

		if ($isIntro)
		{
			$hshow->setIntroId($entry->getId());
		}
		else
		{
			$hshow->setShowEntryId($entry->getId());
			$has_roughcut = $this->getP ( "HasRoughCut" , "1" , true );
			if ( $has_roughcut === "0" )
			{
				$hshow->setHasRoughcut( false) ;
				$hshow->save();
				$this->addMsg ( "saved_entry" , $entry->getId() );
				return ;
			}
		}

		$content = $this->getP ( "xml" );
		$update_hshow = false;

		if ( $content != NULL )
		{
			$version_info = array();
			$version_info["KuserId"] = $puser_kuser->getKuserId();
			$version_info["PuserId"] = $puser_id;
			$version_info["ScreenName"] = $puser_kuser->getPuserName();

			list($xml_content, $comments, $update_hshow) = myMetadataUtils::setMetadata($content, $hshow, $entry, false, $version_info);
		}
		else
		{
			$comments = "";
			// if there is no xml - receive it from the user
			$this->debug=true;
			return "text/html; charset=utf-8";
		}

		$this->addMsg ( "xml" , $xml_content );
		$this->addMsg ( "saved_entry" , $entry->getId() );
		$this->addDebug ( "comment" , $comments );

	}
}
?>
