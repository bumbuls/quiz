<?php
session_start();
include "../config/database.php";
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $query = "SELECT * FROM tbl_quiz where q_id='".$_GET['q']."'";
    $run = mysqli_query($connection,$query);
    $result = mysqli_fetch_array($run);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pievienot viktorīnu</title>

        <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

        <!-- custom css file link  -->
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/form.css">

    </head>
    <body style="background: #e5e5e5;">

    <?php include "../includes/header.php"; ?>

    <section class="home">
        <div class="container">
            <div class="forms">
                <div class="form login">
                    <span class="title">Pievienot viktorīnu</span>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error" style="font-size: 1.5rem;"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if (isset($_GET['success'])) { ?>
                        <p class="success" style="font-size: 1.5rem;"><?php echo $_GET['success']; ?></p>
                    <?php } ?>
                    <form action="../process/UpdateQuizProcess.php" method="post">
                        <div class="input-field">
                            <input type="hidden" name="q_id" value="<?php echo $result['q_id']; ?>">
                            <?php if (isset($_GET['q_name'])) { ?>
                                <input type="text" name="q_name" value="<?php echo $_GET['q_name']; ?>" placeholder="Pievienot viktorīnas nosaukumu">
                                <i class="uil uil-notes icon"></i>
                            <?php }else{ ?>
                                <input type="text" name="q_name" value="<?php echo $result['q_name']; ?>"  placeholder="Pievienot viktorīnas nosaukumu">
                                <i class="uil uil-notes icon"></i>
                            <?php }?>
                        </div>
                        <div class="input-field">
                            <?php if (isset($_GET['q_time'])) { ?>
                                <input type="text" name="q_time" value="<?php echo $_GET['q_time']; ?>" placeholder="Laiks (min)">
                                <i class="uil uil-clock icon"></i>
                            <?php }else{ ?>
                                <input type="text" name="q_time" value="<?php echo $result['q_time']; ?>" placeholder="Laiks (min)">
                                <i class="uil uil-clock icon"></i>
                            <?php }?>
                        </div>
                        <div class="input-field button">
                            <input type="submit" name="addQuiz" value="Mainīt">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
    </body>
    </html>
    <?php
}else{
    header("Location: ../login.php");
    exit();
}
?>