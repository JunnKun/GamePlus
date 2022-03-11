<?php
    include './response.php';
    
    header('Content-Type: application/json; charset=utf-8');

    session_start();
    $host = "localhost";
    $username = "shinon";
    $database = "my_shinon";

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $bodyRequest = json_decode(file_get_contents('php://input'), true);
        if(isset($bodyRequest["email"], $bodyRequest["password"])){
            $email = $bodyRequest["email"];
            $password = hash("sha256", $bodyRequest["password"]);
            
            $conn = mysqli_connect($host, $username, "", $database);
            if (mysqli_connect_errno()) {
                echo json_encode(new Response(true, "Internal Server Error" . mysqli_connect_error(), 500, "json", ""));
                exit();
            }

            $qry = "SELECT * FROM User WHERE email='$email' AND password='$password';";
            // echo $qry;
            $mytbl = mysqli_query($conn, $qry);
            // var_dump($mytbl);
            if(mysqli_num_rows($mytbl) > 0){
                while($row = mysqli_fetch_array($mytbl)){
                    $_SESSION["email"] = $row["email"];
                }
                echo json_encode(new Response(false, "Logged Correctly", 201, "json", ""));
            }else{
                echo json_encode(new Response(true, "Wrong data", 400, "json", ""));
            }
        }else{
            echo json_encode(new Response(true, "Fields not set", 400, "json", ""));
        }
    }else{
        echo json_encode(new Response(true, "Method Not Allowed", 405, "json", ""));
        exit;
    }
?>