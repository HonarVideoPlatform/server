<?php

/**
 * Poll service
 *
 * The poll service works against the cache entirely no DB instance should be used here
 *
 * @service poll
 * @package plugins.poll
 * @subpackage api.services
 * @throws KalturaErrors::SERVICE_FORBIDDEN
 */
class PollService extends KalturaBaseService
{

	/**
	 * Add Action
	 * @action add
	 * @param string $pollType
	 * @return string
	 * @throws KalturaAPIException
	 */
	public function addAction($pollType = 'SINGLE_ANONYMOUS')
	{
		KalturaResponseCacher::disableCache();
		try
		{
			$pollActions = new PollActions();
			return $pollActions->generatePollId($pollType);
		}
		catch (Exception $e)
		{
			throw new KalturaAPIException($e->getMessage());
		}
	}

	/**
	 * Get Votes Action
	 * @action getVotes
	 * @param string $pollId
	 * @param string $answerIds
	 * @return string
	 * @throws KalturaAPIException
	 */
	public function getVotesAction($pollId, $answerIds)
	{
		$otherDcVotesKey='otherDCVotes';
		KalturaResponseCacher::disableCache();
		try
		{
			$pollActions = new PollActions();
			$localDcVotes = $pollActions->getVotes($pollId, $answerIds);
		}
		catch (Exception $e)
		{
			throw new KalturaAPIException($e->getMessage());
		}

		if(!kFileUtils::isAlreadyInDumpApi())
		{
			$remoteDCIds = kDataCenterMgr::getAllDcs();
			if($remoteDCIds && count($remoteDCIds) > 0)
			{
				$remoteDCHost = kDataCenterMgr::getRemoteDcExternalUrlByDcId(1 - kDataCenterMgr::getCurrentDcId());
				if ($remoteDCHost)
				{
					$_POST[$otherDcVotesKey] = json_encode($localDcVotes);
					return kFileUtils::dumpApiRequest($remoteDCHost);
				}
			}
		}
		else
		{
			if(isset($_POST[$otherDcVotesKey]))
			{
				$prevData = json_decode($_POST[$otherDcVotesKey]);
				try
				{
					$localDcVotes->merge($prevData);
				} catch (Exception $e)
				{
					throw new KalturaAPIException($e->getMessage());
				}
			}
		}
		return json_encode($localDcVotes);
	}

	/**
	 * Get resetVotes Action
	 * @action resetVotes
	 * @param string $pollId
	 * @throws KalturaAPIException
	 */
	public function resetVotesAction($pollId)
	{

		KalturaResponseCacher::disableCache();
		try
		{
			$pollActions = new PollActions();
			$newVersion = $pollActions->resetVotes($pollId);
			KalturaLog::debug("New cache version - {$newVersion} to PollId - {$pollId}");
		}
		catch (Exception $e)
		{
			throw new KalturaAPIException($e->getMessage());
		}

		if(!kFileUtils::isAlreadyInDumpApi())
		{
			$remoteDCIds = kDataCenterMgr::getAllDcs();
			if ($remoteDCIds && count($remoteDCIds) > 0)
			{
				$remoteDCHost = kDataCenterMgr::getRemoteDcExternalUrlByDcId(1 - kDataCenterMgr::getCurrentDcId());
				if ($remoteDCHost)
					return kFileUtils::dumpApiRequest($remoteDCHost);
			}
		}
	}


	/**
	 * Vote Action
	 * @action vote
	 * @param string $pollId
	 * @param string $userId
	 * @param string $answerIds
	 * @return string
	 * @throws KalturaAPIException
	 */
	public function voteAction($pollId, $userId, $answerIds)
	{
		KalturaResponseCacher::disableCache();
		try
		{
			$pollActions = new PollActions();
			$ksUserId = kCurrentContext::$uid;
			$pollActions->setVote($pollId, $userId,$ksUserId ,$answerIds);
		}
		catch (Exception $e)
		{
			throw new KalturaAPIException($e->getMessage());
		}
	}

	/**
	 * Vote Action
	 * @action getVote
	 * @param string $pollId
	 * @param string $userId
	 * @return string
	 */
	public function getVoteAction($pollId, $userId)
	{
		KalturaResponseCacher::disableCache();
		$ksUserId = kCurrentContext::$uid;
		$pollActions = new PollActions();
		return $pollActions->doGetVote($pollId, $userId, $ksUserId);
	}

	/**
	 * Should return true or false for allowing/disallowing kaltura network filter for the given action.
	 * Can be extended to partner specific checks etc...
	 * @return true if "kaltura network" is enabled for the given action or false otherwise
	 * @param string $actionName action name
	 */
	protected function kalturaNetworkAllowed($actionName)
	{
		return false;
	}

}
