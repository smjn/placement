<?php
	class LoginDTO{
		private $m_user;
		private $m_pass;
		private $m_loginAs;
		
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
		
		public function getLoginAs(){
			return $this->m_loginAs;
		}
		
		public function setLoginAs($aLoginAs){
			$this->m_loginAs = $aLoginAs;
		}
		
		public function __toString(){
			$data = array("Username"=>$this->getUsername(),"Password"=>$this->getPassword(), "LoginAs"=>$this->getLoginAs());
			$debugString = "";
			foreach($data as $key=>$value){
				$debugString = $debugString.$key.":".$value.",";
			}
			return $debugString;
		}
	}
?>
