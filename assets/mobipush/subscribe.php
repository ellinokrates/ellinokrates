<?php
require_once 'pushtoken.php';
    if(!isset($_GET['device_token'])){
      echo "device token needed!!!";
      exit;
    }

      $server_key = 'AAAASTKDNE8:APA91bE-i0krnnVt_rW-jfLU-mBi8oxDg7xdV4CQ3VMYIw0M9GhbbBdhnHs53dOev0no_6bYFM8EWtR0MWCnAJbDgHWANFU0XhiJglDDJAaHcPk8JaDLrhIKY5rOUyVoh6ZvVwzz1uT_';

    
      $url = 'https://iid.googleapis.com/iid/v1:batchAdd';
      $fields['registration_tokens'] = array($_GET['device_token']);
      $fields['to'] = '/topics/'.$push_token;
      $headers = array(
      'Content-Type:application/json',
          'Authorization:key='.$server_key
      );
      
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($ch);
      curl_close($ch);
      var_dump($result);
	  exit;
?>