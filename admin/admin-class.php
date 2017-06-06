<?php
//including the database file in the directory
include_once('../db/db.php')

//now,the main class of login. All the necessary system functions are to be made in the login-action.php file
//_authenticate: to be used in every file where admin restriction is to be inherited.
class itg_admin {
	//Holds the script directory absolute path
	static $abs_path;
	//store the clear(without slash) value of post variable
	var $post = array();
	//store the sanistized and decoded value of get variable
	var $get = array();
	//the construct function of admin class,we will start the session, It is necessary to start a session variable to the super global $_SESSION variable

	//calling the constructor function of the admin class to initalise the get and post variables
	public function __construct() {
	session_start();
	//storing the absolute script directory (not admin directory)
	self::$abs_path = dirname(dirname(__FILE__));
	//initialize the post variable
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$this->post = $_POST;
		if (get_magic_quotes_gpc()) {
			//get rid of the magic quotes and slashes if present
			array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
		}
	}
	//initalise the get variable
	$this->get = $_GET;
	//decode the url
	array_walk_recursive($this->get, array($this,'urldecode'));
	}

	//function to return the nicename of currently logged in admin (return string the nice name of user)
	public function get_nicename() {
		$username = $_SESSION['admin_login'];
		global $db;
		$info = $db->get_row("SELECT  `nicename` FROM `user` WHERE `username` ='".$db->escape($username)."'");
		if (is_object($info))
			return $info->nicename;
		else 
			return '';
	}

	//function to return the email of currently loggede in admin user( return the string of the email of the user)
	public function get_email() {
		$username = $_SESSION['admin_login'];
		global $db;
		$info = $db->get_row("SELECT `email` FROM `user` WHERE `username`='".$db->escape($username)."'");
		if (is_object($info))
			return $info->email;
		else
			return '';
	}

	//checking for the login in the action file
	public function _login_action() {
		//insufficient data provided
		if(!isset($this->post['username']) || $this->post['username']=='' || (!isset($this->post['password']) || $this->post['password']=='')
		{
			header("Location : login.php");
		}

		//getting the username and password 
		$username = $this->post['username'];
		$password = md5(sha1($this->post['password']));

		//checking the database for username
		if ($this->_check_db($username, $password)){
			//ready to login
			$_SESSION['admin_login'] = $username;

			//check to see if remember, i.e,if cookie
			if (isset($this->post['remember']){
				//set of cookies for 1 day, i.e, 30*24*60*60 sec
				//rememebering user for a month
				setcookie('username', $username, time()+30*24*60*60);
				setcookie('password', $password, time()+30*24*60*60);
			} else{
				//destroy any previously set cookie 
				setcookie('username','',time()-30*24*60*60);
				setcookie('password','',time()-30*24*60*60);	
			}
			header("Location: index.php");
		}
		else {
			header("Location: login.php");
		}
		die();
	}



	/**
	*Checks for the authentication of user to access the admin page or not
	*redirects to login.php page, if not authenticates
	*
	*@access public
	*@return void 
	*/

	public function _authenticate(){
		//first check whether the session is set of not
		if(!isset($_SESSION['admin_login'])) {
			//checking is the cookie is set or not
			if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
				//cookie found, checking if is it really in use
				if($this->_check_db($_COOKIE['username'], $_COOKIE['password'])){
					$_SESSION['admin_login'] = $_COOKIE['username'];
					header("Location: index.php");
					die();
				}else{
					header("Location: login.php");
					die();
				}
			}else{
				header("Location: login.php");
				die();
			}
		}
	}
	/**
	*check the database for login user
	*getting the password here for admin panel
	*comapring than md5 hash over sha1
	*boolean expression given in result
	*/

	private function _check_db($username, $password) {
		global $db;
		$user_row = $db->get_row("select * from `user` where `username`='".$db->escape($username)."'");

		//general return 
		if(is_object($user_row) && md5($user_row->password) == $password)
			return true;
		else
			return false;
	}

	//stripslash gpc: strip the slashes from a string added by the magic quote gpc thingy
	private function stripslash_gpc(&$value){
		$value = stripslashes($value);
	}
	//htmlspecialcarfy: encodes string's special html characters @access proctected @param string $value
	private function htmlspecialcarfy(&$value){
		$value = htmlspecialchars($value);
	}
	//URL decode- Decodes a URL encoded string @access protected @param string $value
	protected function urldecode(&$value) {
		$value = urldecode($value);
	}
}

?>