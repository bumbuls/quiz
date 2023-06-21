<?php
session_start(); // sāk jaunu sesiju
include "../config/database.php"; // iekļauj datubazes failu

if (isset($_POST['selectType'])) { // pārbauda vai no formas ir kas iekšā
    function validate($data){ // izveido funkciju
        $data = trim($data); // Noņem atstarpes no sākuma un beigām
        $data = stripslashes($data); // noņem slīpsvītras
        $data = htmlspecialchars($data); // Pārvērš rakstzīmes par simboliem
        return $data; // atgriž datus
    }

    $qq_id = validate($_POST['qq_id']); // pievieno drošību ievades laukiem un saglabā vērības 
    $qq_name = validate($_POST['qq_name']);
    $qq_option1 = validate($_POST['ans_one']);
    $qq_option2 = validate($_POST['ans_two']);
    $qq_option3 = validate($_POST['ans_three']);
    $qq_option4 = validate($_POST['ans_four']);

    $qq_ca = validate($_POST['c_answer']);
    $qq_type = validate($_POST['qq_type_sa']);

    // Izveido SQL vaicājumu, lai atjauninātu jautājuma datus datubāzē nepieciešams lai rediģētu esošus ierakstus ar update tabulu un iestata qq_q_id no ievades lauka qq_id un pārējos laukus
    $sql = "UPDATE tbl_question set qq_q_id='".$qq_id."', qq_name='".$qq_name."', qq_option_1='".$qq_option1."',qq_option_2='".$qq_option2."',qq_option_3='".$qq_option3."',qq_option_4='".$qq_option4."',qq_ca='".$qq_ca."' where qq_id='".$_POST['qqid']."'";
    $result = mysqli_query($connection, $sql); // Izpilda vaicājumu, saņem rezultātu
    if ($result) { // ja veicinajusm izpildīsies veiksmīgi
        header("Location: ../auth/view-question.php?view=$qq_id"); // tad tik pārmests uz iepriekšējo lapu
        exit(); // Aptur turpmāku izpildi
    }else {
        header("Location: ../auth/add-question.php?error=viss slikti");
        exit();
    }

}else if (isset($_POST['typeAnswer'])) {
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $qq_id = validate($_POST['qq_id']);
    $qq_name = validate($_POST['qq_name']);
    $answer = validate($_POST['answer']);
    $qq_type = validate($_POST['qq_type_ta']);

    $sql = "UPDATE tbl_question set qq_q_id='".$qq_id."', qq_name='".$qq_name."',qq_ca='".$answer."' where qq_id='".$_POST['qqid']."'";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        header("Location: ../auth/view-question.php?view=$qq_id");
        exit();
    }else {
        header("Location: ../auth/dashboard.php?error=viss slikti");
        exit();
    }

}else{
    header("Location: ../auth/dashboard.php");
    exit();
}