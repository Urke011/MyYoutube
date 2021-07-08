<?php
require_once("includes/header.php");
require_once("includes/Classes/VideoDetalsFormProvider.php");
 ?>



        <div class="column">
      <?php
      //pozivanje upload forme
      $formProvider = new VideoDetalsFormProvider($con);
      echo $formProvider->createUploadForm();

      ?>

        </div>




    <?php if(isset($_POST['uploadBtn'])): ?>    <!-- Vertically centered modal -->
<div class="modal-dialog modal-dialog-centered">
  Please wait this might take a while...
  <img src="assets/icons/loading-spinner.gif">
</div>
<!-- trbalo bi js ali ni sa php ne radi ne znam -->
<?php endif; ?>



<?php
require_once("includes/footer.php"); ?>
