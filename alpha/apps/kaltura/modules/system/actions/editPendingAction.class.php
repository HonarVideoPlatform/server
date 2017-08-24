<?php
/**
 * @package    Core
 * @subpackage system
 * @deprecated
 */
require_once ( __DIR__ . "/kalturaSystemAction.class.php" );

/**
 * @package    Core
 * @subpackage system
 * @deprecated
 */
class editPendingAction extends kalturaSystemAction
{

	public function execute()
	{
		$this->forceSystemAuthentication();
		
		$hshow_id = @$_REQUEST["hshow_id"];
		$this->hshow_id = $hshow_id;
		$this->hshow = NULL;
		
		$entry_id = @$_REQUEST["entry_id"];
		$this->entry_id = $entry_id;
		$this->entry = NULL;
		
		$this->message =  "";
		if ( !empty ( $hshow_id ))
		{
			$this->hshow = hshowPeer::retrieveByPK( $hshow_id );
			if (  ! $this->hshow )
			{
				$this->message = "Cannot find hshow [$hshow_id]";
			}
			else
			{
				$this->entry = $this->hshow->getShowEntry();
			} 
		}
		elseif ( !empty ( $hshow_id ))
		{
			$this->entry = entryPeer::retrieveByPK( $entry_id );
			if ( ! $this->entry )
			{
				$this->message = "Cannot find entry [$entry_id]";
			}
			else
			{
				$this->hshow = $this->$this->entry->getHshow();
			}
		}
		
		if ( $this->hshow )
		{
			$this->metadata = $this->hshow->getMetadata();
		}
		else
		{
			$this->metadata = "";
		}
		
		$pending_str = $this->getP ( "pending" );
		$remove_pending = $this->getP ( "remove_pending" );
		
		
		if ( $this->metadata && ( $remove_pending || $pending_str ) )
		{
			if  ( $remove_pending )				$pending_str = "";
			
			$xml_doc = new DOMDocument();
			$xml_doc->loadXML( $this->metadata );
			$metadata = kXml::getFirstElement( $xml_doc , "MetaData" );
			$should_save = kXml::setChildElement( $xml_doc , $metadata , "Pending" , $pending_str , true );
			if  ( $remove_pending )
				$should_save = kXml::setChildElement( $xml_doc , $metadata , "LastPendingTimeStamp" /*myMetadataUtils::LAST_PENDING_TIMESTAMP_ELEM_NAME*/ , "" , true );
			
			if ( $should_save )
			{
				$fixed_content = $xml_doc->saveXML();
				$content_dir =  myContentStorage::getFSContentRootPath();
				$file_name = realpath( $content_dir . $this->entry->getDataPath( ) );
				
				$res = file_put_contents( $file_name , $fixed_content ); // sync - NOTOK 
				
				$this->metadata = $fixed_content;
			}
		}
		
		$this->pending = $pending_str;
		
		$this->hshow_id = $hshow_id;
		$this->entry_id = $entry_id;
	}
}
?>
