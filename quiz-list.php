<?php
session_start();
include "config/database.php";
$sql = "SELECT * FROM tbl_quiz where q_tnq > 0";
$result = mysqli_query($connection, $sql);
    $_SESSION['player_name'] = $_POST['player_name'];
?>
<?php
if (!isset($_SESSION['player_name'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/form.css">

    <!--<title>Login & Registration Form</title>-->
</head>
<body class="login-body">

<div class="container" style="max-width: 1000px">
    <div class="forms">
        <div class="form login">
        <span style="font-size: 1.5rem; font-weight: 600">Sveiks, <?php echo $_SESSION['player_name']; ?>!</span><br>
            <span class="title">Ko vēlies sākt pirmo?</span>
            <table class="table table-striped" style="margin-bottom: 20px;">
                <thead>
                <tr>
                    <th>Nr.</th>
                    <th>Nosakumus</th>
                    <th>Laiks</th>
                    <th>Kopējie jautājumi</th>
                    <th>Darbības</th>
                </tr>
                </thead>
    
                <tbody>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_array($result)){?>
                    <tr>
                        <td style="text-align: center"><?php echo $no++; ?></td>
                        <td style="text-align: center"><?php echo $row['q_name']; ?></td>
                        <td style="text-align: center"><?php echo $row['q_time']; ?>min</td>
                        <td style="text-align: center"><?php echo $row['q_tnq']; ?></td>
                        <td style="text-align: center">
                            <form action="question.php?question=1" method="POST">
                                <input type="hidden" name="quizId" value="<?php echo $row['q_id']; ?>">
                                <input type="submit" value="Sākt" class="button btn-primary" style="margin: 0px !important;">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>