<?php
require_once("includes/header.php");
require_once("includes/Classes/VideoUploadData.php");
require_once("includes/Classes/VideoProcessor.php");


if(!isset($_POST['uploadBtn'])){
  echo "Not file send to page!";
  exit();//zaustavljane php skrpte
}
//1) create upload file data
//pravljenje instance
$videoUploadData = new VideoUploadData($_FILES['fileInput'],
                                       $_POST['fileTitle'],
                                       $_POST['fileDescription'],
                                       $_POST['privacyInput'],
                                       $_POST['categoriesInput'],
                                       //"THIS-REPLACE"
                                       $userLoggedObj->getUserName()
                                     );

// 2 processing video data upload

$videoProcessor = new VideoProcessor($con);
$wasSucessful=$videoProcessor->upload($videoUploadData);//funkcija za upload, a parametri su sacuvani u gornjoj istanci

// 3 check if upload is successful

if($wasSucessful){
  echo "Upload successful";
}
 ?>





 <?php
 require_once("includes/footer.php"); ?>
