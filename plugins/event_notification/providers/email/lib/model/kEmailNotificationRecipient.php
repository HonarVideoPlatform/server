<?php
/**
 * @package plugins.emailNotification
 * @subpackage model.data
 */
class kEmailNotificationRecipient
{
	/**
	 * Recipient e-mail address
	 * @var hStringValue
	 */
	protected $email;
	
	/**
	 * Recipient name
	 * @var hStringValue
	 */
	protected $name;
	
	/**
	 * @return hStringValue $email
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return hStringValue $name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param hStringValue $email
	 */
	public function setEmail(hStringValue $email)
	{
		$this->email = $email;
	}

	/**
	 * @param hStringValue $name
	 */
	public function setName(hStringValue $name)
	{
		$this->name = $name;
	}
}