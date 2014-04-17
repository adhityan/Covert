<?php
include_once('application.php');

class user {
	private $userid;
	private $data;
	private $DB;

	public function __construct($uid) {
		$this->userid = $uid;
		$this->DB = DB::getDB();

		$getStmt = $this->DB->prepare("SELECT count(*) from `users` WHERE `user_id` = ?");
        $getStmt->bind_param('i', $uid);
        $getStmt->bind_result($count);
        $getStmt->execute();
        $getStmt->fetch();
        $getStmt->close();

        if(!$count) {
            $insStmt = $this->DB->prepare("INSERT INTO `users` (`user_id`, `name`, `facebook_friends`, `facebook_access_token`, `status`, `data`, `last_updated`, `created_on`) VALUES (?, '', '', '', 1, '', NOW(), NOW())");
            $insStmt->bind_param('i', $uid);
            $insStmt->execute();
            $insStmt->close();
        }

        $getQuer = "SELECT * from `users` WHERE `user_id` = ?";
        $getStmt = $this->DB->prepare($getQuer);
        $getStmt->bind_param('i', $uid);
        $getStmt->execute();
        $getStmt->store_result();
        if($getStmt->num_rows >= 1) {
            $user_data = DB::bind_result_array($getStmt);
            $getStmt->fetch();
            $getStmt->close();
            // sanitize name for security and convert to letter case
            
            $this->data = $user_data;
        }
        $getStmt->close();
	}

	public function __get($name) {
        if(isSet($this->data[$name]))
            return $this->data[$name];
        else return null;
    }
    public function __isSet($name) {
        if(isSet($this->data[$name]))
            return true;
        else return false;
    }

	public function updateFacebookUser($access_token, $friends) {
		$insStmt = $this->DB->prepare("UPDATE `users`
                SET facebook_access_token = ?,
                	facebook_friends = ?,
                	last_updated = NOW()
                WHERE user_id = ?");
        
        $sfriend = '';
        foreach($friends as $friend) {
        	$sfriend .= $friend['id'].',';
        }
        $sfriend = trim($sfriend, ',');

        $insStmt->bind_param('ssi', $access_token, $sfriend, $this->userid);
        $insStmt->execute();
	}
}

?>