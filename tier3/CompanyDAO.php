<?php
	include_once "AuthenticateHelper.php";
	include_once "../common/CompanyDTO.php";
	include_once "../common/JafDTO.php";
	include_once "DBConnection.php";
	
	class CompanyDAO{
		private static $_companyAuthQuery = "SELECT cid FROM company WHERE company_name=? AND password=?";
		private static $_getCompanyQuery = "SELECT cid, company_name, location, status, added_by, added_on FROM company WHERE company_name=?";
		private static $_getJafsQuery = "SELECT jid, position, cgpa, dept, disc FROM jafs where cid=?";
		private static $_getJafFromIdQuery = "SELECT jid, cid, position, cgpa, dept, disc FROM jafs where jid=?";
		private static $_insertJafQuery = "INSERT INTO jafs(cid, position, cgpa, dept, disc) VALUES(?,?,?,?,?)";
		private static $_deleteJafQuery = "DELETE FROM jafs WHERE jid=?";
		private static $_placeStudentQuery = "UPDATE placed SET placed=1 WHERE jid=? AND cid=? AND rollno=?";
		private static $_updatePlacementStatusQuery = "UPDATE students SET is_placed=1 WHERE rollno=?";
		
		public static function authenticate($aCompanyDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_companyAuthQuery);
				return AuthenticateHelper::doAuthenticate($stmt, $aCompanyDTO->getName(), $aCompanyDTO->getPassword());
			}
		}
		
		public static function &getCompanyFromName($aName){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_getCompanyQuery);				
				$stmt->bind_param('s',$aName);
				$stmt->bind_result($id,$name,$loc,$status,$addedBy,$addedOn);
				$arr = array();
				$stmt->execute();
				while($stmt->fetch()){
					$companyDTO = new CompanyDTO();
					$companyDTO->setCompanyId($id);
					$companyDTO->setName($name);
					$companyDTO->setLocation($loc);
					$companyDTO->setStatus($status);
					$companyDTO->setAddedBy($addedBy);
					$companyDTO->setAddedOn($addedOn);
										
					array_push($arr,$companyDTO);
				}
				if(count($arr) > 1 || count($arr) == 0){
					return array();
				}
				else{
					return $arr;
				}
			}
			return array();
		}
		
		public static function &getJafsFromCompanyId($aCid){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_getJafsQuery);				
				$stmt->bind_param('s',$aCid);
				$stmt->bind_result($id,$pos,$cgpa,$dept,$disc);
				$arr = array();
				$stmt->execute();
				while($stmt->fetch()){
					$jafDTO = new JafDTO();
					$jafDTO->setJafId($id);
					$jafDTO->setPosition($pos);
					$jafDTO->setCgpa($cgpa);
					$jafDTO->setDepartment($dept);
					$jafDTO->setDiscipline($disc);
					array_push($arr,$jafDTO);
				}
				return $arr;
			}
			return array();
		}
		
		public static function addJaf($aJafDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_insertJafQuery);
				$cid = $aJafDTO->getCompanyId();
				$pos = $aJafDTO->getPosition();
				$dept = $aJafDTO->getDepartment();
				$disc = $aJafDTO->getDiscipline();
				$cgpa = $aJafDTO->getCgpa();
				
				$stmt->bind_param('sssss',$cid,$pos,$cgpa,$dept,$disc);
				return $stmt->execute();
			}
			return false;			
		}
		
		public static function deleteJafById($aId){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_deleteJafQuery);
				$stmt->bind_param('s',$aId);
				return $stmt->execute();
			}
			return false;
		}
		
		public static function &getJafById($aId){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_getJafFromIdQuery);
				$stmt->bind_param('s',$aId);
				$stmt->bind_result($jid, $cid, $pos, $cgpa, $dept, $disc);
				if($stmt->execute()){
					$arr = array();
					$stmt->fetch();
					$dto = new JafDTO();
					$dto->setJafId($id);
					$dto->setCompanyId($cid);
					$dto->setPosition($pos);
					$dto->setCgpa($cgpa);
					$dto->setDepartment($dept);
					$dto->setDiscipline($disc);
					array_push($arr,$dto);
					return $arr;
				}
			}
			return array();
		}
		
		public static function placeStudent($aCid, $aJid, $aRoll){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_placeStudentQuery);
				$stmt->bind_param('sss',$aJid, $aCid, $aRoll);
				if($stmt->execute()){
					$stmt = $con->prepare(self::$_updatePlacementStatusQuery);
					$stmt->bind_param('s',$aRoll);
					return $stmt->execute();
				}
			}
			return false;			
		}
	}
?>
