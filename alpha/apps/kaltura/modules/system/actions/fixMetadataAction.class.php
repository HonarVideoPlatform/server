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
class fixMetadataAction extends kalturaSystemAction
{
	/**
	 * Will investigate a single entry
	 */
	public function execute()
	{
		myDbHelper::$use_alternative_con = myDbHelper::DB_HELPER_CONN_PROPEL2;

		$this->forceSystemAuthentication();

		entryPeer::setUseCriteriaFilter( false );
		$this->result = NULL;

		$hshow_ids = @		$kshow_ids = @$_REQUEST["kshow_ids"];REQUEST["hshow_ids"];
		$this->hshow_ids = $hshow_ids;
		$this->hshow = NULL;

		$entry_ids = @$_REQUEST["entry_ids"];
		$this->entry_ids = $entry_ids;
		$this->entry = NULL;
		$this->show_entry = null;

		$show_entry_list = array();

		if ( !empty ( $hshow_ids ))
		{
			$ids_arr = explode ( "," , $hshow_ids );
			$hshows = hshowPeer::retrieveByPKs( $ids_arr );

			if ( ! $hshows )
			{
				$this->result = "No hshows [$hshow_ids] in DB";
				return;
			}

			foreach ( $hshows as $hshow )
			{
				$show_entry =  $hshow->getShowEntry();
				$show_entry_list[] = $show_entry;
			}
		}
		else
		{
			if ( empty ( $entry_ids ))
			{
				$this->result = "Submit an entry_id of a hshow_id to fix";
				return;
			}
			$ids_arr = explode ( "," , $entry_ids );
			$entries  = entryPeer::retrieveByPKs( $ids_arr );

			if ( ! $entries )
			{
				$this->result = "No entries [$entry_ids] in DB";
				return;
			}

			foreach ( $entries as $entry )
			{
				if ( $entry->getType() != entryType::MIX )
				{
					continue;
				}
				$show_entry_list[] = $entry;
			}

		}


		$fixed_data_list = array();
		foreach ( $show_entry_list as $show_entry )
		{
			$fix_data = new fixData();
			$fix_data->show_entry = $show_entry;
			if ( $show_entry->getType() != entryType::MIX )
			{
				$fix_data->error = "Entry is not a roughcut";
			}
			else
			{
				$fix_data->old_content = $show_entry->getMetadata();
				$fix_data->old_duration = $show_entry->getLengthInMsecs();
				$fix_data->fixed_content = $show_entry->fixMetadata ( false );
				$fix_data->fixed_duration = $show_entry->getLengthInMsecs();
			}
			$fixed_data_list[] = $fix_data;
		}

		$this->fixed_data_list = $fixed_data_list;
	}
}

class fixData
{
	var $error;
	var $show_entry;
	var $old_content;
	var $old_duration;
	var $fixed_content;
	var $fixed_duration;
}
?>
