<?php
    namespace App;

    use mysqli_sql_exception;

    use DateTime;

    class capnhapsv{
        protected $msv;
        protected $ht;
        protected $ngay;
        protected $gt;
        protected $mk;
        protected $kh;

         // Getter và setter cho $msv
        public function getMsv() {
            return $this->msv;
        }

        public function setMsv($msv) {
            $this->msv = $msv;
        }

        // Getter và setter cho $ht
        public function getHt() {
            return $this->ht;
        }

        public function setHt($ht) {
            $this->ht = $ht;
        }

        // Getter và setter cho $ngay
        public function getNgay() {
            return $this->ngay;
        }

        public function setNgay($ngay) {
            $this->ngay = $ngay;
        }

        // Getter và setter cho $gt
        public function getGt() {
            return $this->gt;
        }

        public function setGt($gt) {
            $this->gt = $gt;
        }

        // Getter và setter cho $mk
        public function getMk() {
            return $this->mk;
        }

        public function setMk($mk) {
            $this->mk = $mk;
        }

        // Getter và setter cho $kh
        public function getKh() {
            return $this->kh;
        }

        public function setKh($kh) {
            $this->kh = $kh;
        }

        function isValidDateOfBirth( $format = 'Y-m-d') {
            $dateTime = DateTime::createFromFormat($format, $this->ngay);
            if ($dateTime && $dateTime->format($format) === $this->ngay) {
                // Kiểm tra ngày sinh không được sau ngày hiện tại
                $today = new DateTime();
                if ($dateTime <= $today) {
                    return "Pass"; // Pass kiểm tra ngày và ngày sinh hợp lệ
                }
            }
            return "Fail"; // Fail kiểm tra ngày hoặc ngày sinh không hợp lệ
        }
    }
    $clsv = new capnhapsv();

    
    include("connectdb.php");
    if(isset($_POST["btnthem"])){
        $clsv -> setMsv($_POST["masv"]);
        $clsv -> setHt($_POST["hoten"]);
        $clsv -> setNgay($_POST["date"]);
        $clsv -> setGt($_POST["gt"]);
        $clsv -> setMk($_POST["khoa"]);
        $clsv -> setKh($_POST["khoahoc"]);

        $msv = $clsv ->getMsv();
        $ht = $clsv ->getMsv();
        $ngay = $clsv ->getMsv();
        $gt =$clsv ->getMsv();
        $mk = $clsv ->getMsv();
        $kh = $clsv ->getMsv();
        $sql = "INSERT INTO `qlsinhvien` (`MASV`, `MAK`, `khoahoc`, `HOTEN`, `NGAYSINH`, `GIOITINH`) VALUES ('$msv', '$mk', '$kh', '$ht', '$ngay', '$gt')";
        try{
            mysqli_query($connect, $sql);
            echo "<script>alert('Thêm thành công');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qlsinhvien.php'; }, 0);</script>";
        }
        catch(mysqli_sql_exception)
        {
            echo "<script>alert('Mã sinh viên đã tồn tại');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qlsinhvien.php'; }, 0);</script>";
        }
       
    }
    elseif(isset($_POST['action'])) {
        $masv = $_POST['masv'];
        $action = $_POST['action'];
        
        if($action === 'Sửa') {
            $new_hoten = $_POST['hoten' . $masv];
            $new_ngaysinh = $_POST['ngaysinh' . $masv];
            $new_gioitinh = $_POST['gt' . $masv];
            $new_khoa = $_POST['khoa' . $masv];
            $new_khoahoc = $_POST['kh' . $masv];
            
            // Thực hiện truy vấn UPDATE để cập nhật thông tin
            $sql_update = "UPDATE qlsinhvien SET HOTEN='$new_hoten', NGAYSINH='$new_ngaysinh', GIOITINH='$new_gioitinh', MAK='$new_khoa', khoahoc='$new_khoahoc' WHERE MASV='$masv'";
            
            if(mysqli_query($connect, $sql_update)) {
                echo "Cập nhật thông tin thành công.";
            } else {
                echo "Lỗi: " . mysqli_error($connect);
            }
        } elseif($action === 'Xóa') {
            // Thực hiện truy vấn DELETE để xóa sinh viên
            $sql_delete = "DELETE FROM qlsinhvien WHERE MASV='$masv'";
            
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