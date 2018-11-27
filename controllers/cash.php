<?php
	include_once 'controllers/controller.php';
	include_once 'models/account.php';
	include_once 'lib/communication.php';
	
	class Cash extends Controller
	{
		public function start()
		{
			$account = parent::requireLogin();
			$errors = parent::getErrors();
			include_once 'views/cash_form.php';
		}
		
		public function submit()
		{
			if ( isset($_POST['cash_submit']) )
			{
				$account = parent::requireLogin();
				
				$check = $this->checkForm($_POST);
				
				if ( $check === true )
				{
					$change = $_POST['amount'];
					if ( $_POST['action'] === 'withdraw' )
					{
						$msg = 'You withdrew $'.$_POST['amount'];
						$change *= -1;
						withdraw($_POST['amount'], $account->email);
					}
					else
					{
						$msg = 'You deposited $'.$_POST['amount'];
						deposit($_POST['amount'], $account->email);
					}
					
					$account->balance += $change;
					
					
					include_once 'views/cash_receipt.php';
				}
				else
				{
					parent::addErrors($check);
					header('Location: index.php?c=cash');
					exit();
				}
			}
		}
		
		private function checkForm($post)
		{
			$account = parent::getAccount();
			$errors = array();
			
			if ( $post['action'] !== 'deposit' && $post['action'] !== 'withdraw' )
				$errors[] = 'Invalid action.';
			
			$match = '/^[[:digit:]]+(\.[[:digit:]]{2})?$/';
			if ( !preg_match($match, $post['amount']) )
				$errors[] = 'Invalid amount.';
				
			if ( $post['action'] === 'withdraw' )
			{
				if ( $post['amount'] > $account->balance )
					$errors[] = 'Insufficient funds.';
			}
			
			if ( count($errors) )
				return $errors;
			
			return true;
		}
	}
?>