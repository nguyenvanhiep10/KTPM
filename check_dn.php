<?php
    
session_start();
  include("connectdb.php");
  class capnhaptk{
    protected $tk;
    protected $mk;
    protected $duyet;

        // Getter và setter cho $tk
    public function getTk() {
        return $this->tk;
    }

    public function setTk($tk) {
        $this->tk = $tk;
    }

    // Getter và setter cho $mk
    public function getMk() {
        return $this->mk;
    }

    public function setMk($mk) {
        $this->mk = $mk;
    }

    // Getter và setter cho $duyet
    public function getDuyet() {
        return $this->duyet;
    }

    public function setDuyet($duyet) {
        $this->duyet = $duyet;
    }

    public function checkdn($check_username,$check_password,$check_duyet){
        if($this->tk == $check_username && $this->mk == $check_password && $check_duyet == "on"){
            return 0;
        }
        else if($this->tk == $check_username && $this->mk == $check_password && $check_duyet == "off"){
            return 1;
        }
        else {
          return 2;
        }
    }
  }
  $clcdn = new capnhaptk();
    if(isset($_POST["dangnhap"])){
      $clcdn->setTk($_POST["username"]);
      $clcdn->setMk($_POST["password"]);
      $username = $clcdn->getTk();
      $password = $clcdn->getMk();
      $sqlselect = "SELECT * FROM taikhoan";
      $check0 = 0;
      $result = mysqli_query($connect, $sqlselect);
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
          $check_username = $row["username"];
          $check_password = $row["password"];
          $check_duyet = $row["duyet"];
          if($clcdn->checkdn($check_username,$check_password,$check_duyet) == 0){
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $check0 = 1; 
            break;
          }
          elseif($clcdn->checkdn($check_username,$check_password,$check_duyet) == 1){
            $check0 = 2;
            break;
          }
        }      
      }
      if($check0 == 0){
        echo "<script>alert('Tài khoản hoặc mật khẩu không chính xác');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'dangnhap.html'; }, 0);</script>";  
      }
      elseif($check0 == 2){
        echo "<script>alert('Tài khoản chưa được duyệt');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 0);</script>";  
      }
      elseif($check0 == 1){
        header("Location:index.php");
      }
    }
?>