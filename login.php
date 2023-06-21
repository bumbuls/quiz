<?php
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    header("Location: auth/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pieslēgties</title>
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="css/nav.css">

    <!--<title>Login & Registration Form</title>-->
</head>
<body class="login-body">

<div class="container">
    <div class="forms">
        <div class="form login">
            <span class="title">Pieslēgties</span>
            <?php if (isset($_SESSION['error'])) { ?>
                <p class="error" id="error"><?php echo $_SESSION['error']; ?></p>
            <?php } ?>
            <form action="process/loginProcess.php" method="post">
                <div class="input-field">
                    <input type="text" name="username"  placeholder="Ievadi lietotajvārdu" autocomplete="off">
                    <i class="uil uil-user icon"></i>
                </div>
                <div class="input-field">
                    <input type="password" name="password" class="password" placeholder="Ievadi paroli">
                    <i class="uil uil-lock icon"></i>
                </div>
                <div class="input-field button">
                    <input type="submit" name="login" value="Pieslēgties">
                </div>
            </form>

            <div class="login-signup">
                    <span class="text">Nav profila?
                        <a href="register.php" class="text signup-link">Reģistrējies</a>
                    </span>
            </div>
        </div>
    </div>
</div>
</body>
</html>
