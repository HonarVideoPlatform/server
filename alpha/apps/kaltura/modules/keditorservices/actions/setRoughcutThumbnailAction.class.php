<?php
/**
 * @package    Core
 * @subpackage kEditorServices
 */
require_once ( __DIR__ . "/defKeditorservicesAction.class.php");

/**
 * @package    Core
 * @subpackage kEditorServices
 */
class setRoughcutThumbnailAction extends defKeditorservicesAction
{
	protected function executeImpl( hshow $hshow, entry &$entry )
	{
		$this->res = "";
		
		$likuser_id = $this->getLoggedInUserId();

		// if we allow multiple rouchcuts - there is no reason for one suer to override someone else's thumbnail
		if ( $this->allowMultipleRoughcuts()  )
		{
			if ( $likuser_id != $entry->getKuserId())
			{
				// ERROR - attempting to update an entry which doesnt belong to the user
				return "<xml>!!</xml>";//$this->securityViolation( $hshow->getId() );
			}
		}

		$debug = @$_GET["debug"];
		/*
		$hshow_id = @		$kshow_id = @$_GET["kshow_id"];GET["hshow_id"];
		$debug = @$_GET["debug"];
		
		$this->hshow_id = $hshow_id;

		if ( $hshow_id == NULL || $hshow_id == 0 ) return;

		$hshow = hshowPeer::retrieveByPK( $hshow_id );
		
		if ( ! $hshow ) 
		{
			$this->res = "No hshow " . $hshow_id ;
			return;	
		}

		// is the logged-in-user is not an admin or the producer - check if show can be published	
		$likuser_id = $this->getLoggedInUserId();
		$viewer_type = myHshowUtils::getViewerType($hshow, $likuser_id);
		if ( $viewer_type != HshowKuser::HSHOWKUSER_VIEWER_PRODUCER && ( ! $hshow->getCanPublish() ) ) 
		{
			// ERROR - attempting to publish a non-publishable show
			return "<xml>!</xml>";//$this->securityViolation( $hshow->getId() );
		}
		
		
		// ASSUME - the hshow & roughcut already exist
		$show_entry_id = $hshow->getShowEntryId();
		$roughcut = entryPeer::retrieveByPK( $show_entry_id );

		$roughcut = entryPeer::retrieveByPK( $entry_id );
		
 
		if ( ! $roughcut)
		{
			$this->res = "No roughcut for hshow " . $hshow->getId() ;
			return;	
		}
		*/		
//		echo "for entry: $show_entry_id current thumb path: " . $entry->getThumbnail() ;
		
		$entry->setThumbnail ( ".jpg");
		$entry->setCreateThumb(false);
		$entry->save();
		
		//$thumb_data = $_REQUEST["ThumbData"];

		if(isset($HTTP_RAW_POST_DATA))
			$thumb_data = $HTTP_RAW_POST_DATA;
		else
			$thumb_data = file_get_contents("php://input");

//		$thumb_data = $GLOBALS["HTTP_RAW_POST_DATA"];
		$thumb_data_size = strlen( $thumb_data );
		
		$bigThumbPath = myContentStorage::getFSContentRootPath() .  $entry->getBigThumbnailPath();
		
		kFile::fullMkdir ( $bigThumbPath );
		kFile::setFileContent( $bigThumbPath , $thumb_data );
		
		$path = myContentStorage::getFSContentRootPath() .  $entry->getThumbnailPath();
		
		kFile::fullMkdir ( $path );
		myFileConverter::createImageThumbnail( $bigThumbPath , $path );
		
		$roughcutPath = myContentStorage::getFSContentRootPath() . $entry->getDataPath();
		$xml_doc = new KDOMDocument();
		$xml_doc->load( $roughcutPath );
		
		if (myMetadataUtils::updateThumbUrl($xml_doc, $entry->getBigThumbnailUrl()))
			$xml_doc->save($roughcutPath);
			
		$this->res = $entry->getBigThumbnailUrl();
	}
	


}
