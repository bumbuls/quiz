<?php
session_start();
include "../config/database.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        $_SESSION['error']="Lietotājvārds ir obligāts";
        header("Location: ../login.php");
        exit();
    }else if(empty($pass)){
        $_SESSION['error']="Parole ir obligāta";
        header("Location: ../login.php");
        exit();
    }else{
        // hashing the password
        $pass = md5($pass);

        $sql = "SELECT * FROM tbl_user WHERE username='$uname' AND password='$pass'";

        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['username'] === $uname && $row['password'] === $pass) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: ../auth/dashboard.php");
                exit();
            }else{
                header("Location: ../login.php?error=Nepareizs lietotājvārds vai parole");
                exit();
            }
        }else{
            header("Location: ../login.php?error=Nepareizs lietotājvārds vai parole");
            exit();
        }
    }

}else{
    header("Location: login.php");
    exit();
}