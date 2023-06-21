<?php
session_start();
include "config/database.php";
// Get all answer
$sql = "SELECT * FROM tbl_draft where dft_q_id = '".$_SESSION['quizId']."' and dft_key='".$_SESSION['key']."' ";
$result = mysqli_query($connection, $sql);
?>
<?php
if (!isset($_SESSION['player_name'])) {
    header("Location: index.php");
    exit();
}
?>
<!-- Get total question -->
<?php
$total = "SELECT * FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."'" ;
$run = mysqli_query($connection , $total) or die(mysqli_error($connection));
$totalqn = mysqli_num_rows($run);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viktorīna</title>
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/form.css">

    <!--<title>Login & Registration Form</title>-->
</head>
<body class="details-body">

<div class="container" style="max-width: 1000px">
    <div class="forms">
        <div class="form login">
            <span style="font-size: 1.3rem; font-weight: 600">Spēlētāja vārds: <?php echo $_SESSION['player_name']; ?></span><br>
            <span style="font-size: 1.3rem; font-weight: 600;">Viktorīnas nosaukums: <?php echo $_SESSION['quizName']; ?></span><br>
            <span style="font-size: 1.3rem; font-weight: 600" class="">Rezultāts: <?php echo $_SESSION['score']; ?> no <?php echo $totalqn; ?></span>
            <hr>
            <?php $no =1;?>
            <?php while($row = mysqli_fetch_array($result)){
                $query = "SELECT * FROM tbl_question WHERE qq_q_id = '".$row['dft_q_id']."' and qno = '".$row['dft_qq_id']."'" ;
                $run = mysqli_query($connection , $query) or die(mysqli_error($connection));
                $row2 = mysqli_fetch_array($run);
                ?>
            <div class="">
                <p class="question"><?php echo $no++; ?>. &nbsp;<?php echo $row2['qq_name']; ?></p>
                <?php if($row2['qq_type'] == 1){?>
                <ul class="choices" >
                    <li><span class="<?php if(1 == $row['dft_c_ans']){echo "correctAns";}elseif(1 == $row['dft_ans']){echo "wrongAns";}?>">a. <?php echo $row2['qq_option_1']; ?> <?php if(1 == $row['dft_ans']){echo '<span class="yourAns">Jūsu atbilde</span>';}elseif(1 == $row['dft_c_ans']){echo '<span class="yourAns">Pareizā atbilde</span>';}?></span></li>
                    <li><span class="<?php if(2 == $row['dft_c_ans']){echo "correctAns";}elseif(2 == $row['dft_ans']){echo "wrongAns";}?>">b. <?php echo $row2['qq_option_2']; ?><?php if(2 == $row['dft_ans']){echo '<span class="yourAns">Jūsu atbilde</span>';}elseif(2 == $row['dft_c_ans']){echo '<span class="yourAns">Pareizā atbilde</span>';}?></span></li>
                    <li><span class="<?php if(3 == $row['dft_c_ans']){echo "correctAns";}elseif(3 == $row['dft_ans']){echo "wrongAns";}?>">c. <?php echo $row2['qq_option_3']; ?><?php if(3 == $row['dft_ans']){echo '<span class="yourAns">Jūsu atbilde</span>';}elseif(3 == $row['dft_c_ans']){echo '<span class="yourAns">Pareizā atbilde</span>';}?></span></li>
                    <li><span class="<?php if(4 == $row['dft_c_ans']){echo "correctAns";}elseif(4 == $row['dft_ans']){echo "wrongAns";}?>">d. <?php echo $row2['qq_option_4']; ?><?php if(4 == $row['dft_ans']){echo '<span class="yourAns">Jūsu atbilde</span>';}elseif(4 == $row['dft_c_ans']){echo '<span class="yourAns">Pareizā atbilde</span>';}?></span></li>
                </ul>
                    <hr>

                <?php }else{?>
                    <?php if($row['dft_ans'] == $row['dft_c_ans']){?>
                        <p class="typeAnswer"><?php echo $row['dft_c_ans'];?> <span class="yourAns">Pareizā atbilde</span></p>
                    <?php }else{?>
                        <p class="typeAnswer" style="margin-bottom: 5px"><?php echo $row['dft_c_ans'];?> <span class="yourAns">Pareizā atbilde</span></p>
                        <p class="typeAnswerWrong"style="margin-bottom: 5px"><?php echo $row['dft_ans'];?> <span class="yourAns">Jūsu atbilde</span></p>
                    <?php }?>
                    <hr>
                <?php }?>
            </div>
            <?php }?>
            <br><br>
            <a href="index.php" class="button btn-primary">Atpakaļ</a>
        </div>
    </div>
</div>
</body>
</html>