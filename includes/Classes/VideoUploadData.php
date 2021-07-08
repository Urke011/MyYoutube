<?php

    class VideoUploadData{

      public $videoDataArray,$title,$description,$privacy,$category,
      $uploadedBy;
    //ovde se prihvata sve sto dolazi iz upload forme
      public function __construct($videoDataArray,$title,$description,$privacy,$category,$uploadedBy){
            $this->videoDataArray=$videoDataArray;
            $this->title=$title;
            $this->description=$description;
            $this->privacy=$privacy;
            $this->category=$category;
            $this->uploadedBy=$uploadedBy;
      }
    }
 ?>
