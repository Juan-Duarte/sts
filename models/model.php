<?php
	/*
	* Base class for all models
	*/
	class Model
	{
		// database connection info
		private static $host = 'localhost';
		private static $user = 'juan';
		private static $pass = 'nata';
		private static $db = 'juan_usts';
		private static $dbo = null;
		
		/*
		* Default constructor - does nothing. Protected so an instance of this class cannot be created
		*/
		protected function __construct()
		{
		}
		
		/*
		* Returns the database connection object to use. Creates one if one does not exist.
		* Should the connection fail, this method kills the script via exit()
		*/
		public static function getDBO()
		{
			if ( self::$dbo == null )
			{
				self::$dbo = new mysqli(self::$host, self::$user, self::$pass, self::$db);
			
				if ( self::$dbo->connect_errno )
					exit('DB connection failed.');
			}
			
			return self::$dbo;
		}
	}
?>
