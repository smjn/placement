<?php
	include_once "StudentDTO.php";
	
	class PlacedStudentDTO extends StudentDTO{
		private $m_pos;
		private $m_companyName;
		
		public function setPosition($aPos){
			$this->m_pos = $aPos;			
		}
		
		public function getPosition(){
			return $this->m_pos;
		}
		
		public function setCompanyName($aName){
			$this->m_companyName = $aName;
		}
		
		public function getCompanyName(){
			return $this->m_companyName;
		}			
	}
?>
