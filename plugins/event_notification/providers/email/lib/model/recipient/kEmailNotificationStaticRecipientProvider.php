<?php
/**
 * Core class for recipient provider containing a static list of email recipients.
 *
 * @package plugins.emailNotification
 * @subpackage model.data
 */
class kEmailNotificationStaticRecipientProvider extends kEmailNotificationRecipientProvider
{
	/**
	 * Email notification "to" sendees
	 * @var array
	 */
	protected $emailRecipients;

	/**
	 * @return array
	 */
	public function getEmailRecipients() {
		return $this->emailRecipients;
	}

	/**
	 * @param array $to
	 */
	public function setEmailRecipients($v) {
		$this->emailRecipients = $v;
	}
	

	/* (non-PHPdoc)
	 * @see kEmailNotificationRecipientProvider::getScopedProviderJobData()
	 */
	public function getScopedProviderJobData(hScope $scope = null) 
	{
		$implicitEmailRecipients = array();
		foreach($this->emailRecipients as &$emailRecipient)
		{
			/* @var $emailRecipient kEmailNotificationRecipient */
			$email = $emailRecipient->getEmail();
			if($scope && $email instanceof hStringField)
				$email->setScope($scope);

			$name = $emailRecipient->getName();
			if($scope && $name instanceof hStringField)
				$name->setScope($scope);
			$theName = "";
            if ($name)
			    $theName = $name->getValue();
			    			
			$implicitEmailRecipients[$email->getValue()] = $theName;
		}
		
		$ret = new kEmailNotificationStaticRecipientJobData();
		$ret->setEmailRecipients($implicitEmailRecipients);
		
		return $ret;
		
	}
}
