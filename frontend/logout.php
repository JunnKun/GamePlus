<?php
    session_start();

    session_destroy();
    echo "<script> location.href = 'https://shinon.altervista.org/MyProject/frontend/login/index.html'</script>";
?>