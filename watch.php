<?php
require_once("includes/header.php");

require_once("includes/classes/VideoPlayer.php");
//uzimamo id za prikazivanje videa
if(!isset($_GET['id'])){
  echo "No url passed into page";
  exit();
}
//instanca
$video = new Video($con,$_GET['id'],$userLoggedObj);
//echo $video->getTitle();
$video->incrementViews();
?>

<div class="watchLeftColumn">
    <?php $videoPlayer = new VideoPlayer($video);
          echo $videoPlayer->create(true);?>
</div>
<div class="suggestions">
  
</div>

<?php
require_once("includes/footer.php"); ?>
