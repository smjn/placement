<?php
	class StudentDTO{
		private $m_name;
		private $m_rollNo;
		private $m_dept;
		private $m_disc;
		private $m_cgpa;
		private $m_isDpc;
		private $m_isRegistered;
		private $m_isPlaced;
		private $m_pass;
		
		public function setName($aName){
			$this->m_name = $aName;
		}
		
		public function getName(){
			return $this->m_name;
		}
		
		public function setRollNo($aRollNo){
			$this->m_rollNo = $aRollNo;
		}
		
		public function getRollNo(){
			return $this->m_rollNo;
		}
		
		public function setDepartment($aDept){
			$this->m_dept = $aDept;
		}
		
		public function getDepartment(){
			return $this->m_dept;
		}
		
		public function setDiscipline($aDisc){
			$this->m_disc = $aDisc;
		}
		
		public function getDiscipline(){
			return $this->m_disc;
		}
		
		public function setCgpa($aCgpa){
			$this->m_cgpa = $aCgpa;
		}
		
		public function getCgpa(){
			return $this->m_cgpa;
		}
		
		public function setIsDpc($aIsDpc){
			$this->m_isDpc = $aIsDpc;
		}
		
		public function getIsDpc(){
			return $this->m_isDpc;
		}
		
		public function setIsRegistered($aIsRegistered){
			$this->m_isRegistered = $aIsRegistered;
		}
		
		public function getIsRegistered(){
			return $this->m_isRegistered;
		}
		
		public function setIsPlaced($aIsPlaced){
			$this->m_isPlaced = $aIsPlaced;
		}
		
		public function getIsPlaced(){
			return $this->m_isPlaced;
		}
		
		public function setPassword($aPass){
			$this->m_pass = $aPass;
		}
		
		public function getPassword(){
			return $this->m_pass;
		}
	}
?>
