<?php
// A class to help work with Sessions
// Primarily to manage logging users in and out

class Session {

	private $logged_in=false;
	public $user_id;

	function __construct() {
		session_start();
		$this->check_login();
        if($this->logged_in) {
            // actions to take right away if user is logged in
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->user_first_name = $_SESSION['user_first_name'] = $user->first_name;
            $this->user_last_name = $_SESSION['user_last_name'] = $user->last_name;
            $this->user_email = $_SESSION['user_email'] = $user->email;
            $this->user_active = $_SESSION['user_active'] = $user->active;
        } else {
            // actions to take right away if user is not logged in
            header("Location: index.php");
        }
    }

  public function is_logged_in() {
    return $this->logged_in;
  }

	public function login($user) {
    // database should find user based on username/password
    if($user){
      $this->logged_in = true;
    }
  }

  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    unset($_SESSION['user_email']);
    unset($this->user_email);
    $this->logged_in = false;
  }

	private function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->logged_in = true;
    } else {
      unset($this->user_id);
      $this->logged_in = false;
    }
  }

}


?>
