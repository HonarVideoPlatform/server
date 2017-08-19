<?php
/**
 * @service eSearch
 * @package plugins.elasticSearch
 * @subpackage api.services
 */
class ESearchService extends KalturaBaseService
{
	/**
	 *
	 * @action searchEntry
	 * @param KalturaESearchOperator $searchOperator
	 * @param string $entryStatuses
	 * @param KalturaPager $pager
	 * @param KalturaESearchOrderBy $order
	 * @return KalturaESearchResponse
	 */
	function searchEntryAction (KalturaESearchOperator $searchOperator, $entryStatuses = null, KalturaPager $pager = null, KalturaESearchOrderBy $order = null)
	{
		list($coreSearchOperator, $entryStatusesArr, $kPager, $coreOrder) = $this->initSearchActionParams($searchOperator, $entryStatuses, $pager, $order);
		$entrySearch = new kEntrySearch();
		$elasticResults = $entrySearch->doSearch($coreSearchOperator, $entryStatusesArr, $kPager, $coreOrder);//TODO: handle error flow
		list($coreResults, $objectCount) = elasticSearchUtils::transformElasticToCoreObject($elasticResults, 'entryPeer');
		$response = new KalturaESearchResponse();
		$response->objects = KalturaESearchEntryResultArray::fromDbArray($coreResults);
		$response->totalCount = $objectCount;
		return $response;
	}

	/**
	 *
	 * @action searchCategory
	 * @param KalturaESearchOperator $searchOperator
	 * @param string $categoryStatuses
	 * @param KalturaPager $pager
	 * @param KalturaESearchOrderBy $order
	 * @return KalturaESearchResponse
	 */
	function searchCategoryAction (KalturaESearchOperator $searchOperator, $categoryStatuses = null, KalturaPager $pager = null, KalturaESearchOrderBy $order = null)
	{
		list($coreSearchOperator, $categoryStatusesArr, $kPager, $coreOrder) = $this->initSearchActionParams($searchOperator, $categoryStatuses, $pager, $order);
		$categorySearch = new kCategorySearch();
		$elasticResults = $categorySearch->doSearch($coreSearchOperator, $categoryStatusesArr, $kPager, $coreOrder);//TODO: handle error flow
		list($coreResults, $objectCount) = elasticSearchUtils::transformElasticToCoreObject($elasticResults, 'categoryPeer');
		$response = new KalturaESearchResponse();
		$response->objects = KalturaESearchCategoryResultArray::fromDbArray($coreResults);
		$response->totalCount = $objectCount;
		return $response;
	}

	/**
	 *
	 * @action searchUser
	 * @param KalturaESearchOperator $searchOperator
	 * @param string $userStatuses
	 * @param KalturaPager $pager
	 * @param KalturaESearchOrderBy $order
	 * @return KalturaESearchResponse
	 */
	function searchUserAction (KalturaESearchOperator $searchOperator, $userStatuses = null, KalturaPager $pager = null,  KalturaESearchOrderBy $order = null)
	{
		list($coreSearchOperator, $userStatusesArr, $kPager, $coreOrder) = $this->initSearchActionParams($searchOperator, $userStatuses, $pager, $order);
		$userSearch = new kUserSearch();
		$elasticResults = $userSearch->doSearch($coreSearchOperator, $userStatusesArr, $kPager, $coreOrder);//TODO: handle error flow
		list($coreResults, $objectCount) = elasticSearchUtils::transformElasticToCoreObject($elasticResults, 'kuserPeer');
		$response = new KalturaESearchResponse();
		$response->objects = KalturaESearchUserResultArray::fromDbArray($coreResults);
		$response->totalCount = $objectCount;
		return $response;
	}

	/**
	 *
	 * @action getAllowedSearchTypes
	 * @param KalturaESearchItem $searchItem
	 * @return KalturaKeyValueArray
	 * @throws KalturaAPIException
	 */
	function getAllowedSearchTypesAction (KalturaESearchItem $searchItem)
	{
		$coreSearchItem = $searchItem->toObject();
		$coreSearchItemClass = get_class($coreSearchItem);
		$allowedSearchMap = $coreSearchItemClass::getAllowedSearchTypesForField();

		$result = new KalturaKeyValueArray();
		if (isset($searchItem->fieldName))
		{
			foreach ($allowedSearchMap[$coreSearchItem->getFieldName()] as $searchTypeName => $searchTypeVal)
			{
				$currVal = new KalturaKeyValue();
				$currVal->key = $searchTypeName;
				$currVal->value = $searchTypeVal;
				$result[] = $currVal;
			}
		}
		return $result;
	}

	private function initSearchActionParams(KalturaESearchOperator $searchOperator, $objectStatuses = null, KalturaPager $pager = null, KalturaESearchOrderBy $order = null)
	{
		if (!$searchOperator->operator)
			$searchOperator->operator = KalturaSearchOperatorType::SEARCH_AND;

		$coreSearchOperator = $searchOperator->toObject();

		$objectStatusesArr = array();
		if (!empty($objectStatuses))
			$objectStatusesArr = explode(',', $objectStatuses);

		$kPager = null;
		if($pager)
			$kPager = $pager->toObject();

		$coreOrder = null;
		if($order)
			$coreOrder = $order->toObject();

		return array($coreSearchOperator, $objectStatusesArr, $kPager, $coreOrder);
	}

}
