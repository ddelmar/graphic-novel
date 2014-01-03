<?php 
/* include('includes/head.php'); */

require 'facebook-sdk/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '243555385686486',
  'secret' => '9f80480c4bd12c79557da0e329d38d0c',
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.
if ($user) {
 // $logoutUrl = $facebook->getLogoutUrl();
$logoutUrl = $facebook->getLogoutUrl(array(
   'next'=>'http://delmarsenties.com/graphic-novel/facebook-sdk/logout.php'
));

} else {
  $statusUrl = $facebook->getLoginStatusUrl();
  $loginUrl = $facebook->getLoginUrl();
}

// This call will always work since we are fetching public data.
$naitik = $facebook->api('/naitik');

// Graphic Novel vars
if ($user_profile['hometown']){
	$hometown = $user_profile['hometown']['name'];
	$parts = explode(",",$hometown);
	$hometown = $parts['0'];
} else {
	$hometown = "back home";
}
if ($user_profile['location']){
	$currentcity = $user_profile['location']['name'];
	$parts = explode(",",$currentcity);
	$currentcity = $parts['0'];
} else {
	$currentcity = "your neck of the woods";
}
if ($user_profile['work']){
	$work = "you're at " . $user_profile['work']['0']['employer']['name'];
} else {
	$work = "where you work";
}




$friends = $facebook->api("/me/friends");

// FRIEND 1
$friend1 = $friends['data']['0'];
$friendLoc = $friend1;

if ($friendLoc['location']){
	$friendLocCity = $friendLoc['location']['name'];
	$parts = explode(",",$friendLocCity);
	$friendLocCity = $parts['0'];
} else {
	$friendLocCity = "undeclared";
}

function friendLoc($num){
	$number = $num;
	$str = $friend1['location']['name'];
	//$str = ${"friend" . "{$num}" . "{$name}"};
	
	
	return $str ;
}

$firstname = $user_profile['first_name'];
$lastname = $user_profile['last_name'];
?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title>The 5.5-minute hallway</title>
    <style>
      body {
        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
      }
      h1 a {
        text-decoration: none;
        color: #3b5998;
      }
      h1 a:hover {
        text-decoration: underline;
      }
    </style>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
  </head>
  <body>
    <h1>The 5.5-minute hallway</h1>

    <?php if ($user): ?>
      <a href="<?php echo $logoutUrl; ?>">Logout</a>
    <?php else: ?>
      <div>
        Check the login status using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $statusUrl; ?>">Check the login status</a>
      </div>
      <div>
        Login using OAuth 2.0 handled by the PHP SDK:
        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
      </div>
    <?php endif ?>

    <h3>PHP Session</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <?php if ($user): ?>
      <h3>Script</h3>
      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture?type=large">
<p>My name is <?php echo $user_profile['name'] ?> and I'm from <?php echo $hometown ?> but I currently live in <?php echo $currentcity ?>.</p>

<?php /* ++++++++++++++++++++++++++++++++++++++ */?>
<p>Right now, 2.2 miles away from you...</p>
<p>Yo, <?php echo $user_profile['last_name'] ?>. It's Johnny Truant. Where are you right now? It's <span id="clock">late</span>, I've been waiting for you forever. I'm only in <?php echo $currentcity ?> for one night, and we need to talk about... about what you saw. Look, I owe you big for the video you dropped on me. About that hallway. The five-and-a-half minute hallway, whatever you call it. Look, some people found out about it. Some people you know from  <?php echo $hometown ?>. They remember you. And they want to talk. They know <?php echo $work ?> these days. Hell, they might just show up. </p>

<h1>Character 1: <?php echo $friend1['name'] ?></h1>
<img src="https://graph.facebook.com/<?php echo $friend1['id'] ?>/picture?type=large">


<!--
<p>My friends: <?php print_r($friends); ?></p>
-->
      <h3>Your User Object (/me)</h3>
      <pre><?php print_r($user_profile); ?></pre>
    <?php else: ?>
      <strong><em>You are not Connected.</em></strong>
    <?php endif ?>

    <h3>Public profile of Naitik</h3>
    <img src="https://graph.facebook.com/naitik/picture">
    <?php echo $naitik['name']; ?>

