<?php
    
    namespace App;

    use mysqli_sql_exception;
    class capnhapd 
    {
        protected $DIEMCC;
        protected $DIEMGK;
        protected $LANHOC;
        protected $LANTHI;
        protected $DTHI;
        protected $TBCHP;
        protected $DCHU;
        protected $NOTE;

            // Getter và setter cho $DIEMCC
        public function getDIEMCC() {
            return $this->DIEMCC;
        }

        public function setDIEMCC($DIEMCC) {
            $this->DIEMCC = $DIEMCC;
        }

        // Getter và setter cho $DIEMGK
        public function getDIEMGK() {
            return $this->DIEMGK;
        }

        public function setDIEMGK($DIEMGK) {
            $this->DIEMGK = $DIEMGK;
        }

        // Getter và setter cho $LANHOC
        public function getLANHOC() {
            return $this->LANHOC;
        }

        public function setLANHOC($LANHOC) {
            $this->LANHOC = $LANHOC;
        }

        // Getter và setter cho $LANTHI
        public function getLANTHI() {
            return $this->LANTHI;
        }

        public function setLANTHI($LANTHI) {
            $this->LANTHI = $LANTHI;
        }

        // Getter và setter cho $DTHI
        public function getDTHI() {
            return $this->DTHI;
        }

        public function setDTHI($DTHI) {
            $this->DTHI = $DTHI;
        }

        // Getter và setter cho $TBCHP
        public function getTBCHP() {
            return $this->TBCHP;
        }

        public function setTBCHP($TBCHP) {
            $this->TBCHP = $TBCHP;
        }

        // Getter và setter cho $DCHU
        public function getDCHU() {
            return $this->DCHU;
        }

        public function setDCHU($DCHU) {
            $this->DCHU = $DCHU;
        }

        // Getter và setter cho $NOTE
        public function getNOTE() {
            return $this->NOTE;
        }

        public function setNOTE($NOTE) {
            $this->NOTE = $NOTE;
        }

        public function tinhTBCHP(){
            $DTBCHP = ($this->DIEMCC/100)*10 + ($this->DIEMGK/100)*20 + ($this->DTHI/100)*70;
            return $DTBCHP;
        }

        public function ktdiemc(){
            if($this->TBCHP >= 0 && $this->TBCHP < 4){
                return "F";
            }
            elseif($this->TBCHP >= 4 && $this->TBCHP <= 5.4){
                return "D";
            }
            elseif($this->TBCHP > 5.4 && $this->TBCHP < 7){
                return "C";
            }
            elseif($this->TBCHP >= 7 && $this->TBCHP <= 8.4){
                return "B";
            }
            elseif($this->TBCHP >8.4 && $this->TBCHP <= 10){
                return "A";
            }
            else{
                return"Lỗi nhập điểm";
            }
        }
    }
    $cldiem = new capnhapd();
   
    include("connectdb.php");
    if(isset($_POST["btnthem"])){
        $khoa = $_POST["khoa"];
        $kh = $_POST["khoahoc"];
        $mh = $_POST["monh"];
        
        $sqlselect = "SELECT `MASV` FROM `qlsinhvien` WHERE MAK = '".$khoa."' AND khoahoc = '". $kh ."'";
        $result = mysqli_query($connect, $sqlselect);
        try{
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $masv0 = $row["MASV"];
                    $iddiem = $masv0 ."". $mh;
                    $sql = "INSERT INTO `qldiem`(`IDDIEM`, `MASV`, `MAMH`) VALUES ('".$iddiem."','".$masv0."','".$mh."')";
                    mysqli_query($connect, $sql);
                }
            }
            echo "<script>alert('Thêm thành công');</script>";
            echo "<script>setTimeout(function(){ window.location.href = 'qldiem.php'; }, 0);</script>"; 
        }
        catch(mysqli_sql_exception){
            echo "<script>alert('Mã môn học đã tồn tại');</script>";            
            echo "<script>setTimeout(function(){ window.location.href = 'qldiem.php'; }, 0);</script>";       
        }
        
    }
    elseif(isset($_POST['action'])) {
        $iddiem = $_POST['iddiem'];
        $action = $_POST['action'];
        
        if($action === 'Sửa') {
            $cldiem->setDIEMCC($_POST["diemcc"]);
            $cldiem->setDIEMGK($_POST["diemgk"]);
            $cldiem->setLANHOC($_POST["lanhoc"]);
            $cldiem->setLANTHI($_POST["lanthi"]);
            $cldiem->setDTHI($_POST["dthi"]);
            $cldiem->setTBCHP($cldiem->tinhTBCHP());
            $cldiem->setDCHU($cldiem->ktdiemc());
            $cldiem->setNOTE($_POST["note"]);
            $DIEMCC = $cldiem->getDIEMCC();
            $DIEMGK = $cldiem->getDIEMGK();
            $LANHOC= $cldiem->getLANHOC();
            $LANTHI = $cldiem->getLANTHI();
            $DTHI = $cldiem->getDTHI();
            $TBCHP = $cldiem->getTBCHP();
            $DCHU = $cldiem->getDCHU();
            $NOTE = $cldiem->getNOTE();
            
            // Thực hiện truy vấn UPDATE để cập nhật thông tin
            $sql_update = "UPDATE `qldiem` 
            SET `DIEMCC`='$DIEMCC',`DIEMGK`='$DIEMGK',`LANHOC`='$LANHOC',`LANTHI`='$LANTHI',
            `DTHI`='$DTHI',`TBCHP`='$TBCHP',`DCHU`='$DCHU',`NOTE`='$NOTE' WHERE IDDIEM = '$iddiem'";
            
            if(mysqli_query($connect, $sql_update)) {
                echo "Cập nhật thông tin thành công.";
            } else {
                echo "Lỗi: " . mysqli_error($connect);
            }
        } elseif($action === 'Xóa') {
            // Thực hiện truy vấn DELETE để xóa sinh viên
            $sql_delete = "DELETE FROM `qldiem` WHERE IDDIEM = '$iddiem'";         
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