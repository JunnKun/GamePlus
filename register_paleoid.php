<?php
// require 'HTTP/Request.php'; 
include './response.php';

session_start();
$client_id = "0f30891441fd95819a0a0bf7b3c7b7ac";
$client_secret = "7694deb758369fbe1ede3e43f60e2239f6c8c057d4723e7b39ddb30dfaeed1f1fe668a34c77ab1f985cea6f94f3cf47bfd0a86e8541437d04e3f3c40c9db8383";

if(isset($_GET["code"],$_GET["state"])){
    if($_GET["state"] == $_SESSION["state"]){
        $access_token = POST("https://id.paleo.bg.it/oauth/token", $_GET["code"], "https://shinon.altervista.org/MyProject/register_paleoid.php");
        if($access_token != ""){
            $data = get_userinfo("https://id.paleo.bg.it/api/v2/user", $access_token);
            $_SESSION["email"] = $data->email;
            header("Location: https://shinon.altervista.org/MyProject/frontend/login/index.html");
        }
    }else{
        new Response(false, "Different state verify code", 500, "json", "");
    }
}else{
    $state = generateRandomString(10);
    $_SESSION["state"] = $state; // save the auto gen code in session for the verify
    $redirect_url = "https://shinon.altervista.org/MyProject/register_paleoid.php";
    $myurl = "https://id.paleo.bg.it/oauth/authorize?client_id=0f30891441fd95819a0a0bf7b3c7b7ac&response_type=code&state=".$state."&redirect_uri=".$redirect_url;
    header("Location: ".$myurl);
    exit();
}

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function POST($url, $code, $redirect_url){
    $post = new stdClass;
    $post->grant_type = "authorization_code";
    $post->code = $code;
    $post->redirect_uri = $redirect_url;
    $post->client_id = $GLOBALS['client_id'];
    $post->client_secret = $GLOBALS['client_secret'];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://id.paleo.bg.it/oauth/token",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($post),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // echo "cURL Error #:" . $err;
        return "";
    } else {
        $resp =json_decode($response);
        // var_dump($resp);
        // echo $resp->access_token;
        return $resp->access_token;
    }
}

function get_userinfo($url, $access_token){
    $curl = curl_init();

    // echo $access_token;
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://id.paleo.bg.it/api/v2/user",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $access_token,
            "Content-Type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        // echo "cURL Error #:" . $err;
        return "";
    } else {
        $resp =json_decode($response);
        // var_dump($response);
        return $resp;
    }
}
?>