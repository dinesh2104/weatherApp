<?php
include "./lib/load.php";

$res = "";
if (UserSession::ensureLogin() == true) {
    header("Location: /");
    die();
}

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = removechar($_POST['email']);
    $pass = $_POST['password'];

    $res = User::login($email, $pass);
    if ($res == "success") {
        header("Location: /");
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'>
    <link rel="stylesheet" href="/css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <div class="login-form">
        <form method="POST" action="login.php">
            <h1>Login</h1>
            <div class="content">
                <p class="info-txt <?php if (!empty($res)) {
                                        echo "error";
                                    } ?>"><?php echo $res ?></p>
                <div class="input-field">
                    <input type="email" name='email' placeholder="Email" autocomplete="nope">
                </div>
                <div class="input-field">
                    <input type="password" name='password' placeholder="Password" autocomplete="new-password">
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