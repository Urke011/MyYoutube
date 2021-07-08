<?php require_once("includes/config.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/FormSanitize.php");

  $account = new Account($con);
if(isset($_POST["subButton"])){

  $username = FormSanitizer::sanitizeFormUsername($_POST["username"]);
  $password = FormSanitizer::sanitizeFormPassword($_POST["userPassword"]);

$wasSuccessful = $account->login($username,$password);

  if($wasSuccessful){
      $_SESSION['userLoggedIn'] = $username;
      header("Location: index.php");
  }
}








?>
<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="assets/js/main.js">

  </script>
  <title>SignIn</title>
</head>
<body>

    <div class="signInContainer">
       <div class="column">
           <div class="header">
          <img src="assets/icons/VideoTubeLogo.png">
          <h3>SignIn</h3>
          <span>To continue to MyYouTube</span>
           </div>
           <div class="loginForm">
             <form action="signIn.php" method="post">
               <?php echo $account->getError(Constants::$loginFaild); ?>
                  <input type="text" name="username" placeholder="Username">
                  <input type="password" name="userPassword" placeholder="Password">
                  <input type="submit" name="subButton" value="submit">
             </form>

           </div>
           <a class="signInMessage" href="signUp.php">Need a account? Sign up here!</a>
       </div>
    </div>
</body>
</html>
