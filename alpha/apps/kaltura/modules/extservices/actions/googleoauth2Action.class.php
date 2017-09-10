<?php

require_once 'oauth2Action.class.php';

/**
 * @package Core
 * @subpackage externalServices
 */
class googleoauth2Action extends oauth2Action
{
	const SUB_ACTION_REDIRECT_SCREEN = 'redirect-screen';
	const SUB_ACTION_PROCESS_OAUTH2_RESPONSE = 'process-oauth2-response';
	const SUB_ACTION_STATUS = 'success';
	const SUB_ACTION_LOGIN_SCREEN = 'login-screen';

	/**
	 */
	public function execute()
	{
		// add google client library to include path
		set_include_path(get_include_path().PATH_SEPARATOR.KALTURA_ROOT_PATH.'/vendor/google-api-php-client/src/');
		require_once 'Google_Client.php';

		$hs    = $this->getRequestParameter('hs');
		$state = $this->getRequestParameter('state');
		$status = $this->getRequestParameter('status');

		// understand the sub action based on our url parameters
		if ($status)
		{
			$this->subAction = self::SUB_ACTION_STATUS;
			$this->executeStatus();
		}
		elseif ($hs)
		{
			$this->subAction = self::SUB_ACTION_REDIRECT_SCREEN;
			$this->executeRedirectScreen();
		}
		elseif ($state)
		{
			$this->subAction = self::SUB_ACTION_PROCESS_OAUTH2_RESPONSE;
			$this->executeProcessOAuth2Response();
		}
		else
		{
			$this->subAction = self::SUB_ACTION_LOGIN_SCREEN;
			$this->executeLoginScreen();
		}

		return sfView::SUCCESS;
	}

	/**
	 * display login form
	 */
	protected function executeLoginScreen()
	{
		/**
		 * the google api project that we are granting access to
		 */
		$appId = $this->getRequestParameter('ytid');

		/**
		 * sub id is needed when we want to authorize different google accounts for several distribution profiles
		 * the distribution profile can then look for its specific access token by the 'subid'
		 */
		$subId = $this->getRequestParameter('subid');

		$appConfig = $this->getFromGoogleAuthConfig($appId);
		$this->invalidConfig = null;
		$this->loginError = null;
		$this->serviceUrl = requestUtils::getHost();
		$params = array(
			'ytid' => $appId,
			'subid' => $subId,
		);
		$this->nextUrl = $this->getController()->genUrl('extservices/googleoauth2?'.http_build_query($params, null, '&')).'?hs=';
		if ($appConfig === null)
		{
			$this->invalidConfig = true;
		}
	}

	/**
	 *  display a message to the user before redirecting him to google
	 */
	protected function executeRedirectScreen()
	{
		$appId = $this->getRequestParameter('ytid');
		$subId = $this->getRequestParameter('subid');
		$hsStr = $this->getRequestParameter('hs');

		$appConfig = $this->getFromGoogleAuthConfig($appId);
		$client = $this->getGoogleClient();
		$this->hsError = null;
		$hsValid = $this->processHs($hsStr);
		if (!$hsValid)
		{
			$this->hsError = true;
			return;
		}

		/** @var hs $hs */
		$hs = kCurrentContext::$hs_object;
		$partnerId = $hs->partner_id;

		$state = array(
			'ytid' => $appId,
			'subid' => $subId,
		);

 		// let's create a limited hs and pass it as a state parameter to google
		$limitedHs = $this->generateTimeLimitedHsWithData($partnerId, $state);

		$state = $limitedHs;
		$redirect = $this->getController()->genUrl('extservices/googleoauth2', true);
		$client->setRedirectUri($redirect);

		$client->setState($state);
		$client->setScopes($appConfig['scopes']);
		$client->setApprovalPrompt('force');
		$client->setAccessType('offline');
		$this->oauth2Url = $client->createAuthUrl();
	}

