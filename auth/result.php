<?php
session_start();
include "../config/database.php";
if (isset($_SESSION['id']) && isset($_SESSION['username'])) {  // Pārbauda, vai sesijā ir iestatīti 'id' un 'username'.
    $sql = "SELECT * FROM tbl_draft inner join tbl_quiz on tbl_draft.dft_q_id=tbl_quiz.q_id GROUP BY dft_key"; 
    // Izveido SQL vaicājumu, lai atlasītu visus 'tbl_draft' un 'tbl_quiz' laukus,
    // savieno tos pēc nosacījuma 'dft_q_id' ir vienāds ar 'q_id'.
    // Rezultāts tiek grupēts pēc 'dft_key' kolonnas.
    $result = mysqli_query($connection, $sql);
    $no=1;
    $inc = 0;
    $score = array();
    $sql2 = "SELECT COUNT(dft_c_ans) as dft_c_ans FROM `tbl_draft` WHERE dft_ans=dft_c_ans GROUP BY dft_key";
    //saskaitītu 'dft_c_ans' vērtību 'tbl_draft' tabulā,
    // Rezultāts tiek filtrēts, lai iekļautu tikai rindas,
    // kur 'dft_ans' ir vienāds ar 'dft_c_ans', un grupēts pēc 'dft_key' kolonnas.
    $result2 = mysqli_query($connection, $sql2);
    while ($row5 = mysqli_fetch_array($result2)){
        array_push($score,$row5['dft_c_ans']);
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Resultāti</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
   <link rel="stylesheet" href="../css/style.css">

</head>
<body style="background: #e5e5e5;">
   
<?php include "../includes/header.php"; ?>

<section class="home">
   <div class="home-slider">
      <div class="swiper-wrapper">
         <div class="swiper-slide slide">
            <div class="content">
               <h3>Visi rezultāti</h3>
               <table class="table table-striped">
                  <thead>
                  <tr>
                      <th>Id</th>
                      <th>Vārds</th>
                      <th>Rezultāts</th>
                      <th>Viktorīnas nosaukums</th>
                  </tr>
                  </thead>
      
                  <tbody>

                  <?php while($row = mysqli_fetch_array($result)){?>
                    
                  <tr>
                      <td style="text-align: center"><?php echo $no++;?></td>
                      <td style="text-align: center"><?php echo $row['dft_name'];?></td>
                      <td style="text-align: center"><?php echo $score[$inc];?> of <?php echo $row['q_tnq'];?></td>
                      <td style="text-align: center"><?php echo $row['q_name'];?></td>
                      
                  </tr>
                      <?php $inc++; ?>
                <?php }?>
                  </tbody>
              </table>
            </div>
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