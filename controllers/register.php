<?php
	include_once 'controllers/controller.php';
	include_once 'models/account.php';
	include_once 'lib/communication.php';
	
	/*
	* Controller to handle the Account Setup component
	*/
	class Register extends Controller
	{
		/*
		* Entry point for the controller. Interprets the event requested by the user.
		*/
		public function start()
		{
			$this->personalInfo();
		}
		
		public function cancel()
		{
			unset($_SESSION['new_account']);
			session_destroy();
			header('Location: index.php');
		}
		
		public function personalInfo()
		{
			$pageTitle = 'Account Setup - Personal Information';
			$errors = parent::getErrors();
			
			// so there are no 'undefined index' errors
			if ( isset($_SESSION['new_account']) && count($_SESSION['new_account']) )
				$data['pi'] = $_SESSION['new_account'];
			else
				$data['pi'] = array('email' => '', 'first_name'=>'', 'last_name'=>'', 'middle_name'=>'','dob'=>'', 'address'=>'',
					'city'=>'', 'state'=>'', 'zip'=>'', 'home_phone'=>'', 'cell_phone'=>'', 'marital_status'=>'');
			
			include_once 'views/register_personal_info.php';
		}
		
		public function beneficiaryInfo()
		{
			/* only allows access if:
			* 1. coming from personal info form
			* 2. there were errors with the submission
			* 3. user has already filled out this form
			*/
			if ( isset($_POST['pi_submit']) || isset($_SESSION['errors']) || isset($_SESSION['new_account']['beneficiary']) )
			{
				// if coming from personal info form....
				if ( isset($_POST['pi_submit']) )
				{
					if ( !isset($_SESSION['new_account']) )
						$_SESSION['new_account'] = $_POST;
					else
						$_SESSION['new_account'] = array_merge($_SESSION['new_account'], $_POST);// save input to session
					
					$errors = Account::checkPersonalInfo($_POST); // validate input
					
					if ( Account::emailInUse($_POST['email']) )
						if ( is_array($errors) )
							$errors[] = 'That email is already in use.';
						else
							$errors = array('That email is already in use.');
						
					if ( is_array($errors) ) // if validation returned array of errors...
					{	// store errors in session and go back to personal info form
						parent::addErrors($errors);
						header('Location: index.php?c=register&e=personalinfo');
						exit();
					}
				}
				
				$errors = parent::getErrors();
				$pageTitle = 'Account Setup - Beneficiary Information';
				$data['bi'] = '';
				
				if ( isset($_SESSION['new_account']['beneficiary']) )
					$data['bi'] = $_SESSION['new_account']['beneficiary'];
				
				include_once 'views/register_ben_info.php';
			}
		}
		
		public function deposit()
		{
			/* only allows access if:
			* 1. coming from beneficiary info form
			* 2. there were errors with the deposit
			* 3. user has already filled out this form
			*/
			if ( isset($_POST['bi_submit']) || isset($_SESSION['errors']) || isset($_SESSION['new_account']['deposit']) )
			{
				if ( isset($_POST['bi_submit']) )
				{
					$_SESSION['new_account']['beneficiary'] = $_POST['beneficiary'];
					$check = Account::checkBeneficiaryInfo($_POST);
				
					if ( !$check )
					{
						parent::addError('Please enter a first and last name for your beneficiary. A middle initial or name is optional.');
						header('Location: index.php?c=register&e=beneficiaryinfo');
						exit();
					}
				}
				
				$errors = parent::getErrors();
				$pageTitle = 'Account Setup - Opening Deposit';
				$data['deposit'] = '';
				
				if ( isset($_SESSION['new_account']['deposit']) )
					$data['deposit'] = $_SESSION['new_account']['deposit'];
				
				include_once 'views/register_deposit.php';
			}
		}
		
		public function password()
		{
			/* only allows access if:
			* 1. coming from the opening deposit form
			* 2. there were errors with the password submission
			*/
			if ( isset($_POST['deposit_submit']) || isset($_SESSION['errors']) )
			{
				if ( isset($_POST['deposit_submit']) )
				{
					$_SESSION['new_account']['deposit'] = $_POST['deposit'];
					$errors = Account::checkDeposit($_POST);
					
					if ( is_array($errors) )
					{
						parent::addErrors($errors);
						header('Location: index.php?c=register&e=deposit');
						exit();
					}
				}
				
				$errors = parent::getErrors();
				$pageTitle = 'Account Setup - Password';
				
				include_once 'views/register_password.php';
			}
		}
		
		public function submit()
		{
			/* only allow access if:
			* 1. coming from the account password form
			*/
			if ( isset($_POST['password_submit']) )
			{
				$errors = Account::checkPasswords($_POST);
				
				if ( is_array($errors) )
				{
					parent::addErrors($errors);
					header('Location: index.php?c=register&e=password');
					exit();
				}
				
				$errors = Account::checkPersonalInfo($_SESSION['new_account']);
				if ( Account::emailInUse($_SESSION['new_account']['email']) )
				{
					if ( !isset($errors) || !is_array($errors) )
						$errors = array();
					$errors[] = 'That email is already in use.';
				}
				
				if ( is_array($errors) )
				{
					parent::addErrors($errors);
					header('Location:index.php?c=register&e=personalinfo');
					exit();
				}
				
				$check = Account::checkBeneficiaryInfo($_SESSION['new_account']);
				
				if ( !$check )
				{
					parent::addError('Please enter a first and last name for your beneficiary. A middle initial or name is optional.');
					header('Location: index.php?c=register&e=beneficiaryinfo');
					exit();
				}
				
				$errors = Account::checkDeposit($_SESSION['new_account']);
					
				if ( is_array($errors) )
				{
					parent::addErrors($errors);
					header('Location: index.php?c=register&e=deposit');
					exit();
				}
				
				$_SESSION['new_account']['password'] = sha1($_POST['password']);
				
				// at this point the registration process is complete
				new_account($_SESSION['new_account']['email']);
				Account::createAccount($_SESSION['new_account']);
				
				// log in the user
				$login = Account::login($_SESSION['new_account']['email'], $_SESSION['new_account']['password']);
				$_SESSION['email'] = $login->email;
				$_SESSION['password'] = $login->password;
				
				// after saving the info, all session data should be cleared
				unset($_SESSION['new_account']);
				
				header('Location: index.php?c=accountpage');
			}
		}
	}
?>