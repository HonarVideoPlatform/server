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
class getAllEntriesAction extends defKeditorservicesAction
{
	const LIST_TYPE_HSHOW = 1 ;
	const LIST_TYPE_KUSER = 2 ;
	const LIST_TYPE_ROUGHCUT = 4 ;
	const LIST_TYPE_EPISODE = 8 ;
	const LIST_TYPE_ALL = 15;
	
	protected function executeImpl ( hshow $hshow, entry &$entry )
	{
		$list_type = $this->getP ( "list_type" , self::LIST_TYPE_ALL );
		
		$hshow_entry_list = array();
		$kuser_entry_list = array();
		
		if ( $list_type & self::LIST_TYPE_HSHOW )
		{
			$c = new Criteria();
			$c->add ( entryPeer::TYPE , entryType::MEDIA_CLIP );
			$c->add ( entryPeer::MEDIA_TYPE , entry::ENTRY_MEDIA_TYPE_SHOW , Criteria::NOT_EQUAL );
			$c->add ( entryPeer::HSHOW_ID , $this->hshow_id );
			$hshow_entry_list = entryPeer::doSelectJoinkuser( $c );
		}

		if ( $list_type & self::LIST_TYPE_KUSER )
		{
			$c = new Criteria();
			$c->add ( entryPeer::TYPE , entryType::MEDIA_CLIP );
			$c->add ( entryPeer::MEDIA_TYPE , entry::ENTRY_MEDIA_TYPE_SHOW , Criteria::NOT_EQUAL );
			$c->add ( entryPeer::KUSER_ID , $this->getLoggedInUserIds(), Criteria::IN  );
			$kuser_entry_list = entryPeer::doSelectJoinkuser( $c );
		}		

		if ( $list_type & self::LIST_TYPE_EPISODE )
		{
			if ( $hshow->getEpisodeId() )
			{
				// episode_id will point to the "parent" hshow
				// fetch the entries of the parent hshow
				$c = new Criteria();
				$c->add ( entryPeer::TYPE , entryType::MEDIA_CLIP );
				$c->add ( entryPeer::MEDIA_TYPE , entry::ENTRY_MEDIA_TYPE_SHOW , Criteria::NOT_EQUAL );
				$c->add ( entryPeer::HSHOW_ID , $hshow->getEpisodeId() );
				$parent_hshow_entries = entryPeer::doSelectJoinkuser( $c );
				if ( count ( $parent_hshow_entries) )
				{
					$hshow_entry_list = kArray::append  ( $hshow_entry_list , $parent_hshow_entries );
				}			
			}
		}
		
		// fetch all entries that were used in the roughcut - those of other kusers 
		// - appeared under kuser_entry_list when someone else logged in

		if ( $list_type & self::LIST_TYPE_ROUGHCUT )
		{
			if ( $hshow->getHasRoughcut() )
			{
				$roughcut_file_name =  $entry->getDataPath();
				
				$entry_ids_from_roughcut = myFlvStreamer::getAllAssetsIds ( $roughcut_file_name );
				
				$final_id_list = array();
				foreach ( $entry_ids_from_roughcut as $id )
				{
					$found = false;
					foreach ( $hshow_entry_list as $entry )
					{
						if ( $entry->getId() == $id )
						{
							$found = true; 
							break;
						}
					}
					if ( !$found )	$final_id_list[] = $id;
				}
				
				$c = new Criteria();
				$c->add ( entryPeer::ID , $final_id_list , Criteria::IN );
				$extra_entries = entryPeer::doSelectJoinkuser( $c );
				
				// merge the 2 lists into 1:
				$hshow_entry_list = kArray::append  ( $hshow_entry_list , $extra_entries );
			}
		}
		
		$this->hshow_entry_list = $hshow_entry_list;
		$this->kuser_entry_list = $kuser_entry_list;
		
	}
	
	protected function noSuchHshow ( $hshow_id )
	{
		$this->hshow_entry_list = array ();
		$this->kuser_entry_list = array ();
	}

}

?>
