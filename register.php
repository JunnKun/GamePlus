<?php
    include './response.php';
    $host = "localhost";
    $username = "shinon";
    $database = "my_shinon";

    /*$conn = mysqli_connect($host, $username, "", $database);
            if (mysqli_connect_errno()) {
                echo json_encode(new Response(true, "Internal Server Error" . mysqli_connect_error(), 500, "json", ""));
                exit();
            }

            $password = hash("sha256", "helloworld");
            $qry = "INSERT INTO User (email, password, username) VALUES ('jackyhu03@gmail.com', '$password', 'jackyhu03');";
            if(mysqli_query($conn, $qry)){
                echo json_encode(new Response(false, "Registration was successful", 201, "json", ""));
            }else{
                echo json_encode(new Response(true, "Registration was successful", 201, "json", ""));
            }*/

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(isset($_POST["email"],$_POST["password"],$_POST["username"])){
            $email = $_POST["email"];
            $password = hash("sha256", $_POST["password"]);
            $username = $_POST["username"];
            
            $conn = mysqli_connect($host, $username, "", $database);
            if (mysqli_connect_errno()) {
                echo json_encode(new Response(true, "Internal Server Error" . mysqli_connect_error(), 500, "json", ""));
                exit();
            }

            $qry = "INSERT INTO User (email, password, username) VALUES ('$email', '$password', '$username');";
            if(mysqli_query($conn, $qry)){
                echo json_encode(new Response(false, "Registration was successful", 201, "json", ""));
            }else{
                echo json_encode(new Response(true, "User Already Exist", 400, "json", ""));
            }
        }else{
            echo json_encode(new Response(true, "Fields not set", 400, "json", ""));
        }
    }else{
        echo json_encode(new Response(true, "Method Not Allowed", 405, "json", ""));
        exit;
    }
?>