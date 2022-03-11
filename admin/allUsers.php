<?php
    include '../response.php';

    $host = "localhost";
    $username = "shinon";
    $database = "my_shinon";

    class User{
        public $id;
        public $email;
        public $username;
    }

	if($_SERVER['REQUEST_METHOD'] === "GET"){
        $array = array();
        $conn = mysqli_connect($host, $username, "", $database);
        if (mysqli_connect_errno()) {
            echo json_encode(new Response(true, "Internal Server Error" . mysqli_connect_error(), 500, "json", ""));
            exit();
        }

        $qry = "SELECT * FROM User;";
        $mytbl = mysqli_query($conn, $qry);
        if(mysqli_num_rows($mytbl) > 0){
            while($row = mysqli_fetch_array($mytbl)){
                $myUser = new User();
                $myUser->id = $row["id"];
                $myUser->email = $row["email"];
                $myUser->username = $row["username"];
                $array[] = $myUser;
            }
            echo json_encode($array);
        }else{
            echo json_encode(new Response(true, "Wrong data", 400, "json", ""));
        }
    }else{
        echo json_encode(new Response(true, "Method Not Allowed", 405, "json", ""));
        exit;
    }
?>