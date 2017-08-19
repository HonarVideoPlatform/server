<?php

// bootstrap
require_once(__DIR__ . '/../bootstrap.php');

define('MAX_ITEMS', 2000);

function getPartnerUpdates($updatedAt)
{
	// get the partners
	$c = new Criteria();
	$c->addSelectColumn(PartnerPeer::ID);
	$c->addSelectColumn(PartnerPeer::STATUS);
	$c->addSelectColumn(PartnerPeer::ADMIN_SECRET);
	$c->addSelectColumn(PartnerPeer::UPDATED_AT);
	$c->add(PartnerPeer::UPDATED_AT, $updatedAt, Criteria::GREATER_EQUAL);
	$c->addAscendingOrderByColumn(PartnerPeer::UPDATED_AT);
	$c->setLimit(MAX_ITEMS);
	PartnerPeer::setUseCriteriaFilter(false);
	$stmt = PartnerPeer::doSelectStmt($c);
	PartnerPeer::setUseCriteriaFilter(true);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$maxUpdatedAt = 0;
	$result = array();
	foreach ($rows as $row)
	{
		$partnerId = $row['ID'];
		$status = $row['STATUS'];
		$secret = $status == Partner::PARTNER_STATUS_ACTIVE ? $row['ADMIN_SECRET'] : '';
		$result[$partnerId] = $secret;
		$updatedAt = new DateTime($row['UPDATED_AT']);
		$maxUpdatedAt = max($maxUpdatedAt, (int)$updatedAt->format('U'));
	}
	
	return array('items' => $result, 'updatedAt' => $maxUpdatedAt);
}

function getCategoryEntryUpdates($updatedAt)
{
	// get the entry ids
	$c = new Criteria();
	$c->addSelectColumn(categoryEntryPeer::ENTRY_ID);
	$c->addSelectColumn(categoryEntryPeer::UPDATED_AT);
	$c->add(categoryEntryPeer::UPDATED_AT, $updatedAt, Criteria::GREATER_EQUAL);
	$c->addAscendingOrderByColumn(categoryEntryPeer::UPDATED_AT);
	$c->setLimit(MAX_ITEMS);
	categoryEntryPeer::setUseCriteriaFilter(false);
	$stmt = categoryEntryPeer::doSelectStmt($c);
	categoryEntryPeer::setUseCriteriaFilter(true);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	$maxUpdatedAt = 0;
	$result = array();
	foreach ($rows as $row)
	{
		$entryId = $row['ENTRY_ID'];
		$result[$entryId] = '';
		$updatedAt = new DateTime($row['UPDATED_AT']);
		$maxUpdatedAt = max($maxUpdatedAt, (int)$updatedAt->format('U'));
	}
	
	// get the categories
	$categoryIdsCol = 'GROUP_CONCAT('.categoryEntryPeer::CATEGORY_FULL_IDS.')';
	$c = new Criteria();
	$c->addSelectColumn(categoryEntryPeer::ENTRY_ID);
	$c->addSelectColumn($categoryIdsCol);
	$c->addGroupByColumn(categoryEntryPeer::ENTRY_ID);
	$c->add(categoryEntryPeer::ENTRY_ID, array_keys($result), Criteria::IN);
	$stmt = categoryEntryPeer::doSelectStmt($c);
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	// update the categories (an entry that wasn't fetched in the second query will remain empty)
	foreach ($rows as $row)
	{
		$entryId = $row['ENTRY_ID'];
		$categoryIds = $row[$categoryIdsCol];
		$categoryIds = str_replace('>', ',', $categoryIds);
		$categoryIds = implode(',', array_unique(explode(',', $categoryIds)));
		$result[$entryId] = $categoryIds;
	}
	
	return array('items' => $result, 'updatedAt' => $maxUpdatedAt);
}

// parse params
$params = infraRequestUtils::getRequestParams();
$requestType = isset($params['type']) ? $params['type'] : null;
$updatedAt = isset($params['updatedAt']) ? $params['updatedAt'] : 0;
$token = isset($params['token']) ? $params['token'] : '';
if (!kConf::hasParam('analytics_sync_secret') ||
	$token !== md5(kConf::get('analytics_sync_secret') . $updatedAt))
{
	die;
}

// init database
DbManager::setConfig(kConf::getDB());
DbManager::initialize();

switch ($requestType)
{
case 'partner':
	$result = getPartnerUpdates($updatedAt);
	break;
	
case 'categoryEntry':
	$result = getCategoryEntryUpdates($updatedAt);
	break;
	
default:
	$result = array('error' => 'bad request');
}

echo json_encode($result);
die;
