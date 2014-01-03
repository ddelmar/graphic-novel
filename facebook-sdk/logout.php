<?php
    require 'facebook.php';
    $facebook = new Facebook(array(
    'appId'  => '243555385686486',
	'secret' => '9f80480c4bd12c79557da0e329d38d0c',
    'cookie' => true,
   ));
 
   //ovewrites the cookie
   // $facebook->setSession(null);
$facebook->destroySession();
 
   //redirects to index
   header('Location: http://delmarsenties.com/graphic-novel');
?>