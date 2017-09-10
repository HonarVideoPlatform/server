<?php
/**
 * @package api
 * @subpackage ps2
 */
class addroughcutentryAction extends defPartnerservices2Action
{
	public function describe()
	{
		return 
			array (
				"display_name" => "addRoughcutEntry",
				"desc" => "Create a new roughcut entry" ,
				"in" => array (
					"mandatory" => array (
						"hshow_id" => array ("type" => "integer"), 
						"entry" => array ("type" => "entry", "desc" => "Entry of type ENTRY_TYPE_SHOW"),
						),
					"optional" => array (
						)
					),
				"out" => array (
					"entry" => array ("type" => "entry", "desc" => "Entry of type ENTRY_TYPE_SHOW")
					),
				"errors" => array (
					APIErrors::INVALID_HSHOW_ID
				)
			); 
	}
	
	protected function addUserOnDemand () { return self::CREATE_USER_FORCE; }
	
	protected function ticketType()			{	return self::REQUIED_TICKET_REGULAR;	} // TODO - and admin ticket

	protected function getObjectPrefix () { return "entry"; }

	public function executeImpl ( $partner_id , $subp_id , $puser_id , $partner_prefix , $puser_kuser )
	{
		$hshow_id = $this->getP ( "hshow_id" , hshow::HSHOW_ID_USE_DEFAULT );

		$entry = null;
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
            if ( $hshow )
            {
            	$hshow_id = $hshow->getId();
       	        $entry = $hshow->getShowEntry(); // use the newly created hshow's roughcut
            }
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
        
		if (!$entry)
		{
			$entry = $hshow->createEntry( entry::ENTRY_MEDIA_TYPE_SHOW , $hshow->getProducerId() , "&auto_edit.jpg" , "" ); 
		}
           
        $obj_wrapper = objectWrapperBase::getWrapperClass( $entry , 0 );
		
		$fields_modified = baseObjectUtils::fillObjectFromMap ( $this->getInputParams() , $entry , $this->getObjectPrefix() . "_" , 
			array ( "name"  , "tags" , "groupId" , "partnerData", "permissions" , "screenName",  "description", "indexedCustomData1") );
        
		$entry->save();
									
		$this->addMsg ( $this->getObjectPrefix() , objectWrapperBase::getWrapperClass( $entry , objectWrapperBase::DETAIL_LEVEL_REGULAR ) );
		$this->addDebug ( "added_fields" , $fields_modified );
	}
}
?>