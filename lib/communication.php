<?php
/* These functions can be used to automate communication with the users.
 * Feel free to edit the functions or scripts as you need.
 */
function new_account($email)
{
	//reads the email script in and stores it in $body
	$scriptReader = fopen("lib/new_account_email.txt", 'r');
	$body = fread($scriptReader, fileSize("lib/new_account_email.txt"));
	
	//sends the email
	return mail($email, "Welcome to USTS", $body, "From: noreply@ultimatests.com");
}

function deposit($amount, $email)
{
	//reads the email script in and stores it in $body
	$scriptReader = fopen("lib/deposit_email.txt", 'r');
	$body = fread($scriptReader, fileSize("lib/deposit_email.txt"));
	
	//substitutes in the sent values for $amount and $username 
	$body = str_replace("`amount`", $amount, $body);
	//sends the email
	return mail($email, "Deposit Completed", $body, "From: noreply@ultimatests.com");
	
}

function withdraw($amount, $email)
{
	//reads the email script and stores it in $body
	$scriptReader = fopen("lib/withdraw_email.txt", 'r');
	$body = fread($scriptReader, fileSize("lib/withdraw_email.txt"));
	
	//substitutes in the sent values for $username and $amount
	$body = str_replace("`amount`", $amount, $body);
	
	//sends the email
	return mail($email, "Withdrawal Completed", $body, "From: noreply@ultimatests.com");
	
}

function market_transaction($tradeType, $stock, $shares, $email)
{
	//reads in the email
	$scriptReader = fopen("lib/market_transaction.txt", 'r');
	$body = fread($scriptReader, fileSize("lib/market_transaction.txt"));
	
	//substitues in the sent values for $username, $stock, $typeOfTransaction, and $numberOfShares
	$body = str_replace("`stock`", $stock, $body);
	$body = str_replace("`trade_type`", $tradeType, $body);
	$body = str_replace("`shares`", $shares, $body);
	
	//sends the email
	return mail($email, "Transaction Completed", $body, "From: noreply@ultimatests.com");
}

function limit_transaction($tradeType, $stock, $shares, $orderType, $limit, $email)
{
	//reads in the email
	$scriptReader = fopen("lib/limit_transaction.txt", 'r');
	$body = fread($scriptReader, fileSize("lib/limit_transaction.txt"));
	
	//substitues in the sent values for $username, $stock, $typeOfTransaction, and $numberOfShares
	$body = str_replace("`stock`", $stock, $body);
	$body = str_replace("`trade_type`", $tradeType, $body);
	$body = str_replace("`shares`", $shares, $body);
	$body = str_replace("`order_type`", $orderType, $body);
	$body = str_replace("`limit`", $limit, $body);
	
	//sends the email
	return mail($email, "Transaction Completed", $body, "From: noreply@ultimatests.com");
}

function account_update($email)
{
	//reads in the email script
	$scriptReader = fopen("lib/update_email.txt", 'r');
	$body = fread($scriptReader, fileSize("lib/update_email.txt"));
	
	//sends the email
	return mail($email, "Account Information Updated", $body, "From: noreply@ultimatests.com");
}

function account_deleted($username, $email)
{
	//reads in the email script
	$scriptReader = fopen("lib/deletion_email.txt", 'r');
	
	//substitutes in the sent value for $username
	$body = fread($scriptReader, fileSize("lib/deletion_email.txt"));
	$body = str_replace("`uname`", $username, $body);
	
	//sends the email
	return mail($email, "Account Deleted", $body, "From: noreply@ultimatests.com");
}
?>