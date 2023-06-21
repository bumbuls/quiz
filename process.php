<?php
session_start();
include "config/database.php";
if (isset($_SESSION['quizId'])) { // Pārbauda  vai quizId sesija ir iestatīts
    if(!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
    }

    if ($_POST) {
        $newtime = time();
        if ( $newtime > $_SESSION['time_up']) { // Ja  laiks ir lielāks par sesijas mainīgo
            $_SESSION['start_time'] = $newtime;
            $qno = $_POST['number'];
            $_SESSION['question'] = $_SESSION['question'] + 1;
            $selected_choice = $_POST['choice'];
            $nextqno = $qno+1; // Aprēķina nākamā jautājuma numuru

            $query = "SELECT qq_ca FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."' and qno = '$qno'"; // atlasa pareizo atbildi no pašreizējam jautājumam
            $run = mysqli_query($connection , $query) or die(mysqli_error($connection)); // saglabā rezultātu mainīgajā
            if(mysqli_num_rows($run) > 0 ) { // Ja rezultātā ir vismaz viena rinda
                $row = mysqli_fetch_array($run);
                $correct_answer = $row['qq_ca']; // Paņem pareizo atbildi no rindas
            }
            if ($correct_answer == $selected_choice) { // Ja izvēlētā atbilde ir pareiza palienina punktu skaitu
                $_SESSION['score']++;
            }
            $playerName = $_SESSION['player_name']; // paņem no sesijas mainīgajiem
            $key = $_SESSION['key'];
            $quizId = $_SESSION['quizId'];
            $insertQuery = "INSERT INTO tbl_draft(dft_name,dft_key,dft_q_id,dft_qq_id,dft_ans,dft_c_ans) values ('$playerName','$key','$quizId','$qno','$selected_choice','$correct_answer')";
            mysqli_query($connection, $insertQuery) or die(mysqli_error($connection));

            $query1 = "SELECT qq_ca FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."'"; // atlasa visas pareizās atbildes viktorīnai
            $run = mysqli_query($connection , $query1) or die(mysqli_error($connection));
            $totalqn = mysqli_num_rows($run); // Iegūst rezultāta kopējo rindu skaitu

            if ($qno == $totalqn) { // Ja pašreizējā jautājuma skaits ir vienāds ar kopējo jautājumu skaitu
                $lastTime = time(); // paņemt pašreizējo laiku sek
                $_SESSION['usedTime'] = $lastTime - $_SESSION['startTime']; // Aprēķiniet viktorīnai patērēto laiku
                header("location: final.php"); // pārmet uz nākamo lapu
            }
            else {
                header("location: question.php?question=".$nextqno);
            }
        }
        else { // 
            $_SESSION['start_time'] = $newtime; // atiestata sākuma laiku
            $qno = $_POST['number'];
            $_SESSION['question'] = $_SESSION['question'] + 1;
            $selected_choice = $_POST['choice']; // paņem no post
            $nextqno = $qno+1; // aprēķina nākamā jautājuma numuru

            $query = "SELECT qq_ca FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."' and qno = '$qno'"; // iegūt pareizo atbildi no db
            $run = mysqli_query($connection , $query) or die(mysqli_error($connection));
            if(mysqli_num_rows($run) > 0 ) {
                $row = mysqli_fetch_array($run);
                $correct_answer = $row['qq_ca'];
            }
            if ($correct_answer == $selected_choice) { // atjaunina rezultātu, ja atbilde ir pareiza
                $_SESSION['score']++;
            }
            $playerName = $_SESSION['player_name'];
            $key = $_SESSION['key'];
            $quizId = $_SESSION['quizId'];
            $insertQuery = "INSERT INTO tbl_draft(dft_name,dft_key,dft_q_id,dft_qq_id,dft_ans,dft_c_ans) values ('$playerName','$key','$quizId','$qno','$selected_choice','$correct_answer')";
            mysqli_query($connection, $insertQuery) or die(mysqli_error($connection));

            $query1 = "SELECT qq_ca FROM tbl_question WHERE qq_q_id = '".$_SESSION['quizId']."'"; // iegūst kopējo jautājumu skaitu viktorīnā
            $run = mysqli_query($connection , $query1) or die(mysqli_error($connection));
            $totalqn = mysqli_num_rows($run);

            if ($qno == $totalqn) { // pārmet uz pēdējo lapu, ja ir tikts līdz pēdējam jautājumam
                $lastTime = time();
                $_SESSION['usedTime'] = $lastTime -$_SESSION['startTime'];
                header("location: final.php");
            }
            else {
                header("location: question.php?question=".$nextqno);
            }
        }
    }
    else {
        header("location: index.php");
    }
} else {
    header("location: index.php");
}
?>