<?php
/**
 * Subclass for performing query and update operations on the 'hshow' table.
 *
 *
 *
 * @package Core
 * @subpackage model
 */
class hshowPeer extends BasehshowPeer 
{
	private static $s_default_count_limit = 301;

	/**
	 * This function sets the requested order of hshows to the given criteria object.
	 * we can use an associative array to hold the ordering fields instead of the
	 * switch statement being used now
	 *
	 * @param $c = given criteria object
	 * @param int = $order the requested sort order
	 */
	private static function setOrder($c, $order)
	{
		switch ($order) {
		case hshow::HSHOW_SORT_MOST_VIEWED:
			//$c->hints = array(hshowPeer::TABLE_NAME => "views_index");
			$c->addDescendingOrderByColumn(self::VIEWS);

			break;

		case hshow::HSHOW_SORT_MOST_RECENT:
			//$c->hints = array(hshowPeer::TABLE_NAME => "created_at_index");
			$c->addDescendingOrderByColumn(self::CREATED_AT);
			break;

		case hshow::HSHOW_SORT_MOST_COMMENTS:
			$c->addDescendingOrderByColumn(self::COMMENTS);
			break;

		case hshow::HSHOW_SORT_MOST_FAVORITES:
			$c->addDescendingOrderByColumn(self::FAVORITES);
			break;

		case hshow::HSHOW_SORT_END_DATE:
			$c->addDescendingOrderByColumn(self::END_DATE);
			break;

		case hshow::HSHOW_SORT_MOST_ENTRIES:
			$c->addDescendingOrderByColumn(self::ENTRIES);
			break;

		case hshow::HSHOW_SORT_NAME:
			$c->addAscendingOrderByColumn(self::NAME);
			break;

		case hshow::HSHOW_SORT_RANK:
			$c->addDescendingOrderByColumn(self::RANK);
			break;
		case hshow::HSHOW_SORT_MOST_UPDATED:
			$c->addDescendingOrderByColumn(self::UPDATED_AT);
			break;
		case hshow::HSHOW_SORT_MOST_CONTRIBUTORS:
			$c->addDescendingOrderByColumn(self::CONTRIBUTORS);
			break;

		}
	}

	/**
	 * This function returns a pager object holding hshows sorted by a given sort order.
	 * each hshow holds the kuser object of its host.
	 *
	 * @param int $order = the requested sort order
	 * @param int $pageSize = number of hshows in each page
	 * @param int $page = the requested page
	 * @return the pager object
	 */
	public static function getOrderedPager($order, $pageSize, $page, $producer_id = null, $kaltura_part_of_flag = null )
	{
		$c = new Criteria();
		self::setOrder($c, $order);

		$c->addJoin(self::PRODUCER_ID, kuserPeer::ID, Criteria::INNER_JOIN);

		if( $kaltura_part_of_flag )
		{
			// in this case we get the user-id in the $producer_id field
			$c->addJoin(self::ID, entryPeer::HSHOW_ID, Criteria::INNER_JOIN);
			$c->add(entryPeer::KUSER_ID, $producer_id);
			$c->add( self::PRODUCER_ID, $producer_id, Criteria::NOT_EQUAL );
			$c->setDistinct();
		}
		else if( $producer_id > 0 ) $c->add( self::PRODUCER_ID, $producer_id );

		$pager = new sfPropelPager('hshow', $pageSize);
	    $pager->setCriteria($c);
	    $pager->setPage($page);
	    $pager->setPeerMethod('doSelectJoinAll');
	    $pager->setPeerCountMethod('doCountJoinAll');
	    $pager->init();

	    return $pager;
	}

	public static function getHshowsByName( $name )
	{
		$c = new Criteria();
		$c->add ( hshowPeer::NAME , $name );
		return hshowPeer::doSelect( $c );
	}

	public static function getFirstHshowByName( $name )
	{
		$hshows = self::getHshowsByName ( $name );
		if( $hshows != null )
			return $hshows[0];
		return null;
	}

	public static function retrieveByIndexedCustomData3 ( $name )
	{
		$c = new Criteria();
		$c->add ( hshowPeer::INDEXED_CUSTOM_DATA_3 , $name );
		$hshows =  hshowPeer::doSelect( $c );
		if( $hshows != null )
			return $hshows[0];
		return null;
	}

	/**
	 * This function returns a pager object holding the given user's favorite entries
	 * each entry holds the kuser object of its host.
	 *
	 * @param int $kuserId = the requested user
	 * @param int $type = the favorite type (currently only SUBJECT_TYPE_ENTRY will match)
	 * @param int $privacy = the privacy filter
	 * @param int $pageSize = number of hshows in each page
	 * @param int $page = the requested page
	 * @return the pager object
	 */
	public static function getUserFavorites($kuserId, $type, $privacy, $pageSize, $page)
	{
		$c = new Criteria();
		$c->addJoin(self::PRODUCER_ID, kuserPeer::ID, Criteria::INNER_JOIN);
		$c->addJoin(self::ID, favoritePeer::SUBJECT_ID, Criteria::INNER_JOIN);
		$c->add(favoritePeer::KUSER_ID, $kuserId);
		$c->add(favoritePeer::SUBJECT_TYPE, $type);
		$c->add(favoritePeer::PRIVACY, $privacy);

		$c->setDistinct();

		// our assumption is that a request for private favorites should include public ones too
		if( $privacy == favorite::PRIVACY_TYPE_USER )
		{
			$c->addOr( favoritePeer::PRIVACY, favorite::PRIVACY_TYPE_WORLD );
		}


		$c->addAscendingOrderByColumn(self::NAME);

	    $pager = new sfPropelPager('hshow', $pageSize);
	    $pager->setCriteria($c);
	    $pager->setPage($page);
	    $pager->setPeerMethod('doSelectJoinkuser');
	    $pager->setPeerCountMethod('doCountJoinkuser');
	    $pager->init();

	    return $pager;
	}



