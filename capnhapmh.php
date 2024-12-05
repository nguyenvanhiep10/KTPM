<?php
    namespace App;

    use mysqli_sql_exception;

    class capnhapmh{
        protected $mmh;
        protected $mh;
        protected $tc;

            // Getter và setter cho $mmh
        public function getMmh() {
            return $this->mmh;
        }

        public function setMmh($mmh) {
            $this->mmh = $mmh;
        }

        // Getter và setter cho $mh
        public function getMh() {
            return $this->mh;
        }

        public function setMh($mh) {
            $this->mh = $mh;
        }

        // Getter và setter cho $tc
        public function getTc() {
            return $this->tc;
        }

        public function setTc($tc) {
            $this->tc = $tc;
        }

    }
    $clmh = new capnhapmh();
    include("connectdb.php");
    if(isset($_POST["btnthem"])){
        $clmh->setMmh($_POST["mamh"]);
        $clmh->setMh($_POST["mamh"]);
        $clmh->setTc($_POST["mamh"]);
        $mmh = $clmh->getMmh();
        $mh = $clmh->getMh();
        $tc = $clmh->getTc();
        $sql = "INSERT INTO `qlmonhoc` (`MAMH`, `TENMH`, `SOTINCHI`) VALUES ('$mmh', '$mh', '$tc')";
        try{
            mysqli_query($connect, $sql);
            echo "<script>alert('Thêm thành công');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qlmonhoc.php'; }, 0);</script>";
        }
        catch(mysqli_sql_exception)
        {
            echo "<script>alert('Mã môn học đã tồn tại');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qlmonhoc.php'; }, 0);</script>";
        }
    }
    elseif(isset($_POST['action'])) {
        $mamh = $_POST['mamh'];
        $action = $_POST['action'];
        
        if($action === 'Sửa') {
            $new_mh = $_POST['monhoc' . $mamh];
            $new_tc = $_POST['sotinchi' . $mamh];
            
            // Thực hiện truy vấn UPDATE để cập nhật thông tin
            $sql_update = "UPDATE qlmonhoc SET TENMH='$new_mh', SOTINCHI='$new_tc' WHERE MAMH='$mamh'";
            
            if(mysqli_query($connect, $sql_update)) {
                echo "Cập nhật thông tin thành công.";
            } else {
                echo "Lỗi: " . mysqli_error($connect);
            }
        } elseif($action === 'Xóa') {
            // Thực hiện truy vấn DELETE để xóa sinh viên
            $sql_delete = "DELETE FROM qlmonhoc WHERE MAMH='$mamh'";
            
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