<?php
session_start();

require_once(LIBRARY_PATH . DS . 'Template.php');
require_once(APP_PATH . DS . 'models/User.php');

class SessionController {

  public function __construct() {
    $this->template = new Template;
    $this->template->template_dir = APP_PATH . DS . 'views' . DS . 'session' . DS;

    $this->template->title = 'Log in';
  }

  public function add() {
    if (isset($_SESSION['session']['error'])) {
      $this->template->error = $_SESSION['session']['error'];
      unset($_SESSION['session']['error']);
    }
    $this->template->display('add.html.php');
  }

  public function create() {
    // TODO
    // get username and password
    // and validate them against values in db
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    if (!$user = User::retrieve(array('username' => $_POST['username']))) {
      // user doesn't exist
      // redirect back to login page
      $_SESSION['session']['error'] = "You cannot login with those details";
      header("Location: /~e46762/wda/showvotes/session/new");
      exit;
    }
    if ($_POST['password'] != $user->password) {
      // password is wrong
      // redirect back to login page
      $_SESSION['session']['error'] = "You cannot login with those details";
      header("Location: /~e46762/wda/showvotes/session/new");
      exit;
    }
    // credentials are correct
    // add user to session
    // redirect to users show page
    $_SESSION['user'] = $user->id;
    header("Location: /~e46762/wda/showvotes/users/{$user->id}");
    exit;
  }

}
