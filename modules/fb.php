<?php
include_once('application.php');

class fb {
	public function fbconnect($access_token) {
		require_once 'Facebook/facebook.php';
        global $_settings;

        $U = new user(1);
        die;
        // Create our Application instance.
        $facebook = new Facebook(array(
            'appId'  => $_settings['facebook']['app_id'],
            'secret' => $_settings['facebook']['app_secret'],
            'cookie' => true)
        );

        if($access_token)  $facebook->setAccessToken($access_token);

        $fb_data = $facebook->api('/me/friends');
        $friends = $fb_data['data'];
        $user_facebook_id = $facebook->getUser();

        $inserted = 0;
        if($user_facebook_id) {
            $U = new user($user_facebook_id['id']);
        }
        return $inserted;
	}
}

?>