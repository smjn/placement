<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	
	include_once "../tier3/CompanyDAO.php";
	include_once "../common/CompanyDTO.php";
	
	class CompanyBL{
		private static $_instance;
		
		private function __construct(){					
		}
		
		public static function getInstance(){
			if(self::$_instance == null)
				self::$_instance = new CompanyBL();				
			return self::$_instance;
		}
		
		public function authenticate($aCompanyDTO){
			return CompanyDAO::authenticate($aCompanyDTO);
		}
		
		public function &getCompanyFromName($aName){
			return CompanyDAO::getCompanyFromName($aName);
		}
		
		public static function &getJafsFromCompanyId($aCid){
			return CompanyDAO::getJafsFromCompanyId($aCid);
		}
		
		public static function addJaf($aJafDTO){
			return CompanyDAO::addJaf($aJafDTO);
		}
		
		public static function deleteJafById($aId){
			return CompanyDAO::deleteJafById($aId);
		}
		
		public static function &getJafById($aJafId){
			return CompanyDAO::getJafById($aJafId);
		}
		
		public static function placeStudent($aCid, $aJid, $aRoll){
			return CompanyDAO::placeStudent($aCid, $aJid, $aRoll);
		}
	}
?>
