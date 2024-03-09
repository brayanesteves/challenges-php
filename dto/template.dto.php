<?php
    class template {
        
        private $Rfrnc;
        private $Rfrnc_Usr;
        private $Cndtn;
        private $Rmvd;
        private $Lckd;
        private $DtAdmssn;
        private $ChckTm;

        public function __construct() { }

        public function setRfrnc($Rfrnc) {
            $this->Rfrnc = $Rfrnc;
        }
        public function getRfrnc() {
            return $this->Rfrnc;
        }

        public function setRfrnc_Usr($Rfrnc_Usr) {
            $this->Rfrnc_Usr = $Rfrnc_Usr;
        }
        public function getRfrnc_Usr() {
            return $this->Rfrnc_Usr;
        }

        // <DATAS> //
        // <.DATAS> //

        public function setCndtn($Cndtn) {
            $this->Cndtn = $Cndtn;
        }
        public function getCndtn() {
            return $this->Cndtn;
        }

        public function setRmvd($Rmvd) {
            $this->Rmvd = $Rmvd;
        }
        public function getRmvd() {
            return $this->Rmvd;
        }

        public function setLckd($Lckd) {
            $this->Lckd = $Lckd;
        }
        public function getLckd() {
            return $this->Lckd;
        }

        public function setDtAdmssn($DtAdmssn) {
            $this->DtAdmssn = $DtAdmssn;
        }
        public function getDtAdmssn() {
            return $this->DtAdmssn;
        }

        public function setChckTm($ChckTm) {
            $this->ChckTm = $ChckTm;
        }
        public function getChckTm() {
            return $this->ChckTm;
        }

    }
?>