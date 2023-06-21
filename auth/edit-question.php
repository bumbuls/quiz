<?php
session_start();
include "../config/database.php";
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $sql = "SELECT * FROM tbl_question where qq_id='".$_GET['q']."'";
    $run = mysqli_query($connection, $sql);
    $result = mysqli_fetch_array($run);

    $sql2 = "SELECT * FROM tbl_quiz";
    $run2 = mysqli_query($connection, $sql2);
    $run3 = mysqli_query($connection, $sql2);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pievienot jautājumu</title>

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
        <?php if($result['qq_type'] == 1){?>
        <div class="container">
            <div class="forms">
                <div class="form login">
                    <span class="title">Pievienot jautājumu</span>
                    <span style="font-size: 15px;">Izvelies atbildi</span>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if (isset($_GET['success'])) { ?>
                        <p class="success"><?php echo $_GET['success']; ?></p>
                    <?php } ?>
                    <form action="../process/UpdateQuestionProcess.php" method="post">
                        <div class="input-field">
                            <select name="qq_id" required>
                                <option value="">Izvelies viktorīnu</option>
                                <?php while ($row = mysqli_fetch_array($run2)){?>
                                    <option value="<?php echo $row['q_id']; ?>" <?php if($row['q_id'] == $result['qq_q_id']){echo "selected";}?>><?php echo $row['q_name']; ?></option>
                                <?php } ?>
                            </select>
                            <i class="uil uil-notes icon"></i>
                        </div>
                        <div class="input-field">
                            <input type="hidden" name="qqid" value="<?php echo $result['qq_id'];?>">
                            <input type="text" name="qq_name" value="<?php echo $result['qq_name'];?>" placeholder="Jautājums nosaukums" required>
                            <i class="uil uil-notes icon"></i>
                            <input type="hidden" name="qq_type_sa" value="1">
                        </div>
                        <h4 style="margin-top: 10px;font-size: 15px;">Opcijas</h4>
                        <div class="input-field margin-top">
                            <input type="text" name="ans_one" value="<?php echo $result['qq_option_1'];?>" placeholder="Opcija 1" required>
                            <input type="radio" name="c_answer" value="1" class="checkbox" <?php if(1 == $result['qq_ca']){echo "checked";}?> required>
                        </div>
                        <div class="input-field margin-top">
                            <input type="text" name="ans_two" value="<?php echo $result['qq_option_2'];?>" placeholder="Opcija 2" required>
                            <input type="radio" name="c_answer" value="2" class="checkbox" <?php if(2 == $result['qq_ca']){echo "checked";}?> required>
                        </div>
                        <div class="input-field margin-top">
                            <input type="text" name="ans_three" value="<?php echo $result['qq_option_3'];?>" placeholder="Opcija 3" required>
                            <input type="radio" name="c_answer" value="3" <?php if(3 == $result['qq_ca']){echo "checked";}?> class="checkbox"required>
                        </div>
                        <div class="input-field margin-top">
                            <input type="text" name="ans_four" value="<?php echo $result['qq_option_4'];?>" placeholder="Opcija 4" required>
                            <input type="radio" name="c_answer" value="4" <?php if(4 == $result['qq_ca']){echo "checked";}?> class="checkbox"required >
                        </div>
                        <div class="input-field button">
                            <input type="submit" name="selectType" value="Mainīt">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php }else{?>

        <div class="container">
            <div class="forms">
                <div class="form login">
                    <span class="title">Pievienot jautājumu</span>
                    <span style="font-size: 15px;">Raksti atbildi</span>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <?php if (isset($_GET['success'])) { ?>
                        <p class="success"><?php echo $_GET['success']; ?></p>
                    <?php } ?>
                    <form action="../process/UpdateQuestionProcess.php" method="post">
                        <div class="input-field">
                            <select name="qq_id">
                                <option value="">ivēlies viktorīnu...</option>
                                <?php while ($row = mysqli_fetch_array($run3)){?>
                                    <option value="<?php echo $row['q_id']; ?>" <?php if($row['q_id'] == $result['qq_q_id']){echo "selected";}?>><?php echo $row['q_name']; ?></option>
                                <?php } ?>
                            </select>
                            <i class="uil uil-notes icon"></i>
                        </div>
                        <div class="input-field">
                            <input type="hidden" name="qqid" value="<?php echo $result['qq_id'];?>">
                            <input type="text" name="qq_name" value="<?php echo $result['qq_name']; ?>" placeholder="Jautājuma nosaukums" required>
                            <i class="uil uil-notes icon"></i>
                            <input type="hidden" name="qq_type_ta" value="2">
                        </div>
                        <div class="input-field">
                            <input type="text" name="answer" value="<?php echo $result['qq_ca']; ?>" placeholder="Atbilde" required>
                            <i class="uil uil-notes icon"></i>
                        </div>
                        <div class="input-field button">
                            <input type="submit" name="typeAnswer" value="Mainīt">
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php }?>
    </section>
    </body>
    </html>
    <?php
}else{
    header("Location: ../login.php");
    exit();
}
?>