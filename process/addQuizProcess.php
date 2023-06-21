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



    if (empty($qName)) {
        header("Location: ../auth/add-quiz.php?error=Viktorīna ir obligāta");
        exit();
    }else if (empty($qTime)) {
        header("Location: ../auth/add-quiz.php?error=Laiks ir obligāts");
        exit();
    }
    else{

        $sql = "SELECT * FROM tbl_quiz WHERE q_name='$qName' ";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../auth/add-quiz.php?error=TViktorīna eksitē");
            exit();
        }else {
            $sql2 = "INSERT INTO tbl_quiz(q_name, q_time) VALUES('$qName', '$qTime')";
            $result2 = mysqli_query($connection, $sql2);
            if ($result2) {
                header("Location: ../auth/add-quiz.php?success=Viktorīna pievienota");
                exit();
            }else {
                header("Location: ../auth/add-quiz.php?error=viss slikti");
                exit();
            }
        }
    }

}else{
    header("Location: ../auth/add-quiz.php");
    exit();
}