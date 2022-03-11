<?php
    /*include '../../response.php';

    session_start();
    if($_SERVER['REQUEST_METHOD'] === "GET"){
        if(isset($_SESSION["email"])) new Response(true, "Already Logged", 200, "json", "");
        else new Response(false, "None Authorized", 401, "json", "");
    }*/

    include '../../response.php';

    session_start();
    if($_SERVER['REQUEST_METHOD'] === "GET"){
        if(isset($_SESSION["email"])) echo json_encode(new Response(false, "Already Logged", 200, "json", ""));
        else echo json_encode(new Response(true, "None Authorized", 401, "json", ""));
    }
?>