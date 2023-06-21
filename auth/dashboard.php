<?php
session_start();
include "../config/database.php";
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {
    $sql = "SELECT * FROM tbl_quiz";
    $result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body style="background: #e5e5e5;">
   <?php include "../includes/header.php"; ?>
<section class="home">
   <div class="home-slider">
      <div class="swiper-wrapper">
         <div class="swiper-slide slide">
            <div class="content">
               <h3>Visas viktorīnas</h3>
               <table class="table table-striped">
                  <thead>
                  <tr>
                      <th>ID</th>
                      <th>Nosaukums</th>
                      <th>Laiks</th>
                      <th>Kopējie jautājumi</th>
                      <th>Darbības</th>
                  </tr>
                  </thead>
      
                  <tbody>
                  <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_array($result)){?>
                  <tr>
                      <td style="text-align: center"><?php echo $no++; ?></td>
                      <td style="text-align: center"><?php echo $row['q_name']; ?></td>
                      <td style="text-align: center"><?php echo $row['q_time']; ?>min</td>
                      <td style="text-align: center"><?php echo $row['q_tnq']; ?></td>
                      <td style="text-align: center">
                          <a href="view-question.php?view=<?php echo $row['q_id']; ?>" class="btn-info">Skatīt</a>
                          <a href="edit-quiz.php?q=<?php echo $row['q_id']; ?>" class="btn-primary">Rediģēt</a>
                      </td>
                  </tr>
                    <?php } ?>
                  </tbody>
              </table>
            </div>
         </div>
      </div>
   </div>
</section>
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="../js/script.js"></script>
</body>
</html>
    <?php
}else{
    header("Location: ../login.php");
    exit();
}
?>