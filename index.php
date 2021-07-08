<?php
require_once("includes/header.php"); ?>

            <?php if(isset($_SESSION['userLoggedIn'])){
              echo "User is logIn like ". $userLoggedObj->getName();
            } ?>

<?php
require_once("includes/footer.php"); ?>
