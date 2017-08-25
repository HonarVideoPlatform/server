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
class getEntryInfoAction extends defKeditorservicesAction
{
	public function execute()
	{
		$this->kuser = null;
		return parent::execute();
	}
	
	// here the $hshow will be null (thanks to fetchHshow=false) and entry will 
	public  function executeImpl ( hshow $hshow, entry &$entry )
	{
		$genericWidget = "";
		$myspaceWidget = "";
		
		$hshow_id = $hshow->getId();
		$entry_id = $entry->getId();
		
		if (!$hshow->getPartnerId() && !$this->forceViewPermissions ( $hshow, $hshow_id , false , false ))
			die;
		
		$this->hshow_category  = $hshow->getTypeText();
		$this->hshow_description = $hshow->getDescription();
		$this->hshow_name = $hshow->getName();
		$this->hshow_tags = $hshow->getTags();
		
		$kdata = @$_REQUEST["kdata"];
		if ($kdata == "null")
			$kdata = "";
			
		$this->widget_type = @$_REQUEST["widget_type"];
		
		list($genericWidget, $myspaceWidget) = myHshowUtils::getEmbedPlayerUrl($hshow_id, $entry_id, false, $kdata); 
		
		if ($entry_id == 1002)
			$this->share_url = requestUtils::getHost() .  "/index.php/corp/kalturaPromo";
		else if ($kdata)
			$this->share_url = myHshowUtils::getWidgetCmdUrl($kdata, "share");
		else
			$this->share_url = myHshowUtils::getUrl( $hshow_id )."&entry_id=$entry_id";
		
		//list($status, $kmediaType, $kmediaData) = myContentRender::createPlayerMedia($entry); // myContentRender class removed, old code
		$status = $entry->getStatus();
		$kmediaType = $entry->getMediaType();
		$kmediaData = "";
		
		$this->message = ($kmediaType == entry::ENTRY_MEDIA_TYPE_TEXT) ? $kmediaData : "";
		
		$this->generic_embed_code = $genericWidget;
		$this->myspace_embed_code = $myspaceWidget;
		$this->thumbnail = $entry ? $entry->getBigThumbnailPath(true) : "";
		$this->kuser = $entry->getKuser();
		$this->entry = $entry;		
	}
}

?>
