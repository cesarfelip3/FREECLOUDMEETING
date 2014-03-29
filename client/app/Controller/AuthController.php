<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::uses('Sanitize', 'Utility');

// load model 
//App::uses('BbbAPI', 'Model');

class AuthController extends AppController {

    //theme/theme_name/view_name
    //create a "themed" in view, and default in it
    //public $view   = 'Theme';
    //public $theme = 'default';
    //public $name = 'Pages';
    // disable model
    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {

        if (!empty($this->_identity)) {
            $this->redirect("/panel/");
            exit;
        }

        $this->redirect("/signin");
    }

    public function signup() {
        $this->layout = false;

        if (!empty($this->_identity)) {
            $this->redirect("/panel/");
            exit;
        }

        $this->loadModel('User');

        if ($this->request->isPost()) {
            $data = $this->data['User'];

            $username = trim($data['user_name']);
            $email = trim($data['user_email']);
            $password = $data['user_password'];
            $confirm = $data['confirm'];

            if (empty($username)) {
                $this->Session->setFlash('Your name is required');
                return;
            }

            if (empty($email)) {
                $this->Session->setFlash('Your email is required');
                return;
            }

            if (empty($password)) {
                $this->Session->setFlash('Password is required');
                return;
            }

            if (preg_match("/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/", $email) == false) {
                $this->Session->setFlash('Please enter a valid email address');
                return;
            }

            if ($password != $confirm) {
                $this->Session->setFlash('Password not match');
                return;
            }

            //save user here
            unset($data['confirm']);

            $data['user_created'] = time();
            $data['user_level'] = 1;
            $data['user_status'] = 0;
            $data['user_password'] = Security::hash($data['user_password']);
            $data['user_activecode'] = Security::hash(String::uuid());
            $data['user_activestart'] = time();
            $data['user_guid'] = String::uuid();

            $data['user_name'] = Sanitize::escape($data['user_name'], "default");

            if ($this->User->getUserByEmail($email)) {
                $this->Session->setFlash('This email already exists, you can signin to your account');
                return;
            }

            $ret = $this->User->save($data);

            if ($ret) {
                $this->sendActiveLink($data['user_guid'], $data['user_activecode'], $email);
                $this->redirect("/signup2?p=" . $data['user_guid'] . "&a=active");
            }
        }
    }

    public function signup2() {
        $this->layout = false;

        if (!empty($this->_identity)) {
            $this->redirect("/panel/");
            exit;
        }

        $code = isset($_GET['code']) ? $_GET['code'] : "";
        $code = trim($code);

        $guid = isset($_GET['p']) ? $_GET['p'] : "";
        $action = isset($_GET['a']) ? $_GET['a'] : "";

        if (!empty($guid)) {
            $this->loadModel('User');
            $data = $this->User->findByUserGuid($guid);

            if (empty($data)) {
                $this->redirect("/signup");
            }

            if ($data['User']['user_active'] == 1) {
                $this->redirect("/signin");
            }

            if (!empty($action) && $action == "resend") {

                $activecode = Security::hash(String::uuid());
                $value = array(
                    'user_activecode' => "'" . $activecode . "'",
                    'user_activestart' => time()
                );

                $this->User->updateAll($value, array("User.user_guid" => $guid));
                $this->sendActiveLink($guid, $activecode);
            }

            if (!empty($code)) {
                if ($code == $data['User']['user_activecode']) {

                    $now = time();
                    $time = $data['User']['user_activestart'];

                    if ($now > $time + 3600 * 24 * 1000) {
                        $this->set("title", "Your link was expired");
                        $this->set("message", "Sorry, your active link already expired, please click the button below to re-send it.");
                    } else {

                        $value['user_active'] = 1;
                        $value['user_activecode'] = "''";
                        $value['user_activestart'] = 0;
                        $this->User->updateAll($value, array("User.user_guid" => $guid));

                        $this->set("title", "Your account is actived successfully");
                        $this->set("message", "You can open signin page to start your service now.");
                        $this->set("success", true);
                    }
                }
            }

            $this->set("guid", $guid);
            return;
        }
    }

    public function signin() {
        $this->layout = false;

        if (!empty($this->_identity)) {
            $this->redirect("/panel/");
            exit;
        }        

        $this->loadModel('User');
        if ($this->request->isPost()) {

            $data = $this->data['User'];

            $email = trim($data['user_email']);
            $password = $data['user_password'];
            $rememberMe = $data['remember_me'];
            
            if (preg_match("/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/", $email) == false) {
                $this->Session->setFlash('Please enter a valid email address');
                return;
            }

            if (empty($password)) {
                $this->Session->setFlash('Password is required');
                return;
            }
            
            $user = $this->User->findByUserEmailAndUserPassword($email, Security::hash($password));

            if (!empty($user)) {
                unset($user['User']['user_password']);
                Configure::write('Session.timeout', 60 * 60);

                if ($rememberMe == 1) {
                    Configure::write('Session.timeout', 60 * 60 * 24 * 366);
                }
                $this->Session->write(parent::_authentication_session, $user);
                $this->redirect("/panel/");
                exit;
            } else {
                $this->Session->setFlash('Username or password is incorrect');
            }
        }
    }

