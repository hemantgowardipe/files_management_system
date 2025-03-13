<?php
require 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->setRedirectUri('http://localhost/google-drive/callback.php'); // Update if hosted
$client->addScope(Google_Service_Drive::DRIVE_FILE);
$client->setAccessType('offline');

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    
    // Redirect to home or upload page
    header('Location: upload.php');
    exit();
} else {
    echo "Authentication failed!";
}
?>