	/**
	 * This function returns a pager object holding the given user's shows, for which he or she is the producer.
	 *
	 * @param int $kuserId = the requested user
	 * @param int $pageSize = number of hshows in each page
	 * @param int $page = the requested page
	 * @param int $order = the requested sort order
	 * @param int $currentHshowId = the current hshow id (e.g. in the browse page) not to be shown again in the other user shows
	 * @return the pager object
	 */
	public static function getUserShows($kuserId, $pageSize, $page, $order, $currentHshowId = 0)
	{

		$c = new Criteria();

		$c->addJoin(self::PRODUCER_ID, kuserPeer::ID, Criteria::INNER_JOIN);
		$c->add(self::PRODUCER_ID, $kuserId);
		if ($currentHshowId)
			$c->add(self::ID, $currentHshowId, Criteria::NOT_EQUAL);

		self::setOrder($c, $order);

	    $pager = new sfPropelPager('hshow', $pageSize);
	    $pager->setCriteria($c);
	    $pager->setPage($page);
	    $pager->setPeerMethod('doSelectJoinkuser');
	    $pager->setPeerCountMethod('doCountJoinkuser');
	    $pager->init();

	    return $pager;
	}


		/**
	 * This function returns a pager object holding the set of shows for which given user contributed media.
	 *
	 * @param int $kuserId = the requested user
	 * @param int $pageSize = number of hshows in each page
	 * @param int $page = the requested page
	 * @return the pager object
	 */
	public static function getUserShowsPartOf($kuserId, $pageSize, $page, $order)
	{

		$c = new Criteria();

		$c->addJoin(self::ID, entryPeer::HSHOW_ID, Criteria::INNER_JOIN);
		$c->add(entryPeer::KUSER_ID, $kuserId);
		$c->add( self::PRODUCER_ID, $kuserId, Criteria::NOT_EQUAL );
		self::setOrder($c, $order);
		$c->setDistinct();

	    $pager = new sfPropelPager('hshow', $pageSize);
	    $pager->setCriteria($c);
	    $pager->setPage($page);
	    $pager->setPeerMethod('doSelectJoinkuser');
	    $pager->setPeerCountMethod('doCountJoinkuser');
	    $pager->init();

	    return $pager;
	}


	public static function selectIdsForCriteria ( Criteria $c )
	{
		$c->addSelectColumn(self::ID);
		$rs = self::doSelectStmt($c);
		$id_list = Array();

		while($rs->next())
		{
			$id_list[] = $rs->getInt(1);
		}

		$rs->close();

		return $id_list;
	}

	public static function getHshowsByEntryIds($entry_ids)
	{
		$c = new Criteria();
		//$c->addSelectColumn(hshowPeer::ID);
		//$c->addSelectColumn(hshowPeer::NAME);
		hshowPeer::addSelectColumns($c);
		$c->addJoin(hshowPeer::ID, roughcutEntryPeer::ROUGHCUT_HSHOW_ID);
		$c->add(roughcutEntryPeer::ENTRY_ID, $entry_ids, Criteria::IN);
		$results = hshowPeer::populateObjects(self::doSelectStmt($c));
		hshowPeer::addInstancesToPool($results);
		return $results;
	}

	// this function deletes a HSHOW
	// users can only delete their own entries
	public static function deleteHShow( $hshow_id, $kuser_id  )
	{
		$hshow = self::retrieveByPK( $hshow_id );
		if( $hshow == null ) return false;
		if( $hshow->getProducerId() != $kuser_id ) return false;
		else
		{
			$hshow->delete();

			// now delete the subscriptions
			$c = new Criteria();
			$c->add(HshowKuserPeer::HSHOW_ID, $hshow_id ); // the current user knows they just favorited
			$c->add(HshowKuserPeer::SUBSCRIPTION_TYPE, HshowKuser::HSHOW_SUBSCRIPTION_NORMAL); // this table stores other relations too
			$subscriptions = HshowKuserPeer::doSelect( $c );
			foreach ( $subscriptions as $subscription )
			{
					$subscription->delete();
			}

			return true;
		}

	}

	public static function doCountWithLimit (Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;
		$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn("DISTINCT ".hshowPeer::ID);
		} else {
			$criteria->addSelectColumn(hshowPeer::ID);
		}

		$criteria->setLimit( self::$s_default_count_limit );

		$rs = self::doSelectStmt($criteria, $con);
		$count = 0;
		while($rs->next())
			$count++;

		return $count;
	}

	public static function doStubCount (Criteria $criteria, $distinct = false, $con = null)
	{
		return 0;
	}	
	
	/**
	 * Retrieve a single object by pkey.
	 *
	 * @param      string $pk the primary key.
	 * @param      PropelPDO $con the connection to use
	 * @return     hshow
	 */
	public static function retrieveByPKNoFilter($pk, PropelPDO $con = null)
	{
		self::setUseCriteriaFilter ( false );
		$res = self::retrieveByPK($pk, $con);
		self::setUseCriteriaFilter ( true );
		return $res;
	}
	
}
