<?php
	class JafDTO{
		private $m_pos;
		private $m_jid;
		private $m_cid;
		private $m_dept;
		private $m_cgpa;
		private $m_disc;
		private $m_cname;
		
		public function setPosition($aPos){
			$this->m_pos = $aPos;
		}
		
		public function getPosition(){
			return $this->m_pos;
		}
		
		public function setJafId($aId){
			$this->m_jid = $aId;
		}
		
		public function getJafId(){
			return $this->m_jid;
		}
		
		public function setCompanyId($aId){
			$this->m_cid = $aId;
		}
		
		public function getCompanyId(){
			return $this->m_cid;
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
		
		public function setCompanyName($aCName){
			$this->m_cname = $aCName;
		}
		
		public function getCompanyName(){
			return $this->m_cname;
		}
	}
?>
