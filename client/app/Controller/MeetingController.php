<?php

App::uses('AppController', 'Controller');
App::uses('Security', 'Utility');
App::uses('CakeEmail', 'Network/Email');
App::uses('Sanitize', 'Utility');

// load model 
//App::uses('BbbAPI', 'Model');

class MeetingController extends AppController {

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
    }

    public function invite() {

        $this->layout = false;

        $this->loadModel("Meeting");
        $meetingGuid = isset($_GET['i']) ? $_GET['i'] : '';

        $message = "";

        if (empty($meetingGuid)) {
            $this->Session->setFlash("The link malformatted");
            return;
        }

        $meeting = $this->Meeting->findByMeetingGuid($meetingGuid);
        $meeting = $meeting['Meeting'];

        $this->set("step", 1);
        $this->set("meetingId", $meetingGuid);

        if (!empty($meeting)) {
            $this->loadModel("User");
            $user = $this->User->findByUserId($meeting['user_id']);
            if (empty($user)) {
                $this->Session->setFlash("This meeting is not valid as there is no owner of it");
                $this->set("username", "       ");
                return;
            }

            $user = $user['User'];
            $this->set("username", $user['user_name']);
            
            $this->loadModel('Post');
            $post = $this->Post->findByUserGuidAndPostPath($user['user_guid'], 'invite');
            
            if (!empty ($post)) {
                $this->set("title", $post['Post']['post_title']);
                $this->set("description", $post['Post']['post_content']);
                $this->set("logo", $post['Post']['post_url']);
            } else {
                $this->set("title", "Invite page");
                $this->set("description", "You have been invited to join " . $user['user_name'] . "'s meeting." );
                $this->set("logo", "img/logo.png");
            }

            $guestname = isset($_GET['username']) ? $_GET['username'] : '';
            if (!empty($guestname)) {

                if (isset($_GET['ajax'])) {

                    $this->loadModel("BbbAPI");
                    $param = array(
                        "meetingID" => $meetingGuid,
                        "fullName" => $guestname,
                        "password" => $meeting['meeting_attendee']
                    );

                    $info = $this->BbbAPI->isMeetingRunning($meetingGuid);

                    $url = $this->BbbAPI->joinMeeting($param);
                    $this->redirect ($url);
                    exit;
                }
            }

            if ($this->request->isPost()) {

                if (empty($this->data['Meeting']['username'])) {
                    $this->Session->setFlash("Name is required");
                    return;
                }

                $this->loadModel("BbbAPI");

                $param = array(
                    "meetingID" => $meetingGuid,
                    "fullName" => $this->data['Meeting']['username'],
                    "password" => $meeting['meeting_attendee']
                );

                $info = $this->BbbAPI->isMeetingRunning($meetingGuid);

                $url = "";
                if ($info == true) {
                    $url = $this->BbbAPI->joinMeeting($param);
                } else {
                    $this->set("guestname", $this->data['Meeting']['username']);
                    $this->set("step", 2);
                    return;
                }

                if (!empty($url)) {
                    $this->redirect($url);
                } else {
                    $this->Session->setFlash("Oops : system on maitaince");
                }
            }
        } else {
            $this->Session->setFlash("The meeting doesn't exist anymore");
        }
    }

    public function detect() {
        $this->layout = false;

        $this->loadModel("Meeting");
        $meetingGuid = isset($_GET['i']) ? $_GET['i'] : '';

        $message = "";

        if (empty($meetingGuid)) {
            echo "no";
            exit;
        }

        $meeting = $this->Meeting->findByMeetingGuid($meetingGuid);
        $meeting = $meeting['Meeting'];

        if (!empty($meeting)) {
            $this->loadModel("BbbAPI");
            $info = $this->BbbAPI->isMeetingRunning($meeting['meeting_guid']);

            if ($info == true) {
                echo "yes";
            } else {
                echo "no";
            }
            exit;
        }

        echo "no";
        exit;
    }

}

