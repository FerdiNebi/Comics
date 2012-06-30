<?php

/*This file capsulates all db functionality. This is useful for abstracting the database access. If we later wanna change the underlying database engine (say, use MSSQL instead of MySQL), we only need to change this file and not the rest of our website. There are many approaches to this. Here, we are preparing a set of functions called db_XXXX that are mostly just interface to the regular mysqli methods/functions. We can also build a new class and use it globally. Another approach is to use PDO. See db_pdo.php for details. */

require_once "../../configs/config.php"; //This file contains the credentials for our connection. Remember to put it outside the scope of our virtual host (so above the htdocs folder when on localhost, or above the public_html folder when on internet hosting) and provide the correct path.

define("DEBUG",true); //This statements defines a global constant. We use it to check whether to print detailed error messages or not.

//This is like the regular die function, it only checks if DEBUG is set as true. If yes, it prints the message we submitted (usually a detailed error message). If no (when we have already tested the site and put it on the production server), we just print a general error message.
function pretty_die($text)
{
	if (DEBUG)
		die("<div class=\"error\">$text</div>");
	else
		die("<div class=\"error\">An error occured. Please contact the administrator.</div>");
}

//Note how we have to declare the $db object as global, because it is outside the scope of the function body. This is peculiar for PHP. If we don't do that, we will be using a newly-defined $db variable, that is not bound to our database and will disappear upon the end of the function.
function db_close()
{
	global $db;
	$db->close();
}

//As said above, these functions are mostly just interfacing the regular mysqli functions with new names that become globally visible when the db.php is included in the other files. The parameter for this function is the result of a query. It is returned by the db_query function.
function db_get_row($result)
{
	return $result->fetch_assoc();
}

function db_query($query)
{
	global $db;
	$result = $db->query($query);
	//must have escaped the query!!!
	
	//echo "<!--$query-->";
	//This is for debugging purposes. Note we use the HTML comment, so that the text does not disrupt the look of the page. However, it is important to remember
	//that this will still break the redirection, because it is HTML output before the call to "header". So we need to comment this line when we have found the error.
	//Anyway, when we have an error, we don't need to redirect until the error is fixed.
	
	if (!$result) //$result will be false if something is wrong with our query
		pretty_die('Database Error: ' . mysqli_error($db)); //An example of functional call to mysqli_error instead of $db->error
	return $result;
}

//We use this function to escape our user input
function db_escape($input)
{
	global $db;
	return $db->real_escape_string($input);
}

function db_insert_id()
{
	global $db;
	return $db->insert_id;
}

//Here we create the $db object. The credential variables are declared in config.php
$db = new mysqli($HOST,$USER,$PASS,$DB);

//We need to tell MySQL that we are passing Unicode strings to it. There are two alternative ways to do this.

//$db->options(MYSQLI_INIT_COMMAND,"SET NAMES 'UTF8'"); //This issues a MySQL command after successful connection
$db->set_charset("utf8"); //This uses the ready mysqli function for setting proper charsets

if (mysqli_connect_error())
    pretty_die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error()); //We handle the possible connection error here
    
    
?>