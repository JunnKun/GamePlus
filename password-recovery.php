<?php

// header('Access-Control-Allow-Origin');

include './response.php';

require_once 'JWT/JWT.php';
require_once 'JWT/Key.php';
require_once 'JWT/SignatureInvalidException.php';
require_once 'JWT/ExpiredException.php';
require_once 'JWT/BeforeValidException.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// header('Content-Type: application/json; charset=utf-8');

/* database data */
$host = "localhost";
$username = "shinon";
$database = "my_shinon";


if($_SERVER['REQUEST_METHOD'] === "GET"){
    if(isset($_REQUEST["email"], $_REQUEST["url"])){
        $email = $_REQUEST["email"];
        $url = $_REQUEST["url"];
        
        $conn = mysqli_connect($host, $username, "", $database);
        if (mysqli_connect_errno()) {
            echo json_encode(new Response(true, "Internal Server Error" . mysqli_connect_error(), 500, "json", ""));
            exit();
        }

        $qry = "SELECT * FROM User WHERE email='$email';";
        // echo $qry;
        $mytbl = mysqli_query($conn, $qry);
        // var_dump($mytbl);
        if(mysqli_num_rows($mytbl) > 0){
            while($row = mysqli_fetch_array($mytbl)){
                $_SESSION["email"] = $row["email"];
            }
            if(send_email($email, $url)){
                echo json_encode(new Response(false, "Message sent correctly", 201, "json", ""));
            }else{
                echo json_encode(new Response(true, "Error in sending the email", 400, "json", ""));
            }
        }else{
            echo json_encode(new Response(true, "Wrong data", 400, "json", ""));
        }
    }else{
        echo json_encode(new Response(true, "Fields not set", 400, "json", ""));
    }
}else if($_SERVER['REQUEST_METHOD'] === "POST"){
    if(isset($_REQUEST["new-password"], $_REQUEST["confirm-password"], $_REQUEST["email"])){
        if($_REQUEST["new-password"] == $_REQUEST["confirm-password"]){
            $password = hash("sha256", $_REQUEST["new-password"]);
            $email = $_REQUEST["email"];
            $conn = mysqli_connect($host, $username, "", $database);
            if (mysqli_connect_errno()) {
                echo json_encode(new Response(true, "Internal Server Error" . mysqli_connect_error(), 500, "json", ""));
                exit();
            }
    
            /* select query on the email field */
            $qry = "SELECT * FROM User WHERE email='$email';";
            $mytbl = mysqli_query($conn, $qry);

            while($row = mysqli_fetch_array($mytbl)) {
                if($row['password'] != $password){
                    /* call the update function for change the password */
                    update($conn, $email, $password);
                }else{
                    echo json_encode(new Response(true, "You cannot use the same password you have already used", 400, "json", ""));
                }
            }
        }else{
            echo json_encode(new Response(true, "Passwords do not match", 400, "json", ""));
        }
    }else{
        echo json_encode(new Response(true, "Fields not set", 400, "json", ""));
    }
}

function send_email($email, $url){
    $subject = "GamePlus";
        
    // $message = "<b>This is HTML message.</b>";
    $message .= "<a href='".$url."?user=".get_jwt($email)."'><button type='button'>RESET PASSWORD</button></a>";

    $header = "From:help@accts.gameplus.com \r\n";
    $header .= "Cc:" . $email . " \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
         
    $emaill = mail($email,$subject,$message,$header);
         
    if( $emaill == true ) {
        // echo "Message sent successfully...";
        return true;
    }else {
        return false;
    }
}

function get_jwt($email){
    /* JWT */
    $key = '86R9t@#q7+Qyg?SYpXw4gBxnK?sd%kRg';
    //ORARI --> EXP IN 60s
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 1);

    $payload = array(
        'iss'      => "https://".$_SERVER['HTTP_HOST'],
        'aud'      => "/",
        'iat'      => $issued_at,
        'exp'      => $expiration_time,
        'nbf'      => 1357000000,
        'email'    => $email
    );

    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
}

function update($connection, $email, $password){
    $sql = "UPDATE User SET password='".$password."' WHERE email='".$email."';";
    if ($connection->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>