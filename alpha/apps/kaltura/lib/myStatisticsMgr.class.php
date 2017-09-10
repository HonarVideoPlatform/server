<?php
class myStatisticsMgr
{
	private static $s_dirty_objects = array();

	public static function incKuserViews ( kuser $kuser , $delta = 1 )
	{
		$v = $kuser->getViews();
		if ( self::shouldModify ( $kuser , kuserPeer::VIEWS ) );
		{
			self::inc ( $v , $delta);
			$kuser->setViews( $v );
		}
		return $v;
	}

	// will increment either fans or favorites for hshow or entry according to favorite.subject_type
	/**
	const SUBJECT_TYPE_HSHOW = '1';
	const SUBJECT_TYPE_ENTRY = '2';
	const SUBJECT_TYPE_USER = '3';

	*/
	public static function addFavorite ( favorite $favorite )
	{
		self::add ( $favorite );

		$type = $favorite->getSubjectType();
		$id = $favorite->getSubjectId();
		if ( $type == favorite::SUBJECT_TYPE_ENTRY )
		{
			$obj = entryPeer::retrieveByPK( $id );
			if ( $obj ) 
			{
				$v = $obj->getFavorites () 	;
				self::inc ( $v );
				$obj->setFavorites ( $v );
			}
		}
		elseif ( $type == favorite::SUBJECT_TYPE_HSHOW )
		{
			$obj = hshowPeer::retrieveByPK( $id );
			if ( $obj )
			{			
				$v = $obj->getFavorites () 	;
				self::inc ( $v );
				$obj->setFavorites ( $v );
			}
		}
		elseif (  $type == favorite::SUBJECT_TYPE_USER )
		{
			$obj = kuserPeer::retrieveByPK( $id );
			if ( $obj )
			{
				$v = $obj->getFans () 	;
				self::inc ( $v );
				$obj->setFans ( $v );
			}
		}
		// don't forget to save the modified object
		self::add ( $obj );
	}

	//- will increment kuser.entries, hshow.entries & hshow.contributors
	public static function addEntry ( entry $entry )
	{
		return;
		/*$hshow = $entry->gethshow();
		if ( $hshow )
		{
			$v = $hshow->getEntries();
			self::inc ( $v );
			$hshow->setEntries ( $v );
		}

		$c = new Criteria();
		myCriteria::addComment( $c , __METHOD__  );
		$c->add ( entryPeer::HSHOW_ID , $entry->getHshowId() );
		$c->add ( entryPeer::KUSER_ID , $entry->getKuserId() );
		$c->setLimit ( 2 );
		$res = entryPeer::doCount( $c );
		if ( $res < 1 && $hshow != null )
		{
			// kuser didn't contribute to this hshow - increment
			$v = $hshow->getContributors();
			self::inc ( $v );
			$hshow->setContributors( $v );
		}

		$kuser = $entry->getkuser();
		if ( $kuser )
		{
			$v = $kuser->getEntries();
			self::inc ( $v );
			$kuser->setEntries ( $v );
		}

		self::add ( $hshow );
		self::add ( $kuser );*/
	}

	//- will increment kuser.entries, hshow.entries & hshow.contributors
	public static function deleteEntry ( entry $entry )
	{
		return;
		/*$hshow = $entry->gethshow();
		if ($hshow)
		{
			$v = $hshow->getEntries();
			self::dec ( $v );
			$hshow->setEntries ( $v );
	
			$c = new Criteria();
			myCriteria::addComment( $c , __METHOD__  );
			$c->add ( entryPeer::HSHOW_ID , $entry->getHshowId() );
			$c->add ( entryPeer::KUSER_ID , $entry->getKuserId() );
			$c->setLimit ( 2 );
			$res = entryPeer::doCount( $c );
			if ( $res == 1 )
			{
				// if $res > 1 -  this kuser contributed more than one entry, deleting this one should still leave him a contributor 
				// if $res < 1 -  this kuser never contributed - strange! but no need to dec the contributors
				// kuser did contribute to this hshow - decrement
				$v = $hshow->getContributors();
				self::dec ( $v );
				$hshow->setContributors( $v );
			}
	
			$kuser = $entry->getkuser();
			if ( $kuser )
			{
				$v = $kuser->getEntries();
				self::dec ( $v );
				$kuser->setEntries ( $v );
			}
	
			self::add ( $hshow );
			self::add ( $kuser );
		}*/
	}
	
