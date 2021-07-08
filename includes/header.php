<?php require_once("config.php"); ?>
<?php require_once("includes/Classes/User.php");
require_once("includes/classes/Video.php");

$usernameLoggedIn = isset($_SESSION['userLoggedIn']) ? $_SESSION['userLoggedIn'] : "";
$userLoggedObj = new User($con,$usernameLoggedIn);
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
  <title>My Youtube</title>
</head>
<body>
  <div id="pageContainer">

    <div id="mustHeadContainer">
    <button class="navShowHide"><img src="assets/icons/menu.png">
    </button>
    <a class="logoContainer" href="index.php" >
      <img src="assets/icons/VideoTubeLogo.png">
    </a>
      <div class="searchBarContainer">
        <form action="search.php" method="GET">
          <input type="text" name="term" class="searchBar" placeholder="search">
          <button class="searchButton" >
            <img src="assets/icons/search.png">
          </button>
        </form>
      </div>
      <div class="rightIcons">
        <a href="upload.php">
          <img class="upload"src="assets/icons/upload.png">
        </a>
        <a href="#">
          <img class="upload"src="assets/icons/default.png">
        </a>
      </div>
  </div>

    <div id="sideNavContainer" style="display:none"></div>

    <div id="mainSectionContainer">

      <div id="mainContentConteiner">
