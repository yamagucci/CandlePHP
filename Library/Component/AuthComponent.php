<?php
class AuthComponent
{
	public $isLoggedIn;
	public $user_id;
	public $username;
	


	// コンストラクタ
	public function __construct()
	{
	    $this->User = $this->initAuth();
	}
	public function initAuth()
	{
	    session_start();
	    $this->isLoggedIn=isset($_SESSION["username"]);
	    $this->user_id=($this->isLoggedIn)?$_SESSION["id"]:0;
	    $this->username=($this->isLoggedIn)?$_SESSION["username"]:'NO NAME';
	    session_write_close();
	} 
}

?>