	/**
	 * validate the response from google
	 */
	protected function executeProcessOAuth2Response()
	{
		$this->hsError = null;
		$this->tokenError = null;

		$limitedHsStr = $this->getRequestParameter('state');
		$hsValid = $this->processHs($limitedHsStr);
		if (!$hsValid)
		{
			$this->hsError = true;
			return;
		}
		$limitedHs = kCurrentContext::$hs_object;
		$additionalData = $limitedHs->additional_data;
		$stateObject = json_decode($additionalData);
		if (!$stateObject)
		{
			$this->hsError = true;
			return;
		}
		$appId = isset($stateObject->ytid) ? $stateObject->ytid : null;
		$subId = isset($stateObject->subid) ? $stateObject->subid : null;

		$partner = $this->getPartner($limitedHs->partner_id);

		$client = $this->getGoogleClient($appId);
		$redirect = $this->getController()->genUrl('extservices/googleoauth2', true);
		$client->setRedirectUri($redirect);

		try
		{
			$client->authenticate();
		}
		catch(Google_AuthException $ex)
		{
			KalturaLog::err($ex);
			$this->tokenError = true;
			return;
		}

		$tokenJsonStr = $client->getAccessToken();
		$partner->setGoogleOAuth2($appId, $tokenJsonStr, $subId);
		$partner->save();

		$params = array(
			'ytid' => $appId,
			'status' => 1,
			'hs' => $limitedHsStr
		);
		if ($subId)
			$params['subid'] = $subId;

		$this->redirect('extservices/googleoauth2?'.http_build_query($params, null, '&'));
	}

	protected function executeStatus()
	{
		$this->paramsError = null;
		$this->tokenError = null;
		$this->hsError = null;
		$hsStr = $this->getRequestParameter('hs');
		$appId = $this->getRequestParameter('ytid');
		$subId = $this->getRequestParameter('subid');
		$appConfig = $this->getFromGoogleAuthConfig($appId);
		$hsValid = $this->processHs($hsStr);
		if (!$hsValid)
		{
			$this->hsError = true;
			return;
		}

		$hs = kCurrentContext::$hs_object;
		if ($hs == null || $appConfig == null)
		{
			$this->paramsError = true;
			return;
		}

		$partnerId = $hs->partner_id;
		$partner = $this->getPartner($partnerId);
		$tokenData = $partner->getGoogleOAuth2($appId, $subId);
		$client = $this->getGoogleClient($appId);
		try
		{
			$client->setAccessToken(json_encode($tokenData));
			$http = new Google_HttpRequest('https://www.googleapis.com/oauth2/v1/tokeninfo?access_token='.$tokenData['access_token']);
			$request = Google_Client::$io->makeRequest($http);
			$code = $request->getResponseHttpCode();
			$body = $request->getResponseBody();
			if ($code != 200)
			{
				KalturaLog::err('Google API returned: ' . $body);
				$this->tokenError = true;
			}
		}
		catch(Exception $ex)
		{
			KalturaLog::err($ex);
			$this->tokenError = true;
		}
	}

	protected function getFromGoogleAuthConfig($paramName, $default = null)
	{
		return kConf::get($paramName, 'google_auth', $default);
	}

	/**
	 * @param null $appId
	 * @return Google_Client
	 * @throws Exception
	 */
	protected function getGoogleClient($appId = null)
	{
		if ($appId === null)
			$appId = $this->getRequestParameter('ytid');

		$appConfig = $this->getFromGoogleAuthConfig($appId);
		if (!is_array($appConfig))
			throw new Exception('Google auth configuration not found for app id '.$appId);

		$clientId = isset($appConfig['clientId']) ? $appConfig['clientId'] : null;
		$clientSecret = isset($appConfig['clientSecret']) ? $appConfig['clientSecret'] : null;

		$client = new Google_Client();
		$client->setClientId($clientId);
		$client->setClientSecret($clientSecret);

		return $client;
	}


}