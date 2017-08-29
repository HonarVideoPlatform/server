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
class createDefaultMetadataAction extends defKeditorservicesAction
{
	/**
	 * Executes index action
	 */
	protected function executeImpl ( hshow $hshow )
	{
		$this->xml_content = ""; 

		$hshow_id = $this->hshow_id;
		if ( $hshow_id == NULL || $hshow_id == 0 )		return sfView::SUCCESS;
		$metadata_creator = new myHshowMetadataCreator ();

		$this->show_metadata = $metadata_creator->createMetadata ( $hshow_id );

//		$hshow = hshowPeer:retrieveByPK( $hshow_id );
		$entry = entryPeer::retrieveByPK( $hshow->getShowEntryId() );


		// TODO - this should never happen
		if ( $entry == NULL )
		{
			// there is no show entry for this show !
			$entry = $hshow->createEntry ( entry::ENTRY_MEDIA_TYPE_SHOW , $hshow->getProducerId() );
		}

		$content_path = myContentStorage::getFSContentRootPath();
		$file_path = $content_path.$entry->getDataPath() ;

		// check to see if the content of the file changed
		$current_metadata = kFile::getFileContent( $file_path );

		$comp_result = strcmp ( $this->show_metadata , $current_metadata  );
		if ( $comp_result != 0 )
		{
			$ext = pathinfo($file_path, PATHINFO_EXTENSION);
			if ( $ext != "xml")
			{
				// this is for the first time - override the template path by setting the data to NULL
				$entry->setData ( NULL );
				$file_path = pathinfo($file_path, PATHINFO_DIRNAME) . "/" . kFile::getFileNameNoExtension ( $file_path ) . ".xml";
			}

			// this will increment the name if needed
			$entry->setData ( $file_path );
			$file_path = $content_path.$entry->getDataPath() ;

			$entry->save();

			kFile::fullMkdir($file_path);
			kFile::setFileContent( $file_path , $this->show_metadata );
			
			$this->xml_content = $this->show_metadata;
			
			
		}

	}

	protected function noSuchHshow ( $hshow_id )
	{
		$this->xml_content = "";
	}

}
?>
