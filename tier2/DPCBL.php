<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	include_once "../tier3/StudentDAO.php";
	include_once "../tier3/DPCDAO.php";
	include_once "../common/StudentDTO.php";
	include_once "../common/CompanyDTO.php";
	
	class DPCBL{
		private static $_instance;
		
		private function __construct(){					
		}
		
		public static function getInstance(){
			if(self::$_instance == null)
				self::$_instance = new DPCBL();				
			return self::$_instance;
		}
		
		public function authenticate($aStudentDTO){
			return DPCDAO::authenticate($aStudentDTO);
		}
		
		public function &getStudentFromRollNo($aRoll){
			return StudentDAO::getStudentFromRollNo($aRoll);
		}
		
		public function addCompany($aCompanyDTO){
			return DPCDAO::addCompany($aCompanyDTO);
		}
		
		public function &getCompanyList($aSearchDTO=NULL){			
			return DPCDAO::getCompanyList($aSearchDTO);
		}
	}
?>
