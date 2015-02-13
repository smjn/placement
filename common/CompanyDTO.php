<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	class CompanyDTO{
		private $m_id;
		private $m_name;
		private $m_location;
		private $m_status;
		private $m_pass;
		private $m_addedOn;
		private $m_addedBy;
		
		public function setCompanyId($aId){
			$this->m_id = $aId;
		}
		
		public function getCompanyId(){
			return $this->m_id;
		}
		
		public function setName($aName){
			$this->m_name = $aName;
		}
		
		public function getName(){
			return $this->m_name;
		}
		
		public function setLocation($aLocation){
			$this->m_location = $aLocation;
		}
		
		public function getLocation(){
			return $this->m_location;
		}
		
		public function setStatus($aStatus){
			$this->m_status = $aStatus;
		}
		
		public function getStatus(){
			return $this->m_status;
		}
		
		public function setPassword($aPass){
			$this->m_pass = $aPass;
		}
		
		public function getPassword(){
			return $this->m_pass;
		}
						
		public function setAddedOn($aAddedOn){
			$this->m_addedOn = $aAddedOn;
		}
		
		public function getAddedOn(){
			return $this->m_addedOn;
		}
		
		public function setAddedBy($aAddedBy){
			$this->m_addedBy = $aAddedBy;
		}
		
		public function getAddedBy(){
			return $this->m_addedBy;
		}
	}
?>
