<?php

include "./lib/load.php";

// $response_code = 0;
// $errormsg = "";

$res = "";

if (UserSession::ensureLogin() == true) {
    header("Location: /");
    die();
}

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['con_password'])) {
    $email = removechar($_POST['email']);
    $username = removechar($_POST['username']);
    $password = $_POST['password'];
    $confirm_pass = $_POST['con_password'];

    if ($password == $confirm_pass) {
        $res = User::Register($username, $email, $password, $confirm_pass);


        // $response_code = explode(":", $res[0]);
        // explode(":", $response_code);
        // $errormsg = explode("}", $res[4]);
        // explode(":", $errormsg);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'>
    <link rel="stylesheet" href="/css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;

            if (password.length < 6) {
                document.getElementById("passwordError").innerHTML = "Password must be at least 6 characters long.";
                return false;
            } else {
                document.getElementById("passwordError").innerHTML = "";
                return true;
            }
        }
    </script>
</head>

<body>
    <div class="login-form">
        <form method="POST" action="/signup.php">
            <h1>Register</h1>
            <div class="content">
                <p class="info-txt <?php if (!empty($res)) {
                                        if ($res == "New User Registered Successfully!!!") {
                                            echo "success";
                                        } else {
                                            echo "error";
                                        }
                                    } ?>"><?php echo $res ?></p>
                <div class="input-field">
                    <input type="text" name="username" placeholder="UserName">
                </div>
                <div class="input-field">
                    <input type="email" name="email" placeholder="Email" autocomplete="nope">
                </div>
                <div class="input-field">
                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="new-password" onkeyup="validatePassword()">
                    <span id="passwordError" style="color: red;"></span>
                </div>
                <div class="input-field">
                    <input type="password" id="confirm" name="con_password" placeholder="Retype-Password" autocomplete="new-password">
                </div>

                <button type="submit">Submit</button>
            </div>
            <div class="action">
                <button><a href="signup.php">Register</a></button>
                <button><a href="login.php">Sign in</a></button>
            </div>
        </form>
    </div>
    <!-- partial -->
    <script src="/js/login.js"></script>

</body>

</html>