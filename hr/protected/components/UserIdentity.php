<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	//public $role;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$userModel = Users::model()->findByAttributes(array('username' => $this->username));
		if ($userModel == null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		elseif ($userModel->password !== $this->password)
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else {
			$this->errorCode = self::ERROR_NONE;
			$this->setState('roles', $userModel->roles);
		}

		return !$this->errorCode;
	}
}