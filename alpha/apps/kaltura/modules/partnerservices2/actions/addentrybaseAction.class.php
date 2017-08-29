<?php
/**
 * @package api
 * @subpackage ps2
 */
abstract class addentrybaseAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "addEntryBase",
				"desc" => "Create a new entry" ,
				"in" => array (
					"mandatory" => array ( 
						"entry" => array ("type" => "entry", "desc" => ""),
						),
					"optional" => array (
						)
					),
				"out" => array (
					"entry" => array ("type" => "entry", "desc" => "")
					),
				"errors" => array (
					APIErrors::NO_FIELDS_SET_FOR_GENERIC_ENTRY ,
					APIErrors::INVALID_HSHOW_ID
				)
			); 
	}
	
	protected function getDetailed()
	{
		return $this->getP ( "detailed" , false );
	}
	
	protected function getObjectPrefix () {  return "entry"; }

	abstract protected function setTypeAndMediaType ( $entry ) ;
	
	protected function validateEntry ( $entry ) {}

	protected function getHshow ( $partner_id, $subp_id , $puser_kuser , $hshow_id , $entry )
	{
	    if ( $hshow_id == hshow::HSHOW_ID_USE_DEFAULT )
        {
            // see if the partner has some default hshow to add to
            $hshow = myPartnerUtils::getDefaultHshow ( $partner_id, $subp_id , $puser_kuser  );
            if ( $hshow ) $hshow_id = $hshow->getId();
        }
		elseif ( $hshow_id == hshow::HSHOW_ID_CREATE_NEW )
        {
            // if the partner allows - create a new hshow
            $hshow = myPartnerUtils::getDefaultHshow ( $partner_id, $subp_id , $puser_kuser , null , true );
            if ( $hshow ) $hshow_id = $hshow->getId();
        }   
		else
        {
            $hshow = hshowPeer::retrieveByPK( $hshow_id );
        }

        if ( ! $hshow )
        {
            // the partner is attempting to add an entry to some invalid or non-existing kwho
            $this->addError( APIErrors::INVALID_HSHOW_ID, $hshow_id );
            return;
        }	
        return $hshow;	
	}
	
	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$detailed = $this->getDetailed() ; //$this->getP ( "detailed" , false );
		$level = ( $detailed ? objectWrapperBase::DETAIL_LEVEL_DETAILED : objectWrapperBase::DETAIL_LEVEL_REGULAR );
		
		// get the new properties for the kuser from the request
		$entry = new entry();
		
		// this is called for the first time to set the type and media type for fillObjectFromMap
		$this->setTypeAndMediaType ( $entry );
		
		// important to set type before the auto-fill so the setDataContent will work properly
		$entry->setLengthInMsecs( 0 );
		
		$obj_wrapper = objectWrapperBase::getWrapperClass( $entry , 0 );
		
		$field_level = $this->isAdmin() ? 2 : 1;
		$updateable_fields = $obj_wrapper->getUpdateableFields( $field_level );
		
		$fields_modified = baseObjectUtils::fillObjectFromMap ( $this->getInputParams() , $entry , $this->getObjectPrefix() . "_" , $updateable_fields );
		// check that mandatory fields were set
		// TODO
		if ( count ( $fields_modified ) > 0 )
		{
			
			$hshow_id = $this->getP ( "hshow_id" , hshow::HSHOW_ID_USE_DEFAULT );						
			$hshow = $this->getHshow ( $partner_id , $subp_id , $puser_kuser , $hshow_id , $entry );
	        
			// force the type and media type
			// TODO - set the hshow to some default hshow of the partner - maybe extract it from the custom_data of this specific partner
			$entry->setHshowId ( $hshow_id );
			$entry->setStatus( entryStatus::READY );
			$entry->setPartnerId( $partner_id );
			$entry->setSubpId( $subp_id );
			$entry->setKuserId($puser_kuser->getKuserId() );
			$entry->setCreatorKuserId($puser_kuser->getKuserId() );

			// this is now called for the second time to force the type and media type
			$this->setTypeAndMediaType ( $entry );

			$this->validateEntry ( $entry );
			
			$entry->save();
										
			$this->addMsg ( $this->getObjectPrefix() , objectWrapperBase::getWrapperClass( $entry , $level ) );
			$this->addDebug ( "added_fields" , $fields_modified );
		}
		else
		{
			$this->addError( APIErrors::NO_FIELDS_SET_FOR_GENERIC_ENTRY , $this->getObjectPrefix() );
		}
	}
}
?>
