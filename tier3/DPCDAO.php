<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	include_once "AuthenticateHelper.php";
	include_once "../common/StudentDTO.php";
	include_once "../common/CompanyDTO.php";
	include_once "DBConnection.php";
	
	class DPCDAO{
		private static $_dpcAuthQuery = "SELECT rollno FROM students WHERE rollno=? AND password=? AND is_dpc=1";
		private static $_insertCompanyQuery = "INSERT INTO company(company_name,location,status,added_on,added_by,password) VALUES(?,?,?,now(),?,?)";
		private static $_getCompaniesQuery = "SELECT company_name, location, status, added_on, added_by FROM company ORDER BY company_name";
		
		public static function authenticate($aDPCDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_dpcAuthQuery);
				return AuthenticateHelper::doAuthenticate($stmt, $aDPCDTO->getRollNo(), $aDPCDTO->getPassword());
			}
		}
		
		public static function addCompany($aCompanyDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_insertCompanyQuery);
				$name = $aCompanyDTO->getName();
				$loc = $aCompanyDTO->getLocation();
				$status = $aCompanyDTO->getStatus();
				$pass = $aCompanyDTO->getPassword();
				$addedBy = $aCompanyDTO->getAddedBy();
				
				$stmt->bind_param('sssss', $name, $loc, $status, $addedBy, $pass);
				return $stmt->execute();
			}
			return false;
		}
		
		public static function &getCompanyList($aSearchDTO=NULL){
			$dto = $aSearchDTO;
			$arr = array();
			if($dto == NULL){
				$con = DBConnection::getInstance()->getConnection();
				if($con){
					$stmt = $con->prepare(self::$_getCompaniesQuery);
					$stmt->bind_result($name,$loc,$status,$addedOn,$addedBy);					
					$stmt->execute();
					
					while($stmt->fetch()){						
						$companyDTO = new CompanyDTO();
						$companyDTO->setName($name);
						$companyDTO->setLocation($loc);
						$companyDTO->setStatus($status);
						$companyDTO->setAddedBy($addedBy);
						$companyDTO->setAddedOn($addedOn);
						array_push($arr,$companyDTO);						
					}
				}
			}
			return $arr;
		}
	}
?>
