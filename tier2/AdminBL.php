<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	include_once "../tier3/AdminDAO.php";
	include_once "../common/AdminDTO.php";
	include_once "../common/StudentSearchDTO.php";
	include_once "../common/StudentDTO.php";
	
	class AdminBL{
		private static $_instance;
		
		private function __construct(){					
		}
		
		public static function getInstance(){
			if(self::$_instance == null)
				self::$_instance = new AdminBL();				
			return self::$_instance;
		}
		
		public function authenticate($aAdminDTO){
			return AdminDAO::authenticate($aAdminDTO);
		}
		
		public function &getStudentList($aStudentSearchDTO = NULL){
			return AdminDAO::getStudentList($aStudentSearchDTO);
		}
		
		public function toggleDPC($aStudentDTO){
			return AdminDAO::toggleDPC($aStudentDTO);
		}
	}
?>
