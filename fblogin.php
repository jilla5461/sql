<?php
require_once 'facebook/autoload.php'; // Include the Facebook PHP SDK

$fb = new Facebook\Facebook([
  'app_id' => '277774842033660',
  'app_secret' => '3e95a6c8ef286e052bebc5cb018fa839',
  'default_graph_version' => 'v12.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
    $response = $fb->get('/me?fields=id,name,email', $accessToken);
    $userData = $response->getGraphNode()->asArray();

    // Process $userData to register the user in your system
    // You may store user's Facebook ID, name, email, etc. in your database

    // Redirect the user to the registration success page
    header("Location: registration_success.php");
    exit();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}
?>