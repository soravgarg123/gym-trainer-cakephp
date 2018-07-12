<?php
//namespace tok\OpenTok\src;

require_once "opentok.phar";

use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Session;
use OpenTok\Role;

// include("OpenTok/src/OpenTok/OpenTok.php");
// require_once "OpenTok/src/OpenTok/OpenTok.php";
// require_once "OpenTok/src/OpenTok/MediaMode.php";
// require_once "OpenTok/src/OpenTok/ArchiveMode.php";

$API_KEY = "45342972";
$API_SECRET = "802ad098cc7d3386c08a8461f5435d2f88121fc5";

$apiObj = new OpenTok($API_KEY, $API_SECRET);
$session = $apiObj->createSession(array('mediaMode' => MediaMode::ROUTED));
echo $sessionId = $session->getSessionId();

echo "<br/>";
// Generate a Token from just a sessionId (fetched from a database)
 echo $token = $apiObj->generateToken($sessionId);
// Generate a Token by calling the method on the Session (returned from createSession)
// $token = $session->generateToken();

// Set some options in a token
// $token = $session->generateToken(array(
//     'role'       => Role::MODERATOR,
//     'expireTime' => time()+(7 * 24 * 60 * 60), // in one week
//     'data'       => 'name=Johnny'
// ));

?>