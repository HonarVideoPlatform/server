<?php

/**
 * @package    Core
 * @subpackage kEditorServices
 */
class getHshowInfoAction extends defKeditorservicesAction
{
	protected function executeImpl ( hshow $hshow, entry &$entry )
	{
		if ($entry->getMediaType() == entry::ENTRY_MEDIA_TYPE_SHOW)
			$this->show_versions = array_reverse($entry->getAllversions());
		else
			$this->show_versions = array();
			
		$this->producer = kuser::getKuserById ( $hshow->getProducerId() );
		$this->editor = $entry->getKuser();
		$this->thumbnail = $entry ? $entry->getThumbnailPath() : "";
		
		// is the logged-in-user is an admin or the producer or the show can always be published...	
		$likuser_id = $this->getLoggedInUserId();
		$viewer_type = myHshowUtils::getViewerType($hshow, $likuser_id);
		$this->entry = $entry ? $entry : new entry() ; // create a dummy entry for the GUI
		$this->can_publish =  ( $viewer_type == HshowKuser::HSHOWKUSER_VIEWER_PRODUCER ||  $hshow->getCanPublish() ) ;
	}

	protected function noSuchHshow ( $hshow_id )
	{
		$this->hshow = new hshow();
		$this->producer = new kuser() ;
	}

}

?>