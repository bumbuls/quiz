<?php
session_start();
include "../config/database.php";

if (isset($_POST['q_name']) && isset($_POST['q_time'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $qName = validate($_POST['q_name']);
    $qTime = validate($_POST['q_time']);

    $user_data = 'q_name='. $qName. '&q_time='. $qTime;


    if (empty($qName)) {
        header("Location: ../auth/add-quiz.php?error=Viktorīnas nosakumums ir obligāts");
        exit();
    }else if (empty($qTime)) {
        header("Location: ../auth/add-quiz.php?error=Laiks ir obligāts");
        exit();
    }
    else{

        $sql2 = "UPDATE tbl_quiz set q_name ='".$qName."',q_time = '".$qTime."' where q_id ='".$_POST['q_id']."'";
        $result2 = mysqli_query($connection, $sql2);
        if ($result2) {
            header("Location: ../auth/dashboard.php?success=Viktorīna tika atjaunota");
            exit();
        }else {
            header("Location: ../auth/add-quiz.php?error=viss slikti");
            exit();
        }
    }

}else{
    header("Location: ../auth/dashboard.php");
    exit();
}