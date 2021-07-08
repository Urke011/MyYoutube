<?php
      class Video{

        private $con;
        private $sqlData;
        private $userLoggedObj;
        public function __construct($con,$input,$userLoggedObj){
            $this->con = $con;
            $this->userLoggedObj = $userLoggedObj;
        //ako je niz
        if(is_array($input)){
          $this->sqlData  = $input;
        }else {//ako je id
          $query = $this->con->prepare("SELECT * FROM videos WHERE id = :id");
          $query->bindParam(":id",$input);//od gornjeg parametra
          $query->execute();
          $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);

      }
        }
        public function getId(){
          return $this->sqlData['id'];
        }
        public function getUploadedBy(){
          return $this->sqlData['uploadedBy'];
        }
        public function getTitle(){
          return $this->sqlData['title'];
        }
        public function getDescription(){
          return $this->sqlData['description'];
        }
        public function getPrivacy(){
          return $this->sqlData['privacy'];
        }
        public function getFilePath(){
          return $this->sqlData['filePath'];
        }
        public function getCategory(){
          return $this->sqlData['category'];
        }
        public function getUploadDate(){
          return $this->sqlData['uploadDate'];
        }
        public function getViews(){
          return $this->sqlData['views'];
        }
        public function getDuration(){
          return $this->sqlData['duration'];
        }
        //funkcija za brojanje pregleda
        public function incrementViews(){
          $query=$this->con->prepare("UPDATE videos SET views = views+1    WHERE id = :id");
          $query->bindParam(":id",$videoId);
          $videoId = $this->getId();
          $query->execute();
          //povecavanje broja u samoj sql koloni
          $this->sqlData['views'] = $this->sqlData['views'] +1;

        }
      }



 ?>
