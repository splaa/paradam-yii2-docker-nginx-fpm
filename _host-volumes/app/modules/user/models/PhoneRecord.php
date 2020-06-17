<?php
// paradam.me.loc/PhoneRecord.php
	
	namespace app\modules\user\models;
	
	
	/**
	 * @property string $email
	 * @property string $first_name
	 * @property string $last_name
	 * @property string $country
	 * @property int $id [int(11)]
	 * @property int $created_at [int(11)]
	 * @property int $updated_at [int(11)]
	 * @property string $username [varchar(255)]
	 * @property string $auth_key [varchar(32)]
	 * @property string $email_confirm_token [varchar(255)]
	 * @property string $password_hash [varchar(255)]
	 * @property string $password_reset_token [varchar(255)]
	 * @property int $status [smallint(6)]
	 * @property string $birthday
	 * @property string $telephone [varchar(256)]
	 */
	class PhoneRecord extends User
	{
		
		public function setTestPhone()
		{
			
			$this->telephone = '+380686987691';
			$this->status = self::STATUS_TEST;
			$this->email = 'test@email.com';
			$this->username = 'test';
			$this->password_hash = 'test';
		}
	}