	//- will increment kuser.produced_hshows
	public static function addHshow ( hshow $hshow )
	{
		$kuser = $hshow->getKuser();
		// this might happen when creating a temp hshow without setting its producer 
		if ( $kuser == NULL ) return;
		
		$v = $kuser->getProducedHshows ();
		self::inc ( $v );
		$kuser->setProducedHshows ( $v );
		self::add ( $kuser );
	}

	//- will decrement kuser.produced_hshows
	public static function deleteHshow ( hshow $hshow )
	{
		$kuser = $hshow->getKuser();
		// this might happen when creating a temp hshow without setting its producer 
		if ( $kuser == NULL ) return;
		
		$v = $kuser->getProducedHshows ();
		self::dec( $v );
		$kuser->setProducedHshows ( $v );
		self::add ( $kuser );
	}
		
	public static function incHshowViews ( hshow $hshow , $delta = 1 )
	{
		$v = $hshow->getViews();
		if ( self::shouldModify ( $hshow , hshowPeer::VIEWS ) );
		{
			self::inc ( $v , $delta);
			$hshow->setViews( $v );
		}
		return $v;
	}

	public static function incHshowPlays ( hshow $hshow , $delta = 1 )
	{
		$v = $hshow->getPlays();
		
KalturaLog::log ( __METHOD__ . ": " . $hshow->getId() . " plays: $v");
 
		if ( self::shouldModify ( $hshow , hshowPeer::PLAYS ) );
		{
			self::inc ( $v , $delta);
			$hshow->setPlays( $v );
		}
		
KalturaLog::log ( __METHOD__ . ": " . $hshow->getId() . " plays: $v");		
		return $v;
	}
	
/*	
	// - do we vote for hshows ??? - this should be derived from the roughcut
	public static function incHshowVotes ( hshow $hshow )
	{
	}
*/

	// - will increment hshow.comments or entry.comments according to comment_type
	/**
	* 	const COMMENT_TYPE_HSHOW = 1;
	const COMMENT_TYPE_DISCUSSION = 2;
	const COMMENT_TYPE_USER = 3;
	const COMMENT_TYPE_SHOUTOUT = 4;
	*
	*/
	public static function addComment ( comment $comment )
	{
		$obj = NULL;
		$type = $comment->getCommentType();
		$id = $comment->getSubjectId();
		if ( $type == comment::COMMENT_TYPE_HSHOW || 
			$type == comment::COMMENT_TYPE_SHOUTOUT ||
			$type == comment::COMMENT_TYPE_DISCUSSION )
		{
			$obj = hshowPeer::retrieveByPK( $id );
			if ( $obj )
			{
				$v = $obj->getComments () 	;
				self::inc ( $v );
				$obj->setComments ( $v );
			}
		}
		elseif ( $type == comment::COMMENT_TYPE_USER )
		{
/*			$obj = kuserPeer::retrieveByPK( $id );
			$v = $obj->getComments () 	;
			self::inc ( $v );
			$obj->setComments ( $v );
*/
		}

		// TODO - what about the other types ?
		if ( $obj != NULL )	self::add ( $obj );
	}

	public static function addSubscriber ( HshowKuser $kushow_kuser )
	{
		$type = $kushow_kuser->getAlertType();

		if ( $type == HshowKuser::HSHOW_SUBSCRIPTION_NORMAL )
		{
			$hshow = $kushow_kuser->gethshow();
			if ( $hshow )
			{
				$v = $hshow->getSubscribers() 	;
				self::inc ( $v );
				$hshow->setSubscribers ( $v );
			}

			self::add ( $hshow );
		}
	}

	// - will increment hshow.number_of_updates
	public static function incHshowUpdates ( hshow $hshow, $delta = 1 )
	{
		$v = $hshow->getNumberOfUpdates();
		if ( self::shouldModify( $hshow , hshowPeer::NUMBER_OF_UPDATES ) )
		{
			self::inc ( $v , $delta);
			$hshow->setNumberOfUpdates( $v );
		}
		return $v;
	}

	public static function incEntryViews ( entry $entry , $delta = 1 )
	{
		$v = $entry->getViews();
		if ( $delta == 0 ) return $v;
		if ( self::shouldModify ( $entry , entryPeer::VIEWS ) );
		{
			self::inc ( $v , $delta);
			$entry->setViews( $v );
		}
		
		if ( $entry->getType() == entryType::MIX )
		{
			$enclosing_hshow = $entry->getHshow();
			if ( $enclosing_hshow  )
			{
				$hshow_views = $enclosing_hshow->getViews() ;
				$enclosing_hshow->setViews ( ++$hshow_views );
				self::add( $enclosing_hshow );
			}
		}		
		return $v;
	}


