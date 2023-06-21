<?php
session_start(); // sāk jaunu sesiju
include "../config/database.php"; // pieveino db failu

if (isset($_POST['username']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['c_password'])) { // pārbuda vai lauki ir iesnigti

    function validate($data){
        $data = trim($data); // Noņem atstarpes no sākuma un beigām
        $data = stripslashes($data); // noņem slīpsvītras
        $data = htmlspecialchars($data); // Pārvērš rakstzīmes par simboliem
        return $data; // atgriž datus
    }

    $uname = validate($_POST['username']); // pievieno drošibu ievadees laukiem un saglabā 
    $pass = validate($_POST['password']);

    $re_pass = validate($_POST['c_password']);
    $name = validate($_POST['name']);



    if (empty($name)) { // ja vārds ir tukšs
        header("Location: ../register.php?error=Vārds ir obligāts"); // Pārmet uz reģistrācijas lapu ar kļūdas paziņojumu
        exit(); // Aptur turpmāku izpildi
    }else if (empty($uname)) { // ja lietotājvārds ir tukšs
        header("Location: ../register.php?error=Lietotājvārs ir obligats"); // Pārmet uz reģistrācijas lapu ar kļūdas paziņojumu
        exit(); // Aptur turpmāku izpildi
    }else if(empty($pass)){ // ja parole ir tukša
        header("Location: ../register.php?error=Parole ir obligāta"); // Pārmet uz reģistrācijas lapu ar kļūdas paziņojumu
        exit(); // Aptur turpmāku izpildi
    }
    else if(empty($re_pass)){ // ja apstiprini paroli ir tukšs
        header("Location: ../register.php?error=Apstiprini paroli ir obligāta"); // Pārmet uz reģistrācijas lapu ar kļūdas paziņojumu
        exit(); // Aptur turpmāku izpildi
    }

    else if($pass !== $re_pass){ // ja abas paroles nesakrīt
        header("Location: ../register.php?error=Paroles nesakrīt"); // Pārmet uz reģistrācijas lapu ar kļūdas paziņojumu
        exit(); // Aptur turpmāku izpildi
    }

    else{

        $pass = md5($pass); // iekode paroli drosībai

        $sql = "SELECT * FROM tbl_user WHERE username='$uname' "; // pārbauda vai lietotājs eksiste 
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) { // ja lietotājs no db ir lielāks par 0 tad lietotājs eksitē, ja reult skaits ir 0 tad lietoajs nav reģistrēts
            header("Location: ../register.php?error=Lietotājs existē! Mēģini citu"); // ja eksite uzmet ziņojumu
            exit(); // Aptur turpmāku izpildi
        }else {
            $sql2 = "INSERT INTO tbl_user(name, username, password) VALUES('$name', '$uname', '$pass')"; // ievieto datus db no formas
            $result2 = mysqli_query($connection, $sql2);
            if ($result2) {
                header("Location: ../register.php?success=Konts tika izveidots"); // veiksmes ziņojums 
                exit(); // Aptur turpmāku izpildi
            }else {
                header("Location: ../register.php?error=unknown error occurred"); // kļudas ziņojums 
                exit(); // Aptur turpmāku izpildi
            }
        }
    }

}else{
    header("Location: ../register.php");
    exit();
}