<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	
	include_once "../tier3/StudentDAO.php";
	include_once "../tier3/CompanyDAO.php";
	include_once "../common/StudentDTO.php";
	
	class StudentBL{
		private static $_instance;
		
		private function __construct(){					
		}
		
		public static function getInstance(){
			if(self::$_instance == null)
				self::$_instance = new StudentBL();				
			return self::$_instance;
		}
		
		public function authenticate($aStudentDTO){
			return StudentDAO::authenticate($aStudentDTO);
		}
		
		public function &getStudentFromRollNo($aRoll){
			return StudentDAO::getStudentFromRollNo($aRoll);
		}
		
		public function updatePlacementStatus($aRoll){
			return StudentDAO::updatePlacementStatus($aRoll);
		}
		
		public function updateRegistration($aRoll){
			return StudentDAO::updateRegistration($aRoll);
		}
		
		public function &getValidJafList($aStudentDTO){
			return StudentDAO::getValidJafList($aStudentDTO);
		}
		
		public static function &getJafById($aJafId){
			return CompanyDAO::getJafById($aJafId);
		}
		
		public static function acceptJaf($aJafId, $aCid, $aUser){
			return StudentDAO::acceptJaf($aJafId, $aCid, $aUser);
		}
		
		public static function &getPlacedStudentList(){
			return StudentDAO::getPlacedStudentList();
		}
	}
?>
