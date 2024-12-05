<?php
    namespace App;

    use mysqli_sql_exception;

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
    $cltk = new capnhaptk();


    include("connectdb.php");
    if(isset($_POST["btnthem"])){
        $cltk ->setTk($_POST["taikhoan"]);
        $cltk ->setMk($_POST["matkhau"]);
        $cltk ->setDuyet($_POST["duyet"]);
        $mmh = $cltk->getTk();
        $mh = $cltk->getMk();
        $tc = $cltk->getDuyet();
        $sql = "INSERT INTO `taikhoan`(`username`, `password`, `duyet`) VALUES ('$mmh','$mh','$tc')";
        try{
            mysqli_query($connect, $sql);
            echo "<script>alert('Thêm thành công');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qltaikhoan.php'; }, 0);</script>";
        }
        catch(mysqli_sql_exception)
        {
            echo "<script>alert('tài khoản đã tồn tại');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qltaikhoan.php'; }, 0);</script>";
        }
    }
    elseif(isset($_POST['action'])) {
        $mamh = $_POST['taikhoan'];
        $action = $_POST['action'];
        
        if($action === 'Sửa') {
            $new_mh = $_POST['matkhau' . $mamh];
            $new_tc = $_POST['duyet' . $mamh];
            
            // Thực hiện truy vấn UPDATE để cập nhật thông tin
            $sql_update = "UPDATE `taikhoan` SET`password`='$new_mh',`duyet`='$new_tc' WHERE  `username`='$mamh'";
            
            if(mysqli_query($connect, $sql_update)) {
                echo "Cập nhật thông tin thành công.";
            } else {
                echo "Lỗi: " . mysqli_error($connect);
            }
        } elseif($action === 'Xóa') {
            // Thực hiện truy vấn DELETE để xóa sinh viên
            $sql_delete = "DELETE FROM `taikhoan` WHERE username ='$mamh'";
            
            if(mysqli_query($connect, $sql_delete)) {
                echo "Xóa thông tin thành công.";
            } else {
                echo "Lỗi: " . mysqli_error($connect);
            }
        }
        header("Location:".$_POST["tranght"]);
    }                   
    mysqli_close($connect);
    
?>