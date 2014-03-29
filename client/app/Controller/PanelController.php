<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::uses('Sanitize', 'Utility');

// load model 
//App::uses('BbbAPI', 'Model');

class PanelController extends AppController {

    //theme/theme_name/view_name
    //create a "themed" in view, and default in it
    //public $view   = 'Theme';
    //public $theme = 'default';
    //public $name = 'Pages';
    //
    // disable model
    public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        if (empty($this->_identity)) {
            $this->redirect("/signin");
            exit;
        }
    }

    public function index() {
        $this->layout = false;

        //$this->debug ($this->_identity, true);

        $id = $this->_identity['User']['user_id'];
        $guid = $this->_identity['User']['user_guid'];

        $this->loadModel("Meeting");
        $totalMeetings = $this->Meeting->find("count", array(
            "conditions" => array('Meeting.user_id' => $id)
        ));


        if ($this->request->isPost()) {

            $data = $this->data['Meeting'];
            if (!empty($data['meeting_name'])) {

                $this->loadModel("Service");
                $service = $this->Service->findByUserId($id);

                if (!empty($service)) {
                    $maxusers = $service['service_maxusers'];
                    $maxmeetings = $service['service_maxmeetings'];
                } else {
                    $maxusers = 20;
                    $maxmeetings = 1;
                }

                if ($totalMeetings >= $maxmeetings) {
                    $this->Session->setFlash("Your account has privilege to create $maxmeetings meetings");
                } else {

                    $data ['meeting_guid'] = md5(String::uuid());
                    $data ['meeting_duration'] = 0;
                    $data ['meeting_created'] = time();
                    $data ['meeting_moderator'] = String::uuid();
                    $data ['meeting_attendee'] = String::uuid();
                    $data ['meeting_logouturl'] = parent::_siteurl . "/invite?i=" . urlencode($data ['meeting_guid']) . "&u=" . urlencode($guid);
                    $data ['meeting_maxusers'] = $maxusers;
                    $data ['meeting_welcome'] = "";
                    $data ['user_id'] = $id;

                    $this->loadModel("BbbAPI");

                    $param = array(
                        "name" => $data['meeting_name'],
                        "meetingID" => $data['meeting_guid'],
                        "moderatorPW" => $data['meeting_moderator'],
                        "attendeePW" => $data['meeting_attendee'],
                        //"welcome" => $data['meeting_welcome'],
                        "logoutURL" => $data['meeting_logouturl'],
                        "maxParticipants" => $data['meeting_maxusers'],
                        "duration" => $data['meeting_duration']
                    );

                    $data ['meeting_params'] = $this->BbbAPI->params($param);

                    $this->Meeting->save($data);
                }
            } else {
                $this->Session->setFlash("Name is required");
            }
        }

        $data = $this->Meeting->findAllByUserId($id, array(), array("Meeting.meeting_id" => "asc"));
        $this->set("data", $data);

        $link = parent::_siteurl . "/invite?i=";
        $this->set("inviteLink", $link);

        $link = parent::_siteurl . "/panel/join?g=" . $guid . "&i=";
        $this->set("joinLink", $link);
    }

    public function join() {

        $this->layout = false;

        $this->loadModel("Meeting");

        $guid = isset($_GET['g']) ? $_GET['g'] : '';
        $meetingGuid = isset($_GET['i']) ? $_GET['i'] : '';

        $message = "";

        if (empty($guid)) {
            $message = "The link malformatted";
            return;
        }

        if (empty($meetingGuid)) {
            $message = "The link malformatted";
            return;
        }

        $meeting = $this->Meeting->findByMeetingGuid($meetingGuid);
        $meeting = $meeting['Meeting'];

        if (!empty($meeting)) {
            //$this->debug ($meeting, true);

            $params = $meeting['meeting_params'];
            $this->loadModel("BbbAPI");

            if ($this->BbbAPI->createMeeting($params)) {

                $param = array(
                    "meetingID" => $meetingGuid,
                    "fullName" => $this->_identity['User']['user_name'],
                    "password" => $meeting['meeting_moderator']
                );
                $url = $this->BbbAPI->joinMeeting($param);
                //$this->debug ($url, true);

                if (!empty($url)) {
                    $this->redirect($url);
                } else {
                    $message = "We are sorry to tell you that there are something wrong happened on server.";
                }
            } else {
                $message = "We are sorry to tell you that there are something wrong happened on server.";
            }
        }
        exit;
    }

    public function account() {

        $this->layout = false;

        $this->loadModel("User");
        //$this->debug ($this->_identity, true);

        $guid = $this->_identity['User']['user_guid'];

        $user = $this->User->findByUserGuid($guid);
        $user = $user['User'];

        if (empty($user)) {
            $this->Session->destroy();
            $this->redirect('/signin');
        }
        

        if ($this->request->isPost()) {

            $data = $this->data['User'];

            if ($data['form'] == 'form_profile') {
                if ($user['user_name'] == trim($data['user_name']) &&
                        $user['user_email'] == trim($data['user_email']) &&
                        empty($data['user_password'])) {
                    
                } else {

                    $value = array();
                    $emailChanged = false;

                    // security issue bug

                    if (trim($data['user_name']) != $user['user_name']) {
                        $value['user_name'] = "'" . trim($data['user_name']) . "'";
                    }

                    if (trim($data['user_email'] != $user['user_email'])) {
                        //$value['user_email'] = "'" . trim ($data['user_email']) . "'";
                        $emailChanged = true;
                    }

                    if ($data['user_password'] != $data['user_confirm']) {
                        $this->Session->setFlash("Password doesn't match");
                    } else {

                        if (!empty($data['user_password'])) {
                            $value['user_password'] = "'" . Security::hash($data['user_password']) . "'";
                        }

                        $this->User->updateAll($value, array('user_guid' => $user['user_guid']));
                        $user = $this->User->findByUserGuid($guid);
                        $user = $user['User'];
                    }
                }
            }

            if ($data['form'] == 'form_invitepage') {

                $value = array();
                
                if (!empty ($data['post_title'])) {
                    $value['post_title'] = $data['post_title'];
                }
                
                if (!empty ($data['post_content'])) {
                    $value['post_content'] = $data['post_content'];
                }
                
                $value['user_guid'] = $guid;
                $value['post_created'] = time();
                $value['post_status'] = "publish";
                $value['post_type'] = "page";
                $value['post_path'] = "invite";
                $value['post_guid'] = String::uuid();

                $file = $data['post_logo'];

                if ($file['error'] === UPLOAD_ERR_OK) {

                    $allowed = array("jpg", "jpeg", "png", "gif");
                    $filename = strtolower($file['name']);
                    $extension = pathinfo($filename, PATHINFO_EXTENSION);
                    $filename2 = uniqid() . "." . $extension;

                    if (!in_array($extension, $allowed)) {
                        $this->Session->setFlash("File extension must be jpg,jpeg,png,gif");
                    } else if ($file['size'] / 1024 > 1024) {
                        $this->Session->setFlash("File size must less than 1MB");
                    } else if (move_uploaded_file($file['tmp_name'], WWW_ROOT . 'image/' . $filename2)) {
                        $value['post_url'] = "image/" . $filename2;

                        $this->loadModel('Post');
                        $post = $this->Post->findByUserGuidAndPostPath($guid, 'invite');
                        
                        if (!empty($post) && $post['Post']['post_path'] == 'invite') {
                            $value['post_id'] = $post['Post']['post_id'];
                            
                            if (!empty ($post['Post']['post_url'])) {
                                unlink (WWW_ROOT . 'image/' . pathinfo($post['Post']['post_url'], PATHINFO_BASENAME));
                            }
                            unset($value['user_guid']);
                            $this->Post->save($value);
                        } else {
                            $this->Post->save($value);
                        }
                    } else {
                        $this->Session->setFlash("file upload failed");
                    }
                } else if (empty($file['tmp_name'])) {

                    $this->loadModel('Post');
                    $post = $this->Post->findByUserGuidAndPostPath($guid, 'invite');
                    
                    $value['post_url'] = "";
                    if (!empty($post) && $post['Post']['post_path'] == 'invite') {
                        $value['post_id'] = $post['Post']['post_id'];
                        unset($value['user_guid']);
                        $this->Post->save($value);
                    } else {
                        $this->Post->save($value);
                    }
                } else {
                    $this->Session->setFlash("File upload failed");
                }
            }

            //
        }

        $this->set('userName', $user['user_name']);
        $this->set('userEmail', $user['user_email']);
        
        $this->loadModel('Post');
        $post = $this->Post->findByUserGuidAndPostPath($guid, 'invite');
        if (!empty ($post)) {
            $this->set('postTitle', $post['Post']['post_title']);
            $this->set('postContent', $post['Post']['post_content']);
            $this->set('postLogo', "/client/" . $post['Post']['post_url']);
        } else {
            $this->set('postTitle', "Invite page");
            $this->set('postContent', "You have been invited to join " . $user['user_name'] . "'s meeting.");
            $this->set('postLogo', "/client/img/logo.png");
        }
         
         
    }

    public function upgrade() {

        $this->layout = false;
    }

    public function sendActiveLink($guid, $activecode, $emailaddress) {
        $email = new CakeEmail();
        $email->config("gmail");
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

}
