<header class="header">

    <section class="flex">
 
       <a href="../auth/dashboard.php" class="logo">Panelis</a>
 
       <nav class="navbar">
          <a href="../auth/add-quiz.php">Pievienot viktorīnu</a>
          <a href="../auth/add-question.php">Pievienot jautājumu</a>
          <a href="../auth/result.php">Rezultati</a>
       </nav>
 
       <div class="icons">
         <span style="font-size:2rem">Sveiks, <?php echo $_SESSION['name']; ?>!</span>
           <a href="../process/logout.php" class="delete-btn"><i class="uil uil-sign-out-alt"></i>izlogoties</a>
          <div id="menu-btn" class="fas fa-bars"></div>
       </div>
    </section> 
 </header>