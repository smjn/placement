<?php
	include_once "../tier3/AdminDAO.php";
	include_once "../tier3/DPCDAO.php";
	include_once "../tier3/StudentDAO.php";
	include_once "../tier3/CompanyDAO.php";
	include_once "../common/AdminDTO.php";
	include_once "../common/LoginDTO.php";
	include_once "../common/StudentDTO.php";
	include_once "../common/CompanyDTO.php";
		
	class LoginBL{
		private static $_instance = NULL;
		
		private function __construct(){
		}
		
		public static function getInstance(){			
			if(self::$_instance == NULL){
				self::$_instance = new LoginBL();
			}
			return self::$_instance;				
		}
		
		public function authenticate($aLoginDTO){
			if(!strcmp($aLoginDTO->getLoginAs(),"admin")){
				$adminDTO = new AdminDTO();
				$adminDTO->setUsername($aLoginDTO->getUsername());
				$adminDTO->setPassword($aLoginDTO->getPassword());
								
				return AdminDAO::authenticate($adminDTO);
			}
			if(!strcmp($aLoginDTO->getLoginAs(),"dpc")){
				$studentDTO = new StudentDTO();
				$studentDTO->setRollNo($aLoginDTO->getUsername());
				$studentDTO->setPassword($aLoginDTO->getPassword());
								
				return DPCDAO::authenticate($studentDTO);
			}
			if(!strcmp($aLoginDTO->getLoginAs(),"student")){
				$studentDTO = new StudentDTO();
				$studentDTO->setRollNo($aLoginDTO->getUsername());
				$studentDTO->setPassword($aLoginDTO->getPassword());
								
				return StudentDAO::authenticate($studentDTO);
			}
			if(!strcmp($aLoginDTO->getLoginAs(),"company")){
				$companyDTO = new CompanyDTO();
				$companyDTO->setName($aLoginDTO->getUsername());
				$companyDTO->setPassword($aLoginDTO->getPassword());
				
				return CompanyDAO::authenticate($companyDTO);
			}
		}
	}
?>
