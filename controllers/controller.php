<?php
	include_once 'models/account.php';
	
	/*
	* This file defines a base class for all controllers to inherit from
	*/
	class Controller
	{
		protected $account;
		
		/*
		* Entry point for the controller. This method gets called to begin
		* execution of the controller.
		*/
		public function start()
		{
		}
		
		public function getAccount()
		{
			if ( isset($this->account) )
				return $this->account;
			return null;
		}
		
		/*
		* This function allows controllers to require login to view certain pages.
		*/
		public function requireLogin()
		{
			if ( isset($this->account) )
				return $this->account;
			
			$email = '';
			$pw = '';
			
			if ( isset($_SESSION['email']) ) // previously logged in
			{
				$email = $_SESSION['email'];
				$pw = $_SESSION['password'];
			}
			else if ( isset($_POST['login_submit']) ) // coming from login form
			{
				if ( !Account::validEmail($_POST['email']) )
					$this->account = false;
					
				$email = $_POST['email'];
				$pw = sha1($_POST['password']);
			}
			if ($this->account !== false)
			{
				$this->account = Account::login($email, $pw);
			}
			
			
			if ( $this->account === false )
			{
				self::addError('Invalid login credentials.');
				header('Location: index.php'); // redirect to home page, with login form
				exit();
			}
			
			$_SESSION['email'] = $this->account->email;
			$_SESSION['password'] = $this->account->password;
			
			return $this->account;
		}
		
		/*
		* Adds an error message to the list of errors stored in the session
		*/
		public static function addError($error)
		{
			if ( !isset($_SESSION['errors']) )
				$_SESSION['errors'] = array($error);
			else
				$_SESSION['errors'][] = $error;
		}
		
		/*
		* Adds an array of errors to the list
		*/
		public static function addErrors($errors)
		{
			if ( !isset($_SESSION['errors']) )
				$_SESSION['errors'] = $errors;
			else
				$_SESSION['errors'] = array_merge($_SESSION['errors'], $errors);
		}
		
		/*
		* Returns the errors stored in session and then clears them from session
		*/
		public static function getErrors()
		{
			if ( isset($_SESSION['errors']) )
			{
				$errors = $_SESSION['errors'];
				unset($_SESSION['errors']);
				return $errors;
			}
			
			return false;
		}
	}
?>