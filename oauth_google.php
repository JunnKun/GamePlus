<?php
require_once './googleOauth/vendor/autoload.php';

session_start();

$clientID = '866214459062-3jg40fqjqbp4sf7kpa53b74n41ehcsul.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUrl = 'https://shinon.altervista.org/MyProject/oauth_google.php';

$client = new Google_client();
$client -> setClientId($clientID);
$client -> setClientSecret($clientSecret);
$client -> setRedirectUri($redirectUrl);
$client -> addScope('profile');
$client -> addScope('email');


if(isset($_GET['code'])){
    $token = $client -> fetchAccessTokenWithAuthCode($_GET['code']);
    $client -> setAccessToken($token);

    $gauth = new Google_Service_Oauth2($client);
    $google_info = $gauth -> userinfo -> get();
    $email = $google_info -> email;
    $name = $google_info -> name;

    echo "Welcome " . $name . " You are registered using email: " . $email;
    $_SESSION["email"] = $email;
    header("Location: https://shinon.altervista.org/MyProject/frontend/home.php");
}
else{
    header("location: " . $client->createAuthUrl());
}
?>