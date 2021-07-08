<?php

//clasa koja stvara upload formu

class VideoDetalsFormProvider{

  private $con;
  public function __construct($con){
    $this->con=$con;
  }

  public function createUploadForm(){
    //pozivanje donjih privatnih metoda
    $fileInput =$this->createFileInput();
    $fileTitle=$this->createTitle();
    $fileDescription=$this->createDescription();
    $filePrivacy=$this->createPrivacyInput();
    $fileCategories= $this->createCategoriesInput();
    $fileButton= $this->createButton();
    return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
              $fileInput
              $fileTitle
              $fileDescription
              $filePrivacy
              $fileCategories
              $fileButton
            </form>";
  }
  private function createFileInput(){
  return  "<div class='mb-3'>
  <label for='formFile 'class='form-label'>Your file</label>
  <input class='form-control' type='file'name='fileInput' id='formFile'
  >
  </div>";
  }
  private function createTitle(){
    return "<div class='mb-3'>
  <input type='text' class='form-control mb-3' aria-label='Sizing example input' aria-describedby='inputGroup-sizing-sm'name='fileTitle' placeholder='title'>
</div>";
  }
  private function createDescription(){
    return "<div class='input-group input-group-sm mb-3'>
  <textarea class='form-control' name='fileDescription' placeholder='Description' rows='3'>
</textarea>
</div>";
  }
  private function createPrivacyInput(){
    return " <div class='input-group input-group-sm mb-3'>
    <select class='form-select' aria-label='Default select example' name='privacyInput'>

  <option value='0'>Public</option>
  <option value='1'>Private</option>
</select>
</div>";
  }
  private function createCategoriesInput(){
    //pozivanje iz baze categorija za youtube
    $query= $this->con->prepare("SELECT * FROM categories");
    $query->execute();
    //lista svih kategorija iz baze
    $html = "<div class='input-group input-group-sm mb-3'>
    <select class='form-select' aria-label='Default select example' name='categoriesInput'>";
    //za while je bitno da je true
    while($row  = $query->fetch(PDO::FETCH_ASSOC)){
      $name = $row["name"];
      $id  =$row["id"];
      $html.="<option value=$id>$name</option>";//??
    }
    $html.="</select>
    </div>";//???
    return $html;
  }
  private function createButton(){
    return"<button class='btn btn-primary' name='uploadBtn'>Upload</button>";
  }
}
 ?>
