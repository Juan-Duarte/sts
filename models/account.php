<?php
	include_once 'models/model.php';
	
	class Account extends Model
	{
		private $data;
		
		protected function __construct($data)
		{
			$this->data = $data;
		}
		
		
		public function __get($col)
		{
			if ( array_key_exists($col, $this->data) )
				return $this->data[$col];
			return null;
		}
		
		public function __set($col, $val)
		{
			if ( array_key_exists($col, $this->data) )
			{
				$dbo = parent::getDBO();
				$sql = "UPDATE accounts
						SET ".$col." = '".$val."'
						WHERE id = ".$this->data['id'];
				$res = $dbo->query($sql);
				
				if ( !$res )
					exit('Failed to update DB: '.$sql.' '.$dbo->error);
				
				$this->data[$col] = $val;
			}
		}
		
		public function close()
		{
			$dbo = parent::getDBO();
			$id = $this->data['id'];
			// delete all transactions
			$sql = "DELETE FROM transactions WHERE account_id = $id";
			$res = $dbo->query($sql);
			if ( !$res )
				exit('Could not delete transactions: '.$dbo->error);
			
			// delete portfolio
			$sql = "DELETE FROM portfolios WHERE account_id = $id";
			$res = $dbo->query($sql);
			if ( !$res )
				exit('Could not delete portfolios: '.$dbo->error);
			
			// delete account
			$sql = "DELETE FROM accounts WHERE id = $id";
			$res = $dbo->query($sql);
			if ( !$res )
				exit('Could not delete account: '.$dbo->error);
		}
		
		public function updatePassword($info)
		{
			$dbo = parent::getDBO();
			$sql = "UPDATE accounts
					SET password = '".$info['password']."'
					WHERE id = ".$this->data['id'];
			$res = $dbo->query($sql);
			
			if ( $res === false )
				exit('Update failed. Please try again.');
			
			$sql = 'SELECT * FROM accounts WHERE id = '.$this->id;
			$res = $dbo->query($sql);
			
			$this->data = $res->fetch_assoc();
		}
		
		public function updateBeneficiaryInfo($info)
		{
			$dbo = parent::getDBO();
			$sql = "UPDATE accounts
					SET beneficiary = '".$info['beneficiary']."'
					WHERE id = ".$this->data['id'];
			$res = $dbo->query($sql);
			
			if ( $res === false )
				exit('Update failed. Please try again.');
			
			$sql = 'SELECT * FROM accounts WHERE id = '.$this->data['id'];
			$res = $dbo->query($sql);
			
			$this->data = $res->fetch_assoc();
		}
		
		public function updatePersonalInfo($info)
		{
			$dbo = parent::getDBO();
			Account::dobToDB($info['dob']);
			$sql = "UPDATE accounts
					SET email = '".$info['email']."',
						first_name = '".$info['first_name']."',
						middle_name = '".$info['middle_name']."',
						last_name = '".$info['last_name']."',
						address = '".$info['address']."',
						city = '".$info['city']."',
						zip = '".$info['zip']."',
						home_phone = '".$info['home_phone']."',
						cell_phone = '".$info['cell_phone']."',
						dob = '".$info['dob']."',
						marital_status = '".$info['marital_status']."'
					WHERE id = ".$this->data['id'];
			$res = $dbo->query($sql); 
			
			if ( $res === false )
				exit('Update failed. Please try again.');
			
			$sql = 'SELECT * FROM accounts WHERE id = '.$this->data['id'];
			$res = $dbo->query($sql);
			
			$this->data = $res->fetch_assoc();
		}
		
		public static function dobToDB(&$dob) // from mm/dd/yyyy to yyyy-mm-dd
		{
			$dob = explode('/', $dob);
			$dob = $dob[2].'-'.$dob[0].'-'.$dob[1];
		}
		
		public static function dobFromDB(&$dob)
		{
			$dob = explode('-', $dob);
			$dob = $dob[1].'/'.$dob[2].'/'.$dob[0];
		}
		
		/*
		* Checks if the password matches the account email
		* $pw - should be sha1() hash of the password
		* returns false if invalid login
		* returns an associative array (row => column) of the user's info
		*/
		public static function login($email, $pw)
		{
			$sql = "SELECT *
			        FROM accounts
						WHERE email = '".$email."'
						AND password = '".$pw."'";
			$dbo = parent::getDBO();
			$res = $dbo->query($sql);
			
			if ( $res->num_rows == 1 )
				return new Account($res->fetch_assoc());
			return false;
		}
		
		/*
		* Inserts data from the account setup to the database
		* Assumes the data has already been sanitized
		* Does not return anything. If it fails, it exits the script and displays a simple error message.
		*/
		public static function createAccount($info)
		{
			$dbo = parent::getDBO();
			
			$exp = explode('/', $info['dob']); // mm/dd/yyyy
			$info['dob'] = $exp[2].'-'.$exp[0].'-'.$exp[1]; // save it as yyyy-mm-dd
			
			$info['marital_status'] = strcmp($info['marital_status'], 'single') == 0 ? 0 : 1;
			
			$sql = "INSERT INTO accounts
			(
				email,
				password,
				first_name,
				middle_name,
				last_name,
				address,
				city,
				state,
				zip,
				home_phone, 
				cell_phone, 
				dob, 
				marital_status, 
				beneficiary,
				balance
			)
			VALUES
			('".
				$info['email']."','".
				$info['password']."','".
				$info['first_name']."','".
				$info['middle_name']."','".
				$info['last_name']."','".
				$info['address']."','".
				$info['city']."','".
				$info['state']."','".
				$info['zip']."','".
				$info['home_phone']."','".
				$info['cell_phone']."','".
				$info['dob']."','".
				$info['marital_status']."','".
				$info['beneficiary']."','".
				$info['deposit']."'
			)";
			
			$res = $dbo->query($sql);
			
			if ( $res !== true )
			{
				echo $dbo->error;
				exit('Insertion failed. Please try again.');
			}
			$id = $dbo->insert_id;
			$post = $id % 10000; // makes it 4 digits
			$post = str_pad($post, 4, '0', STR_PAD_LEFT);
			
			$pre = time() % 10000;
			$pre = str_pad($pre, 4, '0', STR_PAD_LEFT);
			$account_number = "$pre"."$post";
			
			$sql = "UPDATE accounts
					SET account_number = '".$account_number."'
					WHERE id = ".$id;
			$res = $dbo->query($sql);
			
			if ( $res !== true )
				exit('Something really bad happened. Contact an admin. With this message: '.$dbo->error);
		}
		
		/*
		* Checks POST data from password form
		* returns an array of error messages if invalid
		* returns true if ok
		*/
		public static function checkPasswords($info)
		{
			$errors = array();
			
			if ( strcmp($info['password'], $info['confirm']) != 0 )
				$errors[] = 'Your password entries did not match.';
			
			$match = '/^[[:alnum:][:punct:]]{8,32}$/';
			if ( !preg_match($match, $info['password']) )
				$errors[] = 'Your password may only contain letters, numbers, and punctuation. The minumum length is 8 characters and the maximum is 32 characters.';
			
			if ( count($errors) )
				return $errors;
			
			return true;
		}
		
		/*
		* Checks the POST data from the opening deposit form
		* returns an array of error messages or
		* true if ok
		*/
		public static function checkDeposit($info)
		{
			$errors = array();
			
			$match = '/^[[:digit:]]+(\.[[:digit:]]{2})?$/'; // matches any valid dollar amount
			if ( !preg_match($match, $info['deposit']) )
				$errors[] = 'Please enter a valid dollar amount.';
			
			if ( $info['deposit'] < 1000 )
				$errors[] = 'The minimum opening deposit is $1,000.00';
			
			if ( $info['deposit'] > 1000000 )
				$errors[] = 'The maximum opening deposit is $1,000,000.00';
			
			if ( count($errors) )
				return $errors;
			
			return true;
		}
		
		/*
		* Checks POST data from beneficiary info form
		* $info - should be the $_POST from the beneficiary info form
		* returns true if valid beneficiary and false otherwise
		*/
		public static function checkBeneficiaryInfo($info)
		{
			// matches "first last" or "first middle last"
			$match = '/^[[:alpha:]]{2,32} ([[:alpha:]]{1,32} )?[[:alpha:]]{2,32}$/';
			return preg_match($match, $info['beneficiary']) != 0;
		}
		
		public static function emailInUse($email)
		{
			$sql = "SELECT id FROM accounts WHERE email = '".$email."'";
			$dbo = parent::getDBO();
			$res = $dbo->query($sql);
			if ( $res->num_rows != 0 )
				return true;
			return false;
		}
		
		/*
		* Checks POST data from personal info form.
		* $info - should be the $_POST from the personal info page
		* returns true if everything is valid
		* returns an array of strings that are error messages
		*/
		public static function checkPersonalInfo($info)
		{
			$nameMatch = '/^[[:alpha:]]{2,32}$/'; // matches letters, 2-32 characters
			$middleMatch = '/^[[:alpha:]]{0,32}$/'; // letters, 0-32 characters
			$dobMatch = '#^[[:digit:]]{1,2}/[[:digit:]]{1,2}/[[:digit:]]{4}$#'; // matches date format mm/dd/yyyy 
			$addressMatch = '/^[[:alnum:]\s\.]{3,32}$/'; // matches any alpha-numeric string with spaces allowed, 3-32 characters
			$cityMatch = '/^[[:alpha:]]{2,32}$/'; // matches letters, 2-32 characters
			$stateMatch = '/^[[:alpha:]]{2}$/'; // matches two letters
			$zipMatch = '/^[[:digit:]]{5}$/'; // matches 5 digits
			$phoneMatch = '/^[[:digit:]]{10,}$/'; // matches 10 digits
			$maritalMatch = '/^(single|married)$/'; // matches 'single' or 'married'
			
			$errors = array();
			
			if ( !self::validEmail($info['email']) )
				$errors[] = 'You have entered an invalid email address.';
			
			if ( !preg_match($nameMatch, $info['first_name']) )
				$errors[] = 'Your first name must be at least 2 characters long and must not exceed 32 characters. Only letters are allowed';
			
			if ( !preg_match($middleMatch, $info['middle_name']) )
				$errors[] = 'Your middle name can only contain letters.';
				
			if ( !preg_match($nameMatch, $info['last_name']) )
				$errors[] = 'Your last name must be at least 2 characters long and must not exceed 32 characters. Only letters are allowed';
			
			// only chrome supports the <input type="date">, so for everything else we gotta check the right format
			// chrome sends it in YYYY-MM-DD format
			if ( !preg_match($dobMatch, $info['dob']) )
				$errors[] = 'Please enter your date of birth in MM/DD/YYYY format.';
			
			$dob = explode('/', $info['dob']);
			$dobtime = mktime(0, 0, 0, $dob[0], $dob[1], $dob[2]);
			
			if ( !$dobtime )
				$errors[] = 'Invalid date of birth.';
			
			$age = time() - $dobtime;
			$eighteen = 18 * 365 * 24 * 60 * 60; // 18 years in seconds
			
			if ( $age < $eighteen )
				$errors[] = 'Sorry, you must be at least 18 years old to register.';
			
			if ( !preg_match($addressMatch, $info['address']) )
				$errors[] = 'Your address must be between 3 and 32 characters and can only contain letters and numbers.';
			
			if ( !preg_match($cityMatch, $info['city']) )
				$errors[] = 'Your city must be between 2 and 32 characters and can only contain letters.';
			
			if ( !preg_match($stateMatch, $info['state']) )
				$errors[] = 'Please enter your state as a two character abbreviation.';
			
			if ( !preg_match($zipMatch, $info['zip']) )
				$errors[] = 'Your zip code must be 5 digits.';
			
			if ( !preg_match($maritalMatch, $info['marital_status']) )
				$errors[] = 'Invalid marital status.';
			
			
			if ( (strlen($info['home_phone']) > 0 && !preg_match($phoneMatch, $info['home_phone']))
			|| (strlen($info['cell_phone']) > 0 && !preg_match($phoneMatch, $info['cell_phone'])) )
				$errors[] = 'Your phone number must be at least 10 digits. Enter only numbers please.';
			

			if ( count($errors) > 0 )
				return $errors;
			
			return true;
		}
		
		/*
		* Validate an email address.
		* Provide email address (raw input)
		* Returns true if the email address has the email address format
		*/
		public static function validEmail($email)
		{
		   $isValid = true;
		   $atIndex = strrpos($email, "@");
		   if (is_bool($atIndex) && !$atIndex)
		   {
			  $isValid = false;
		   }
		   else
		   {
			  $domain = substr($email, $atIndex+1);
			  $local = substr($email, 0, $atIndex);
			  $localLen = strlen($local);
			  $domainLen = strlen($domain);
			  if ($localLen < 1 || $localLen > 64)
			  {
				 // local part length exceeded
				 $isValid = false;
			  }
			  else if ($domainLen < 1 || $domainLen > 255)
			  {
				 // domain part length exceeded
				 $isValid = false;
			  }
			  else if ($local[0] == '.' || $local[$localLen-1] == '.')
			  {
				 // local part starts or ends with '.'
				 $isValid = false;
			  }
			  else if (preg_match('/\\.\\./', $local))
			  {
				 // local part has two consecutive dots
				 $isValid = false;
			  }
			  else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
			  {
				 // character not valid in domain part
				 $isValid = false;
			  }
			  else if (preg_match('/\\.\\./', $domain))
			  {
				 // domain part has two consecutive dots
				 $isValid = false;
			  }
			  else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local)))
			  {
				 // character not valid in local part unless 
				 // local part is quoted
				 if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
				 {
					$isValid = false;
				 }
			  }
		   }
		   return $isValid;
		}
	}
?>