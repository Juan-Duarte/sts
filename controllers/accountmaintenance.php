<?php
	include_once 'controllers/controller.php';
	include_once 'models/account.php';
	include_once 'lib/communication.php';
	
	class AccountMaintenance extends Controller
	{
		public function __construct()
		{
		}
		
		public function start()
		{
			$this->viewInfo();
		}
		
		public function viewInfo()
		{
			$account = parent::requireLogin();
			
			if ( isset($_POST['pi_submit']) ) // user is saving personal info edits
			{
				$errors = Account::checkPersonalInfo($_POST);
				
				if ( is_array($errors) ) // if validation returned array of errors...
				{	// store errors in session and go back to personal info form
					parent::addErrors($errors);
					header('Location: index.php?c=accountmaintenance&e=editpersonalinfo');
					exit();
				}
				else
				{
					$account->updatePersonalInfo($_POST);
					account_update($account->email);
				}
			}
			
			if ( isset($_POST['bi_submit']) )
			{
				$check = Account::checkBeneficiaryInfo($_POST);
				
				if ( !$check )
				{
					parent::addError('Please enter a first and last name for your beneficiary. A middle initial or name is optional.');
					header('Location: index.php?c=accountmaintenance&e=editbeneficiaryinfo');
					exit();
				}
				else
				{
					$account->updateBeneficiaryInfo($_POST);
					account_update($account->email);
				}
			}
			
			if ( isset($_POST['pw_submit']) )
			{
				$_POST['current'] = sha1($_POST['current']);
				if ( !Account::login($account->email, $_POST['current']) )
				{
					parent::addError('Please enter your current password.');
					header('Location: index.php?c=accountmaintenance&e=editpassword');
					exit();
				}
				
				$errors = Account::checkPasswords($_POST);
				
				if ( is_array($errors) )
				{
					parent::addErrors($errors);
					header('Location: index.php?c=accountmaintenance&e=editpassword');
					exit();
				}
				
				$_POST['password'] = sha1($_POST['password']);
				
				$_SESSION['password'] = $_POST['password'];
				$account->updatePassword($_POST);
				account_update($account->email);
			}
			
			$pageTitle = 'Account Information';
			
			$dob = explode('-', $account->dob); // in yyyy-mm-dd from db
				$time = mktime(0, 0, 0, $dob[1], $dob[2], $dob[0]);
			$dob = date('M d, Y', $time);
			
			$name = $account->first_name;
			if ( !empty($account->middle_name) )
				$data['name'] .= ' '.$account->middle_name;
			$name .= ' '.$account->last_name;
			
			if ( $account->marital_status == 0 )
				$marital_status = 'Single';
			else
				$marital_status = 'Married';
			
			$line2 = $account->city.', '.$account->state.' '.$account->zip;
			
			include_once 'views/view_info.php';
		}
		
		public function editPersonalInfo()
		{
			$account = parent::requireLogin();
			
			$pageTitle = 'Account Information - Edit Personal Information';
			$errors = parent::getErrors();
			
			$dob = explode('-', $account->dob);
			$dob = $dob[1].'/'.$dob[2].'/'.$dob[0];
			
			include_once 'views/edit_personal_info.php';
		}
		
		public function editBeneficiaryInfo()
		{
			$account = parent::requireLogin();
			
			$pageTitle = 'Account Information - Edit Beneficiary Information';
			$errors = parent::getErrors();
			
			include_once 'views/edit_beneficiary_info.php';
		}
		
		public function editPassword()
		{
			$account = parent::requireLogin();
			
			$pageTitle = 'Account Information - Edit Beneficiary Information';
			$data['account'] = $_SESSION['account'];
			$errors = parent::getErrors();
			
			include_once 'views/edit_password.php';
		} 
		
		public function closeConfirm()
		{
			$account = parent::requireLogin();
			$errors = parent::getErrors();
			include_once 'views/close_confirm.php';
		}
		
		public function close()
		{
			$account = parent::requireLogin();
			if ( isset($_POST['close_submit']) )
			{
				$pw = sha1($_POST['password']);
				if ( Account::login($account->email, $pw) === false )
				{
					parent::addError('Incorrect password');
					header('Location: index.php?c=accountmaintenance&e=closeconfirm');
					exit();
				}
				else
				{
					$account->close();
					unset($_SESSION['email']);
					unset($_SESSION['password']);
					session_destroy();
					header('Location: index.php');
					exit();
				}
			}
		}
	}
?>