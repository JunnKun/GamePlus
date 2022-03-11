<?php
    include '../response.php';

    require_once '../JWT/JWT.php';
    require_once '../JWT/Key.php';
    require_once '../JWT/SignatureInvalidException.php';
    require_once '../JWT/ExpiredException.php';
    require_once '../JWT/BeforeValidException.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    session_start();
    /* JWT */
	$key = '86R9t@#q7+Qyg?SYpXw4gBxnK?sd%kRg';

    if($_SERVER['REQUEST_METHOD'] === "GET"){
        if(isset($_REQUEST['user'])){
            $jwt = $_REQUEST['user'];
            try {
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
                // $_SESSION["email"] = $decoded["email"];
                // echo $decoded->email;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>GamePlus</title>
    <!-- MDB icon -->
    <link rel="icon" href="img/GP_logo.png" type="image/x-icon" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
    <!-- MDB -->
    <link rel="stylesheet" href="./mbd/css/mdb.min.css" />
    <!-- MYSTYLE -->
    <link rel="stylesheet" href="change-password-style.css">
</head>
<body>
    <!-- Start your project here-->
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="img/GP_logo.png" class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <form method="POST" action="https://shinon.altervista.org/MyProject/password-recovery.php">
                        <div class="col-md-12 mb-4">
                            <h3 class="text-center heading">Reset Your Password</h3>
                        </div>
                        <!-- New Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="new-password" name="new-password" class="form-control form-control-lg" required/>
                            <label class="form-label" for="form1Example13">New Password</label>
                        </div>
                        <!-- Confirm Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="confirm-password" name="confirm-password" class="form-control form-control-lg" required/>
                            <label class="form-label" for="form1Example13">Confirm Password</label>
                        </div>
                        <!-- Submit button -->
                        <button type="submit" id="reset-password" name="email" class="btn btn-primary btn-lg btn-block" value="<?php echo $decoded->email; ?>">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="mbd/js/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="change-password-script.js"></script>
  </body>
</html>
<?php
            }catch (Exception $e){

                http_response_code(401);
            
                echo json_encode(new Response(true, "Access denied." . $e->getMessage() , 400, "json", ""));
            }
        }else{
            echo json_encode(new Response(true, "Fields not set", 400, "json", ""));
        }
    }
?>
