<?php
      class User{

        private $con;
        private $sqlData;
        public function __construct($con,$username){
            $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM users WHERE username = :user");
        $query->bindParam(":user",$username);
        $query->execute();
        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
        }
        public function getUserName(){
          return $this->sqlData['username'];
        }
        public function getName(){
          return $this->sqlData['firstName'] ." ". $this->sqlData['lastName'];
        }
        public function getFirstName(){
          return $this->sqlData['firstName'];
        }
        public function getLastName(){
          return $this->sqlData['lastName'];
        }
        public function getEmail(){
          return $this->sqlData['email'];
        }
        public function getProfilPic(){
          return $this->sqlData['profilePic'];
        }
        public function getSignUpDate(){
          return $this->sqlData['signupDate'];
        }
      }



 ?>
