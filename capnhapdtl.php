<?php
    namespace App;

    class capnhapdtl{
        protected $diemtll;
        protected $masvv1;
        protected $xeploaii;
        // Getter và setter cho $diemtll
        public function getDiemtll() {
            return $this->diemtll;
        }

        public function setDiemtll($diemtll) {
            $this->diemtll = $diemtll;
        }

        // Getter và setter cho $masvv1
        public function getMasvv1() {
            return $this->masvv1;
        }

        public function setMasvv1($masvv1) {
            $this->masvv1 = $masvv1;
        }

        // Getter và setter cho $xeploaii
        public function getXeploaii() {
            return $this->xeploaii;
        }

        public function setXeploaii($xeploaii) {
            $this->xeploaii = $xeploaii;
        }
        function ktdiemc(){
            if($this->diemtll >= 0 && $this->diemtll < 4){
                return "Kém";
            }
            elseif($this->diemtll >= 4 && $this->diemtll < 5){
                return "Yếu";
            }
            elseif($this->diemtll >= 5 && $this->diemtll < 7){
                return "Trung bình";
            }
            elseif($this->diemtll >= 7 && $this->diemtll < 8){
                return "Khá";
            }
            elseif($this->diemtll >=8 && $this->diemtll < 9){
                return "Giỏi";
            }
            elseif($this->diemtll >=9 && $this->diemtll <=10){
                return"Xuất sắc";
            }
            else{
                return"Ero";
            }

        }
    }

    $cndiemtl = new capnhapdtl();
        include("connectdb.php");
    $sqlselect = "SELECT * FROM `qlsinhvien`";
    $result = mysqli_query($connect, $sqlselect);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $masvv = $row["MASV"];
            $sqlselect1 = "SELECT qldiem.MASV,(SUM(SOTINCHI*TBCHP)/SUM(SOTINCHI)) AS diemtl 
            FROM qldiem,qlmonhoc 
            WHERE MASV = '$masvv' AND qldiem.MAMH = qlmonhoc.MAMH";
            $result1 = mysqli_query($connect, $sqlselect1);
            if(mysqli_num_rows($result1) > 0){
                while($row = mysqli_fetch_assoc($result1)){
                    $cndiemtl->setDiemtll($row["diemtl"]);
                    $cndiemtl->setMasvv1($row["MASV"]);
                    $cndiemtl->setXeploaii($cndiemtl->ktdiemc());
                    $diemtll = $cndiemtl->getDiemtll();
                    $masvv1 = $cndiemtl->getMasvv1();
                    $xeploaii = $cndiemtl->getXeploaii();
                    $sql_update = "UPDATE `qlsinhvien` SET `TBCHT`='$diemtll',`XEPLOAI`='$xeploaii' WHERE MASV = '$masvv1'";
                    $result2 = mysqli_query($connect,$sql_update);
                }
            }
        }
    }
    
    
            mysqli_close($connect); 
?>
