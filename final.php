<?php
// Session Start
session_start();
// nodrošina, ka lietotājam ir derīga sesija, un aprēķina laiku, kas nepieciešams viktorīnas aizpildīšanai.
if (!isset($_SESSION['player_name'])) {
    header("Location: index.php");
    exit();
}
// aprēķināt viktorīnas izpildes laiku minūtēs un sekundēs no kopējā izmantotā laika
if($_SESSION['usedTime'] < 60){
    $minutes = 0;
    $seconds = $_SESSION['usedTime'];
}
else{
    $minutes = (int)($_SESSION['usedTime'] / 60);
    $seconds = (int)($_SESSION['usedTime'] % 60);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viktrorīna</title>
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/form.css">
    <!--<title>Login & Registration Form</title>-->
</head>
<body class="login-body">

<div class="container" style="max-width:800px">
    <div class="forms">
        <div class="form login">
            <span style="font-size: 1.3rem; font-weight: 600">Viktorīnas nosaukums: <?php echo $_SESSION['quizName']; ?>.</span>
            <h2 style="text-align:center">Rezultāts</h2>
            <hr>
            <h2 style="text-align:center"><?php echo $_SESSION['score']; ?> no <?php echo $_SESSION['totalQuestion']; ?></h2>
            <h2 style="text-align:center">Pavadītais laiks</h2>
            <h2 style="text-align:center"><?php echo $minutes; ?>min <?php echo $seconds; ?>sec</h2>
            <div class="input-field button" style="justify-content: center;display: flex;height:40px">
                <a href="result_details.php" style="text-align:center" class="btn-info">Pārbaudīt atbildes</a>
            </div>        
        </div>
        
    </div>
</div>
</body>
</html>