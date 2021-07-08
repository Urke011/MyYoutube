<?php

  class Account{
        private $con;
        private $errorArray = array();
    public function __construct($con){
      $this->con = $con;
    }
    public function login($username,$password){
        $password = hash("sha512",$password);
        $query=$this->con->prepare("SELECT * FROM users
                        WHERE username = :username AND password = :password");//zasto ne ==
        $query->bindParam(":username",$username);
        $query->bindParam(":password",$password);
        $query->execute();
        if($query->rowCount() == 1){
          return true;
        }else {
          array_push($this->errorArray,Constants::$loginFaild);
          return false;
        }

    }

    public function register($firstName,$lastName,$username,$password,$password1,
    $email,$email1){
        $this->validateFirstName($firstName);
        $this->validateLastName($lastName);
        $this->validateUserName($username);
        $this->validateEmails($email,$email1);
        $this->validatePassword($password,$password1);
        //ako je sve ok registruj
        if(empty($this->errorArray)){
          return $this->insertUserDetails($firstName,$lastName,$username,$email,$password);
        }else {
          return false;
        }
      }
      public function insertUserDetails($firstName,$lastName,$username,$email,$password){
          //return true;
          $password = hash("sha512",$password);
          //bas i nije jasno apsol i relativ putanja
          $profilePic ="assets/icons/default.png";

          $query= $this->con->prepare("INSERT INTO users (firstName,lastName,username,email,password,profilePic)
              VALUES(:firstName,:lastName,:username,:email,:password,:pic)");
        $query->bindParam(":firstName",$firstName);
        $query->bindParam(":lastName",$lastName);
        $query->bindParam(":username",$username);
        $query->bindParam(":email",$email);
        $query->bindParam(":password",$password);
        $query->bindParam(":pic",$profilePic);
        return $query->execute();
      }
    private function validateFirstName($firstName){
      if(strlen($firstName)>25 || strlen($firstName)<2){
        array_push($this->errorArray, Constants::$firstNameCharacters);
      }
    }
    private function validateLastName($lastName){
      if(strlen($lastName)>25 || strlen($lastName)<2){
        array_push($this->errorArray, Constants::$lastNameCharacters);
      }
    }
      private function validateUserName($username){
        if(strlen($username)>25 || strlen($username)<5){
          array_push($this->errorArray, Constants::$usernameCharacters);
          return;
        }
        $query = $this->con->prepare("SELECT username FROM users WHERE username = :username");
        $query->bindParam(":username",$username);
        $query->execute();
        if($query->rowCount() !=0 ){
          array_push($this->errorArray, Constants::$usernameTaken);
        }
      }
      private function validateEmails($email,$email1){
        if($email != $email1){
          array_push($this->errorArray, Constants::$emailsDonnotMatch);
          return;
        }
        $query = $this->con->prepare("SELECT username FROM users WHERE username = :username");
        $query->bindParam(":username",$username);
        $query->execute();
        if($query->rowCount() !=0 ){
          array_push($this->errorArray, Constants::$usernameTaken);
        }
      }
      private function validatePassword($password,$password1){
        if($password != $password1){
          array_push($this->errorArray, Constants::$passwordDonnotMatch);
          return;
        }
        //zadnji mislim da ne radi
        if(preg_match("/[^A-Za-z0-9]/",$password)){
          array_push($this->errorArray, Constants::$passwordNotAlphaNumeric);
          return;
        }
      }
    public function getError($error){
      if(in_array($error,$this->errorArray)){
        return "<span class='errorMessage'>$error</span>";
      }
    }
  }

 ?>
