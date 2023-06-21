<?php
session_start();
include "../config/database.php"; // savienoajs ar db

if (isset($_POST['selectType'])) { // ja forma ir iesniegta
    function validate($data){
        $data = trim($data); // Noņem atstarpes no sākuma un beigām
        $data = stripslashes($data); // noņem slīpsvītras
        $data = htmlspecialchars($data); // Pārvērš rakstzīmes par simboliem
        return $data; // atgriž datus
    }


    $qq_id = validate($_POST['qq_id']); // iegūst jauājumu id, nosakumumu un atbilžu variantiem no formas un pārbauda ar funkciju validate
    $qq_name = validate($_POST['qq_name']);
    $qq_option1 = validate($_POST['ans_one']);
    $qq_option2 = validate($_POST['ans_two']);
    $qq_option3 = validate($_POST['ans_three']);
    $qq_option4 = validate($_POST['ans_four']);

    $qq_ca = validate($_POST['c_answer']);
    $qq_type = validate($_POST['qq_type_sa']);

    $qno = 1;
    $query = "SELECT qno FROM tbl_question where qq_q_id='".$qq_id."' ORDER BY qq_id DESC LIMIT 1"; // Iegūst pēdējo jautājuma numuru qq_id dilstošā secībā
    $run = mysqli_query($connection,$query); // izpilda veicinājumu
    $result20 = mysqli_fetch_array($run); // iegūst rezultātu no veicinājuma

    if(mysqli_num_rows($run) > 0){ // Nosaka jauno jautājuma numuru
        $qno = $result20['qno']+1; // Palielina pēdējā jautājuma numuru par 1, lai 
    }else{
        $qno = 1; // Ja nav iepriekšēju jautājumu iestata jautājuma numuru uz 1
    }

    $user_data = '';
        // Ievieto jautājumus datubāzē
    $stmt = $connection->prepare("INSERT INTO tbl_question(qq_q_id, qno, qq_name, qq_option_1, qq_option_2, qq_option_3, qq_option_4, qq_ca, qq_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssss", $qq_id, $qno, $qq_name, $qq_option1, $qq_option2, $qq_option3, $qq_option4, $qq_ca, $qq_type);
    $result = $stmt->execute();


   //     $sql = "INSERT INTO tbl_question(qq_q_id,qno, qq_name, qq_option_1,qq_option_2,qq_option_3,qq_option_4,qq_ca,qq_type) VALUES('$qq_id','$qno', '$qq_name','$qq_option1','$qq_option2','$qq_option3','$qq_option4','$qq_ca','$qq_type')";
    //    $result = mysqli_query($connection, $sql);
        if ($result) { // Atjauno kopējo jautājumu skaitu
            $query = "UPDATE tbl_quiz SET q_tnq = q_tnq + 1 WHERE q_id  = '$qq_id'"; // palielina jautājuma skaitu q_id
            mysqli_query($connection, $query);
            header("Location: ../auth/add-question.php?success=Jauns jautājums tika pievienots"); // ja veicinājums ir izdevies pārmet uz iepriekšējo lapu
            exit();
        }else {
            header("Location: ../auth/add-question.php?error=viss slikti&$user_data");
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

    $qno = 1;

    $query = "SELECT qno FROM tbl_question where qq_q_id='".$qq_id."' ORDER BY qq_id DESC LIMIT 1";
    $run = mysqli_query($connection,$query);
    $result20 = mysqli_fetch_array($run);

    if(mysqli_num_rows($run) > 0){
        $qno = $result20['qno']+1;
    }else{
        $qno = 1;
    }

    $user_data = '';

    
    $sql = "INSERT INTO tbl_question(qq_q_id,qno, qq_name, qq_option_1,qq_option_2,qq_option_3,qq_option_4,qq_ca,qq_type) VALUES('$qq_id','$qno', '$qq_name','','','','','$answer','$qq_type')";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $query = "UPDATE tbl_quiz SET q_tnq = q_tnq + 1 WHERE q_id  = '$qq_id'";
        mysqli_query($connection, $query);
        header("Location: ../auth/add-question.php?success=Jauns jautājums tika pievienots");
        exit();
    }else {
        header("Location: ../auth/add-question.php?error=viss slikti&$user_data");
        exit();
    }

}else{
    header("Location: ../auth/add-question.php");
    exit();
}