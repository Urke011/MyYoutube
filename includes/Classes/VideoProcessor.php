<?php

  class VideoProcessor{

    private $con;
    private $sizeLimit = 500000000;//500mb
    private $allowedTypes = array("webm","flv","vob","mng","avi","mov","wmv","mpeg","mp4");
    private  $ffmpeg;
    private $ffprobe;


    public function __construct($con){
      $this->con=$con;
      $this->ffmpeg= realpath("ffmpeg/windows/ffmpeg.exe");// apsolutna i relatvna putanja
      $this->ffprobe= realpath("ffmpeg/windows/ffprobe.exe");

    }

    public function upload($videoUploadData){
      //ovde ce se video cuvati
      $targetDir="includes/uploads/videos/";
      //pozivanje varijabli onako??
      $videoData = $videoUploadData->videoDataArray;
      //fajl koji se uploduje prvo se mora konvertovati
      $tmpFilePath = $targetDir.uniqid().basename($videoData["name"]);
    //uploads/videos/jsajjajsj343536dogsplaying.flv
     $tmpFilePath = str_replace(" ","_",$tmpFilePath);//ciscenje razmaka
     $isValidData = $this->proccesData($videoData,$tmpFilePath);//dva parametra
     //echo $tmpFilePath;
     if(!$isValidData){
       return false;
     }
     //prebacivane fajla na host
     if(move_uploaded_file($videoData["tmp_name"],$tmpFilePath)){
        //echo "File moved successful";
        $finalFilePath = $targetDir . uniqid() .".mp4";
        if(!$this->insertVideoData($videoUploadData,$finalFilePath)){
          echo "Insert query faild";
          return false;
        }
        if(!$this->convertVideoToMp4($tmpFilePath,$finalFilePath)){
          echo "Upload faild";
          return false;
        }
        if(!$this->deleteFile($tmpFilePath)){
          echo "Upload faild";
          return false;
        }
        if(!$this->generatThumbnails($finalFilePath)){
          echo "Upload faild - could generate thumbnails";
          return false;
        }
        return true;
     }
    }
    private function proccesData($videoData,$filePath){
        $videoType = pathInfo($filePath, PATHINFO_EXTENSION);//??

        //provera velicine
        if(!$this->isValidSize($videoData)){
          echo "File is too large!";
          return false;
        }elseif (!$this->isValidType($videoType)) {
          echo "Invalid file type!";
          return false;
        }
        elseif ($this->hasError($videoData)) {
          echo "Error code: " . $videoData['error'];
          return false;
        }
      return true;//prouciti
    }
    private function isValidSize($data){
        return $data['size'] <= $this->sizeLimit;
        //provera velicina fajla
    }
    private function isValidType($type){
        $lowercases = strtolower($type);//konvertovanje u mala slova
        return in_array($lowercases, $this->allowedTypes);
        //da li je poslata dozvoljen tip videa
    }
    private function hasError($data){
      return $data['error'] != 0;
    }
    private function insertVideoData($uploadData,$filePath){
        $query= $this->con->prepare("INSERT INTO videos(title,uploadedBy,description,privacy,category,filePath)
        VALUES(:title,:uploadedBy,:description,:privacy,:category,:filePath)");
        $query->bindParam(":title",$uploadData->title);
        $query->bindParam(":uploadedBy",$uploadData->uploadedBy);
        $query->bindParam(":description",$uploadData->description);
        $query->bindParam(":privacy",$uploadData->privacy);
        $query->bindParam(":category",$uploadData->category);
        $query->bindParam(":filePath",$filePath);
        return $query->execute();
    }
    public function convertVideoToMp4($tmpFilePath,$finalFilePath){
        //fajl za konvert putanja
        $cmd="$this->ffmpeg -i $tmpFilePath $finalFilePath 2>&1";
        //fajl kojo hocemo da konvertujemo i u sta da konvertujemo

        $outPutLog= array();
        exec($cmd,$outPutLog,$returnCode);
        //funkcija za izvrsenje koda.
        //drugi parameta skuplja greske a treci obavestava da li je true ili false
        if($returnCode != 0){
            foreach($outPutLog as $line){
              echo $line . "<br />";
            }
            return false;
        }
        return true;
    }
    private function deleteFile($filePath){
      if(!unlink($filePath)){
        //samo brise fajl
        echo "Could not delete file!";
        return false;
      }
      return true;
    }
    public function generatThumbnails($filePath){
        $thumbnailsSize = "210x118";
        $numThumbnails = 3;
        $pathToThumbnails = "includes/uploads/videos/thumbnails/";

        $duration = $this->getVideoDuration($filePath);
        //echo "Duration: ". $duration;
        $videoId = $this->con->lastInsertId();
        $this->updateDuration($duration, $videoId);

        for($num = 1; $num<=$numThumbnails;$num++){
            $imageName = uniqid() . ".jpg";
            $interval = ($duration * 0.8) / $numThumbnails * $num;
            $fullThumbnailPath = "$pathToThumbnails/$videoId=$imageName";
            $cmd ="$this->ffmpeg -i $filePath -ss $interval -s $thumbnailsSize -vframes 1 $fullThumbnailPath 2>&1";

            $outPutLog= array();
            exec($cmd,$outPutLog,$returnCode);

            if($returnCode != 0){
                foreach($outPutLog as $line){
                  echo $line . "<br />";
                }
            }
            $query =$this->con->prepare("INSERT INTO thumbnails (videoId,filePath,selected)
            VALUES(:videoId,:filePath,:selected)");
            $query->bindParam(":videoId",$videoId);
            $query->bindParam(":filePath",$fullThumbnailPath);
            $query->bindParam(":selected",$selected);
            $selected = $num ==1 ? 1 :0;
            $success = $query->execute();
            if(!$success){
              echo "Error inserting thumbnails \n";
              return false;
            }

        }
        return true;
    }
    private function getVideoDuration($filePath){
      return (int)shell_exec("$this->ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 $filePath");
    }
    private function updateDuration($duration, $videoId){
      //$duration = (int)$duration;
      //echo "Duration before conversion: $duration";
          $hours = floor($duration / 3600);
          $minus = floor(($duration -($hours * 3600)) / 60);
          $secs = floor($duration % 60);

          $hours =($hours<1) ? "" : $hours . ":";
          $minus =($minus<10) ? "0" . $minus . ":"  : $minus . ":";
          $secs =($secs<10) ? "0" .$secs  : $secs;
          $duration = $hours.$minus.$secs;
          $query = $this->con->prepare("UPDATE videos SET duration=:duration WHERE id=:videoId");
          $query->bindParam(":duration",$duration);
          $query->bindParam(":videoId",$videoId);
          $query->execute();
    }
  }

 ?>
