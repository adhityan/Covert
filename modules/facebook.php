<?php

class facebook {
	public function fbconnect($access_token) {
		require_once 'Facebook/facebook.php';
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
            
        }
        return $inserted;
	}
}

?>