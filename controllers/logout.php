<?php
	include_once 'controllers/controller.php';

	class Logout extends Controller
	{
		public function start()
		{
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			session_destroy();
			header('Location: index.php');
		}
	}
?>