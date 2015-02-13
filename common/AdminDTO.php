<?php
	class AdminDTO{
		private $m_user;
		private $m_pass;
		private $m_id;
		
		public function getUsername(){
			return $this->m_user;
		}
		
		public function setUsername($aUser){
			$this->m_user = $aUser;
		}
		
		public function getPassword(){
			return $this->m_pass;
		}
		
		public function setPassword($aPass){
			$this->m_pass = $aPass;
		}
		
		public function setAdminId($aId){
			$m_id = $aId;			
		}
		
		public function getAdminId(){
			return $m_id;
		}
		
		public function __toString(){
			$data = array("Username"=>$this->getUsername(),"Password"=>$this->getPassword(), "AdminId"=>$this->getAdminId());
			$debugString = "";
			foreach($data as $key=>$value){
				$debugString = $debugString.$key.":".$value.",";
			}
			return $debugString;
		}
	}
?>
