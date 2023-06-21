<?php
session_start();
include "config/database.php";
if (isset($_POST['quizId'])) {
    $sqlQuery = "SELECT * FROM tbl_quiz where q_id = '".$_POST['quizId']."'"; 
    $result = mysqli_query($connection, $sqlQuery);
    $row = mysqli_fetch_array($result);

    $querySelect = "SELECT * FROM tbl_question where qq_q_id = '".$_POST['quizId']."'"; // paņem no db qq_q_id un ieseto to post mainīgajā
    $result2 = mysqli_query($connection, $querySelect);
    $_SESSION['quizId'] = $_POST['quizId'];
    $_SESSION['quizName'] = $row['q_name'];
    $key = rand(10000,99999); // ģenerē nejaušu veselu skaitli no 10000 līdz 99999 un piešķir to mainīgajam "key"
    $_SESSION['key'] = $key; // iestata "key" sesijas mainīgo uz ģenerēto skaitli
    $_SESSION['score'] = 0;
    $_SESSION['totalQuestion'] = $row['q_tnq'];
    $timePerQuestion =  ($row['q_time']*60)/$row['q_tnq']; // aprēķina vienam jautājumam atļauto laiku no tabulas "tbl_quiz" kolonnām "q_time" un "q_tnq"
    $min = number_format($timePerQuestion / 60,2); // formatē katram jautājumam atļauto aprēķināto laiku līdz 2 zīmēm aiz komata
    $_SESSION['timmer'] = $timePerQuestion; // iestata timer uz parēķinā laiku, kas aļauts vienam jautājumam
    $_SESSION['startTime'] = time();

    if (isset($_GET['question']) && is_numeric($_GET['question'])) { // pārbauda, vai 'jautājums' ir iestatīts GET un ir skaitlisks
        $qno = $_GET['question'];
        if ($qno == 1) {
            $_SESSION['question'] = 1;
        }
    }
    else {
        header('location: question.php?question='.$_SESSION['question']); // pārmet uz 'question.php' lapu ar parametru 'question'..
    }

    if (isset($_SESSION['question']) && $_SESSION['question'] == $qno) { // pārbauda vai sesijas mainīgais 'question' ir iestatits un ir veināds ar $qno
        $query = "SELECT * FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."' and qno = '$qno'" ; // atlasa qq_q_id un qno no tbl_question
        $run = mysqli_query($connection , $query) or die(mysqli_error($connection)); 
        if (mysqli_num_rows($run) > 0) {
            $row = mysqli_fetch_array($run);
            $qno = $row['qno'];
            // pieskir kolonu vērtības mainīgajiem
            $question = $row['qq_name'];
            $ans1 = $row['qq_option_1'];
            $ans2 = $row['qq_option_2'];
            $ans3 = $row['qq_option_3'];
            $ans4 = $row['qq_option_4'];
            $correct_answer = $row['qq_ca'];
            $_SESSION['question'] = $qno;
            $qType = $row['qq_type'];
            $checkqsn = "SELECT * FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."'" ; // saskaita viktōrīnas jauājuma skaitu
            $runcheck = mysqli_query($connection , $checkqsn) or die(mysqli_error($connection));
            $countqsn = mysqli_num_rows($runcheck);
            // iegūst pašreizējo laikaposmu un iestata sesijas mainīgo start_time
            $time = time();
            $_SESSION['start_time'] = $time;
            $allowed_time = $countqsn * 0.08;
            $_SESSION['time_up'] = $_SESSION['start_time'] + ($allowed_time * 60) ;
        }
    }
}else{
    if (isset($_GET['question']) && is_numeric($_GET['question'])) {
        $qno = $_GET['question'];
        if ($qno == 1) {
            $_SESSION['question'] = 1;
        }
    } else {
        header('location: question.php?question='.$_SESSION['question']);
    }

    if (isset($_SESSION['question']) && $_SESSION['question'] == $qno) {
        $query = "SELECT * FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."' and qno = '$qno'" ;
        $run = mysqli_query($connection , $query) or die(mysqli_error($connection));
        if (mysqli_num_rows($run) > 0) {
            $row = mysqli_fetch_array($run);
            $qno = $row['qno'];
            $question = $row['qq_name'];
            $ans1 = $row['qq_option_1'];
            $ans2 = $row['qq_option_2'];
            $ans3 = $row['qq_option_3'];
            $ans4 = $row['qq_option_4'];
            $correct_answer = $row['qq_ca'];
            $_SESSION['question'] = $qno;
            $qType = $row['qq_type'];
            $checkqsn = "SELECT * FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."'" ;
            $runcheck = mysqli_query($connection , $checkqsn) or die(mysqli_error($connection));
            $countqsn = mysqli_num_rows($runcheck);
            $time = time();
            $_SESSION['start_time'] = $time;
            $allowed_time = $countqsn * 0.08;
            $_SESSION['time_up'] = $_SESSION['start_time'] + ($allowed_time * 60) ;
        }
    }
}
?>
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
    <title>Quiz</title>
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
            <span style="font-size: 1.3rem; font-weight: 600">Viktorīnas nosaukums: <?php echo $_SESSION['quizName']; ?></span><br>
            <span style="font-size: 1.3rem; font-weight: 600" class="">Jautājums <?php echo $qno; ?> no <?php echo $totalqn; ?></span>
            <span style="font-size: 1.3rem; font-weight: 600;float: right; color: #C21807" id="time" class=""><?php echo $_SESSION['timmer'];?></span>
            <hr>
            <p class="question"><?php echo $question; ?></p>
            <form method="post" action="process.php">
                <?php if($qType == 1){?>
                <ul class="choices">
                    <li><input name="choice" type="radio" id="ans1" value="1" required=""><?php echo $ans1; ?></li>
                    <li><input name="choice" type="radio" id="ans2"value="2" required=""><?php echo $ans2; ?></li>
                    <li><input name="choice" type="radio" id="ans3"value="3" required=""><?php echo $ans3; ?></li>
                    <li><input name="choice" type="radio" id="ans4"value="4" required=""><?php echo $ans4; ?></li>
                </ul>
                <?php }else{?>
                    <div class="input-field">
                        <input name="choice" type="text" class="" id="ans" placeholder="Raksti atbili" required="">
                        <i class="uil uil-notes icon"></i>
                    </div>
                <?php }?>
                <br>
                <input class="button btn-primary" type="submit" id="nextBtn" value="Tālāk">
                <input type="hidden" name="number" value="<?php echo $qno;?>">
            </form>
        </div>
    </div>