    public function logout() {
        $this->Session->destroy();
        $this->redirect("/signin");
    }

    public function reset() {
        $this->layout = false;
        if (!empty($this->_identity)) {
            $this->redirect("/panel/");
            exit;
        }
		
		$this->loadModel ("User");
        if ($this->request->isPost()) {
			
			$email = $this->data['User']['user_email'];
			
			if (empty ($email)) {
				$this->Session->setFlash('Please enter a valid email address');
				return;
			}
			
			if (preg_match("/^[A-Za-z0-9._%+-]+@([A-Za-z0-9-]+\.)+([A-Za-z0-9]{2,4}|museum)$/", $email) == false) {
                $this->Session->setFlash('Please enter a valid email address');
                return;
            }
			
			$user = $this->User->findByUserEmail($email);
			if (!empty ($user)) {
				$user = $user['User'];
				
				$activecode = Security::hash(String::uuid());
				$password = Security::hash(String::uuid());
                $value = array(
                    'user_password' => "'" . $password . "'",
					'user_activecode' => "'" . $activecode . "'",
                    'user_activestart' => time()
                );

                $this->User->updateAll($value, array("User.user_guid" => $user['user_guid']));
				//print_r ($user);
				//exit;
                $this->sendResetLink($user['user_guid'], $activecode, $email);
				$this->redirect ("/reset2");
			} else {
				$this->Session->setFlash('The email address doesn\'t exist');
			}
            //$this->debug ($_POST, true);
			
        }
		
		
    }

    public function reset2() {
        
		$this->layout = false;

        if (!empty($this->_identity)) {
            $this->redirect("/panel/");
            exit;
        }

        $code = isset($_GET['code']) ? $_GET['code'] : "";
        $code = trim($code);

        $guid = isset($_GET['p']) ? $_GET['p'] : "";
		
        if (!empty($guid)) {
            $this->loadModel('User');
            $user = $this->User->findByUserGuid($guid);

            if (empty($user)) {
                $this->redirect("/signup");
            }

            if (!empty($code)) {
                if ($code != $user['User']['user_activecode']) {
 					$this->redirect("/reset");
				} else if ($this->request->isPost()) {
					$data = $this->data['User'];
					$password = $data['user_password'];
					$confirm = $data['user_confirm'];
					
					if (empty ($password)) {
						$this->Session->setFlash('Empty password isn\'t allowed');
						return;
					}
					
					if ($password != $confirm) {
						$this->Session->setFlash('Password doesn\'t match');
						return;
					}
					
					$user = $user['User'];
					
					$value['user_password'] = "'" . Security::hash($password) . "'";
					$value['user_activecode'] = "''";
					$value['user_activestart'] = 0;
					$this->User->updateAll($value, array("User.user_guid" => $user['user_guid']));
					$this->redirect('/signin');
					
                }
				$this->set('step', "2");
            }

            return;
        }
		
		$this->set('step', "1");
		return;
    }

    public function subscribe() {
        $this->layout = false;

        if ($this->request->isPost()) {

            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $rememberme = trim($_POST['rememberme']);

            $this->set("email", $email);

            $this->debug($_POST, true);
        }

        $this->redirect("http://cloudconferenceroom.com/index.html");
    }

    //------------------------------------------
    //
    //-----------------------------------------

    public function sendActiveLink($guid, $activecode, $emailaddress) {
        $email = new CakeEmail();
        $email->config ("gmail");
        $email->emailFormat('html');
        $email->from(array('cloudconferenceroom@gmail.com' => 'Active Your Account Now - cloudconferenceroom.com'));
        $email->to($emailaddress);
        $email->subject('Active Your Account Now - cloudconferenceroom.com');

        $html = file_get_contents(dirname(__FILE__) . "/Templates/EmailTemplateActive.php");
        $link = parent::_siteurl . "/signup2?p=" . $guid . "&code=" . $activecode;

        $html = str_replace('$url', $link, $html);

        //$this->debug ($html, true);
        $email->send($html);
    }

    public function sendResetLink($guid, $activecode, $emailaddress) {
        $email = new CakeEmail();
        $email->config ("gmail");
        $email->emailFormat('html');
        $email->from(array('cloudconferenceroom@gmail.com' => 'Your password is reset - cloudconferenceroom.com'));
        $email->to($emailaddress);
        $email->subject('Your password is reset - cloudconferenceroom.com');

        $html = file_get_contents(dirname(__FILE__) . "/Templates/EmailTemplateReset.php");
        $link = parent::_siteurl . "/reset2?p=" . $guid . "&code=" . $activecode;

        $html = str_replace('$url', $link, $html);

        //$this->debug ($html, true);
        $email->send($html);
    }

}
