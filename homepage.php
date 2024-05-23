<?php
require 'php/dbconnection.php';
include 'php/sessioncheck.php';
check_user_role(1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AduCats</title>
    

    <!-- LINKS -->
    <link rel="stylesheet" href="style/homepage.css">
    <link rel="icon" href="img/WhiteLogoCat.png">

</head>
<body>
 
    <!--NAVBAR-->

    <nav class="nav_bar">

        <div class="left-navbar">
            <a href="adoption.php">Adoption Request</a> 
            <a href="donation.html">Donate</a> 
        </div>
        
        <img id="AduCatsLogo" src ="img/AduCatsLogo.png">
        
        <div class="right-navbar">
            <a href="cat-profile.php">Cat Profiles</a> 
            <a href="php/logout.php"><button>Logout</button></a>
            <?php
            // if ($_SESSION['user_role'] == 2) {
            //     echo '<p><a href="adminSide.php">Go to Admin side</a>.</p>';
            // } else {
            //     echo '<p>You do not have access to Admin side.</p>';
            // }
            ?>
        </div>
       
      </nav>


       <!--Etoh buong content ng Homepage-->

<div class="Homepage-Content">
    <!--Unang Part-->
      <section class="Overview">
         <div class="left-side-container">
            <h1>We advocate peaceful co-existence between the humans and furry friends...</h1>
            <a href="cat-profile.php"><button>Cat Profiles</button></a>
         </div>

         <div class="right-side-container">
        <!--Photo Slider Section-->
            <section class="container">
                <div class="slider-wrapper">
                    
                    <div class="slider">
                        <img id="slide-1" src="img/Slider1.png">
                        <img id="slide-2" src="img/Slider2.png">
                        <img id="slide-3" src="img/Slider3.png">
                    
                    </div>
                    <div class="slider-nav">
                        <a href="#slide-1"></a>
                        <a href="#slide-2"></a>
                        <a href="#slide-3"></a>
                    </div>
                </div>
            </section>

         </div>
      </section>

 <!--Pangalawang Part-->
      <section class="Information">
        <div class="left-side-container">
            <img id="AduCatCommunity"src="img/AduCatCommunity.png">
        </div>

        <div class="right-side-container">
            <h1>Why we need Cats in the Campus?</h1>
            <p>Cats play a major role in improving both students’ health and their psychological well-being through decreasing anxiety. According to Dabbos, “Animals reduce anxiety and stress because they release a chemical that actually works on reducing the stress.”</p>

        </div>

      </section>

<!--Last Part-->

<section class="Links">
    <div class="left-side-container">
        <h2>Ready to welcome a University Cat into your life? Adopt now and make a feline friend!</h2>
        <p>Experience the joy of welcoming a University Cat into your home. Begin your adoption journey now and give a cat a forever family!</p>
        <a href="adoption.php"><button>Request for Adoption</button></a>
    </div>

    <div class="right-side-container">
        <h2>Support our University Cats by ensuring they're well-fed and healthy!</h2>
        <p>Your donation helps us provide essential care for our University Cats, ensuring they stay healthy and happy. Support our cause today and make a difference in the lives of these beloved feline companions!</p>
        <a href="donation.html"><button>Donate</button></a>
    </div>

  </section>

</div>


<!--FOOTER NA TOH-->

  <footer>
     <div class="AduCatsLogo">
        <img id="FooterLogo"src="img/Cat-1.png">
        <p>© 2024 AduCats</p>
    </div>
    <div class="ContactUs">
        <h3>CONTACT US</h3>
        <a href="https://www.facebook.com/groups/946027585595117">Aducats Facebook</a>
        <p>0992 123 4561</p>
    </div>
    <div class="Address">
        <h3>ADDRESS</h3>
        <p>900 San Marcelino St, Ermita, Manila, 1000 Metro Manila</p>
    </div>
     
  </footer>




</body>
</html>