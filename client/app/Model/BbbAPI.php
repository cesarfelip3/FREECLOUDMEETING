<?php

App::uses('AppModel', 'Model');

class BbbAPI extends AppModel {

    public $useTable = false;
    public $bbbApiUri = "http://199.231.231.70/bigbluebutton/api/";
    public $bbbSalt = "53f606f013b8b5bcc560321e05e8c49a";

    public function createDemoMeeting($username) {

        $name = urlencode("Felipe's Meeting");
        $meetingId = urlencode("kDUw38823");
        $moderatorPW = urlencode("974ladfhwe");
        $attendeePW = urlencode("aghadfklj23");
        $logoutUrl = urlencode("http://cloudconferenceroom.com/client/demo/invite");

        $username = urlencode($username);

        $params = "meetingID=$meetingId&name=$name&moderatorPW=$moderatorPW&attendeePW=$attendeePW&logoutURL=$logoutUrl";
        $url = $this->bbbApiUri . "create?" . $params . "&checksum=" . sha1("create" . $params . $this->bbbSalt);

        if ($this->getMeetingInfo($meetingId, $moderatorPW)) {
            return $this->joinMeeting($username, $meetingId, $attendeePW);
        }

        $ret = $this->_request($url);

        if ($ret !== false) {
            $xml = simplexml_load_string($ret);
            if ($xml) {
                if ($xml->returncode == "SUCCESS") {
                    return $this->joinMeeting($username, $meetingId, $attendeePW);
                }
            }
        }

        return false;
    }

    public function getMeetingInfo($meetingId, $password) {
        $params = "meetingID=$meetingId&password=$password";
        $url = $this->bbbApiUri . "getMettingInfo?" . $params . "&checksum=" . sha1("getMettingInfo" . $params . $this->bbbSalt);

        $ret = $this->_request($url);

        if ($ret !== false) {
            $xml = simplexml_load_string($ret);
            if ($xml) {
                if ($xml->returncode == "SUCCESS") {
                    return true;
                }
            }
        }

        return false;
    }
    
    public function isMeetingRunning ($meetingId)
    {
        $param = "meetingID=$meetingId";
        $url = $this->bbbApiUri . "isMeetingRunning?" . $param . "&checksum=" . sha1("isMeetingRunning" . $param . $this->bbbSalt);

        $ret = $this->_request($url);

        if ($ret !== false) {
            $xml = simplexml_load_string($ret);
            if ($xml) {
                if ($xml->returncode == "SUCCESS") {
                    if ($xml->running == "true") {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    //
    public function createMeeting($param) {

        if (empty($param)) {
            return false;
        }

        if (is_array($param)) {
            if (($param = $this->_params($param)) == false) {
                return false;
            }
        }

        $url = $this->bbbApiUri . "create?" . $param . "&checksum=" . sha1("create" . $param . $this->bbbSalt);

        $ret = $this->_request($url);

        if ($ret !== false) {
            $xml = simplexml_load_string($ret);
            if ($xml) {
                if ($xml->returncode == "SUCCESS") {
                    return true;
                }
            }
        }

        return false;
    }

    public function joinMeeting($param) {
        if (empty($param)) {
            return false;
        }

        if (is_array($param)) {
            if (($param = $this->params($param)) == false) {
                return false;
            }
        }
        
        $url = $this->bbbApiUri . "join?" . $param . "&checksum=" . sha1("join" . $param . $this->bbbSalt);

        return $url;
    }

    public function endMeeting($meetingId, $password) {
        $param = "end?meetingID=$meetingId&password=$password";
        $url = $this->bbbApiUri . $param . "&checksum=" . sha1($param . $this->bbbSalt);

        $ret = $this->_request($url);

        if ($ret !== false) {
            $xml = SimpleXMLElement($ret);
            if ($xml) {
                if ($xml->returncode == "SUCCESS") {
                    return true;
                }
            }
        }

        return false;
    }

    public function getAllMeetings() {
        $url = $this->bbbApiUri . "getMeetings";
        $url = $url . "?checksum=" . sha1("getMeetings" . $this->bbbSalt);

        $ret = $this->_request($url);

        if ($ret !== false) {
            return $ret;
            return new SimpleXMLElement($data);
        }
    }

    public function params($param) {
        if (empty($param)) {
            return false;
        }

        if (!is_array($param)) {
            return false;
        }

        $p = "";
        foreach ($param as $key => $v) {
            $p .= $key . "=" . urlencode($v) . "&";
        }

        $p = trim($p, "&");
        return $p;
    }

    protected function _request($url) {
        $ch = curl_init();

        if (!$ch) {
            return false;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, true);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        $return = curl_exec($ch);

        if (!$return) {
            return false;
        }

        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (substr($httpStatus, 0, 1) != "2") {
            return false;
        }

        curl_close($ch);
        return $return;
    }

}