</div>
<script>

    function startTimer(duration, display) {
        var button = document.getElementById('nextBtn'), // Iegūst pogas un formas elementus un neļauj veidlapai refresh, kad click on button
            form = button.form;
        form.addEventListener('submit', function(){ // kad veidlapa tiek iesneigta tiek izpildīta funk.
            return false;
        })
        var timer = duration, minutes, seconds;
        setInterval(function () {  // Izveido funkciju taimera atjaunināšanai
            minutes = parseInt(timer / 60, 10); // Aprēķina minūtes un sekundes
            seconds = parseInt(timer % 60, 10); 

            minutes = minutes < 10 ? "0" + minutes : minutes; // Formatē laiku, lai vienmēr tiktu rādīti divi cipari
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.textContent = minutes + ":" + seconds;

            if (--timer < 0) { // ja taimeris sasniedz nulli, apspējo atbildes pogas un nākamo pogu un iesniedz formu pēc 3 sekunžu aizkaves
                document.getElementById("time").innerHTML= "Laiks beidzies!";
                document.getElementById("ans1").disabled = true;
                document.getElementById("ans2").disabled = true;
                document.getElementById("ans3").disabled = true;
                document.getElementById("ans4").disabled = true;
                document.getElementById("nextBtn").disabled = true;
                window.setTimeout(function() { // pēc 3 sek ziakaves iesniedz formu
                    form.submit();
                    }, 3000);

            }
        }, 1000);
    }

    window.onload = function () {
        var fiveMinutes = document.getElementById("time").innerHTML, // iegūst sākotnējā laika vērtību
            display = document.querySelector('#time'); // Iegūst elementu, kurā tiks rādīts taimers
        startTimer(fiveMinutes, display); // Sāk taimera skaitīšanu
    };
</script>
</body>
</html>