	public static function incEntryPlays ( entry $entry , $delta = 1 )
	{
		$v = $entry->getPlays();
		if ( $delta == 0 ) return $v;
		if ( self::shouldModify ( $entry , entryPeer::PLAYS ) );
		{
			self::inc ( $v , $delta);
			$entry->setPlays( $v );
		}
		
		if ( $entry->getType() == entryType::MIX )
		{
			$enclosing_hshow = $entry->getHshow();
			if ( $enclosing_hshow  )
			{
				$hshow_views = $enclosing_hshow->getPlays() ;
				$enclosing_hshow->setPlays ( ++$hshow_views );
				self::add( $enclosing_hshow );
			}
		}		
		return $v;
	}
	
	
	public static function addKvote ( kvote $kvote )
	{
		$entry = $kvote->getEntry();
		$res = self::modifyEntryVotes($entry, $kvote->getRank(), KVoteStatus::VOTED);
		return $res; 
	}
	
    public static function modifyEntryVotesBykVote (kvote $kvote)
	{
		$entry = $kvote->getEntry();
		$res = self::modifyEntryVotes($entry, $kvote->getRank(), $kvote->getStatus());
		return $res; 
	}

	// - will update votes , total_rank & rank
	// if the ebtry is of type roughcut -0 will update the hshow's rank too
	private static function modifyEntryVotes ( entry $entry , $delta_rank, $kvoteStatus )
	{
		$res = array();
		
		$votes = $entry->getVotes();
		if ( self::shouldModify ( $entry , entryPeer::VOTES ) );
		{
		    if ($kvoteStatus == KVoteStatus::VOTED)
			    self::inc ($votes);
			else 
			    self::dec($votes);
			$entry->setVotes( $votes );
				
			$total_rank = $entry->getTotalRank();
			if ($kvoteStatus == KVoteStatus::VOTED)
			    self::inc ($total_rank, $delta_rank);
			else 
			    self::dec($total_rank, $delta_rank);
			$entry->setTotalRank( $total_rank );
				
			$res ["entry"] = $entry;
			// can assume $votes > 0
			$rank = $entry->setRank ( ( $total_rank / $votes ) * 1000 );
				
			// if rouhcut - update the hshow's rank too
			if ( $entry->getType() == entryType::MIX )
			{
				$enclosing_hshow = $entry->getHshow();
				if ( $enclosing_hshow  )
				{
					$hshow_votes = $enclosing_hshow->getVotes() ;
					$enclosing_hshow->setVotes ( ++$hshow_votes );
					if ( true ) //if ( $enclosing_hshow->getRank() <  $entry->getRank() ) // rank the show 
					{
						$enclosing_hshow->setRank ( $entry->getRank() );
						self::add( $enclosing_hshow );
						$res ["hshow"] = $enclosing_hshow;
					}
				}
			}
		}
		return $res;
	}


	// TODO - might be duplicates in the list- try to avoid redundant saves
	// (although won't commit to DB because there will be no internal dirty flags)
	public static function saveAllModified ()
	{
		foreach ( self::$s_dirty_objects as $id => $dirty_obj )
		{
			self::log ( "saving: [$id]" );
			$dirty_obj->save();
		}
		
		// free all the object - create a new empty array
		self::$s_dirty_objects = array();
	}

	private static function shouldModify ( BaseObject $baseObject , $col )
	{
		if ( ! $baseObject->isColumnModified($col ) )
		{
			self::add ( $baseObject );
			return true;
		}

		// this object should not be updated twice
		return false;
	}

	private static function add ( /*BaseObject*/ $baseObject )
	{
		if ( $baseObject != null )
		{
			$id = get_class ( $baseObject ) . $baseObject->getId();
			self::log ( "adding: [$id]" );
			self::$s_dirty_objects[$id] = $baseObject;
		}
	}

	private static function inc ( &$num , $delta = 1 )
	{
		if ( ! is_numeric ( $num )) $num = 0;
		$num += $delta;
	}
	
	private static function dec ( &$num , $delta = 1 )
	{
		if ( ! is_numeric ( $num )) $num = 0;
		$num -= $delta;
		
		if($num < 0)
			$num = 0;
	}	
	
	
	private static function log ( $str )
	{
	}
}
?>