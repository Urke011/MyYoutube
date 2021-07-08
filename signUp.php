<?php require_once("includes/config.php");
require_once("includes/classes/FormSanitize.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

$account = new Account($con);



if(isset($_POST["submitButton"])){
    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $username = FormSanitizer::sanitizeFormUsername($_POST["userName"]);

    $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);
    $password1 = FormSanitizer::sanitizeFormPassword($_POST["password2"]);

    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);
    $email1 = FormSanitizer::sanitizeFormEmail($_POST["email2"]);

  $wasSuccessful = $account->register($firstName,$lastName,$username,$password,$password1,
  $email,$email1);
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
  <title>SignUp</title>
</head>
<body>

<div class="signInContainer">
<div class="column">
 <div class="header">
<img src="assets/icons/VideoTubeLogo.png">
<h3>SignUp</h3>
<span>To continue to MyYouTube</span>
 </div>
  <div class="loginForm">
   <form action="signUp.php" method="post">
     <?php echo $account->getError(Constants::$firstNameCharacters); ?>
      <input type="text" name="firstName" placeholder="First name" >
      <?php echo $account->getError(Constants::$lastNameCharacters); ?>
      <input type="text" name="lastName" placeholder="Last name" >
      <?php echo $account->getError(Constants::$usernameCharacters); ?>
      <?php echo $account->getError(Constants::$usernameTaken); ?>
      <input type="text" name="userName" placeholder="User name" >
      <?php echo $account->getError(Constants::$emailsDonnotMatch); ?>
      <input type="email" name="email" placeholder="Email" >
      <input type="email" name="email2" placeholder="Confirn email" >
      <?php echo $account->getError(Constants::$passwordDonnotMatch); ?>
      <?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
      <input type="password" name="password" placeholder="Password" >
      <input type="password" name="password2" placeholder="Confirn password" >
      <input type="submit" name="submitButton" value="submit">
   </form>

</div>
<a class="signInMessage" href="signIn.php">Already have account? Sign in here!</a>
</div>
</div>
</body>
</html>
