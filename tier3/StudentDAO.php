<?php
	include_once "AuthenticateHelper.php";
	include_once "../common/StudentDTO.php";
	include_once "../common/PlacedStudentDTO.php";
	include_once "../common/JafDTO.php";
	include_once "DBConnection.php";
	include_once "../tier2/JafDataFormatHelper.php";
	
	class StudentDAO{
		private static $_studentAuthQuery = "SELECT rollno FROM students WHERE rollno=? AND password=?";
		private static $_getStudentQuery = "SELECT name, rollno, dept, disc, cgpa, is_dpc, is_registered, is_placed FROM students WHERE rollno=?";
		private static $_updateStudentRegistrationQuery = "UPDATE students SET is_registered=1 WHERE rollno=?";
		private static $_updateStudentPlacementQuery = "UPDATE students SET is_placed=1 WHERE rollno=?";
		private static $_validJafsQuery =<<<EOT
SELECT jafs.jid, jafs.cid, jafs.position, company.company_name, company.cid FROM jafs, company WHERE jafs.disc=? AND jafs.dept=? AND ?>=jafs.cgpa AND jafs.cid=company.cid AND jafs.jid NOT IN (SELECT jid FROM placed WHERE rollno=?);
EOT;
		private static $_acceptJafQuery = "INSERT INTO placed(jid,cid,rollno) VALUES(?,?,?)";
		private static $_allPlacedStudentsQuery = "SELECT s.rollno, s.dept, s.disc, s.name, c.company_name, j.position FROM students AS s, company AS c, placed AS p, jafs AS j WHERE s.is_placed=1 AND c.cid=p.cid AND p.rollno=s.rollno AND p.placed=1 AND j.jid=p.jid ORDER BY s.rollno";
	
		public static function authenticate($aStudentDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_studentAuthQuery);
				return AuthenticateHelper::doAuthenticate($stmt, $aStudentDTO->getRollNo(), $aStudentDTO->getPassword());
			}
		}
		
		public static function &getStudentFromRollNo($aRoll){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_getStudentQuery);				
				$stmt->bind_param('s',$aRoll);
				$stmt->bind_result($name,$roll,$dept,$disc,$cgpa,$is_dpc,$is_reg,$is_placed);
				$arr = array();
				$stmt->execute();
				while($stmt->fetch()){
					$studentDTO = new StudentDTO();
					$studentDTO->setName($name);
					$studentDTO->setRollNo($roll);
					$studentDTO->setDepartment($dept);
					$studentDTO->setCgpa($cgpa);
					$studentDTO->setDiscipline($disc);
					$studentDTO->setIsDpc($is_dpc);
					$studentDTO->setIsRegistered($is_reg);
					$studentDTO->setIsPlaced($is_placed);					
					array_push($arr,$studentDTO);
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
		
		public static function updateRegistration($aRollNo){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_updateStudentRegistrationQuery);
				$stmt->bind_param('s',$aRollNo);
				return $stmt->execute();
			}
			return false;
		}
		
		public static function updatePlacementStatus($aRollNo){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_updateStudentPlacementQuery);
				$stmt->bind_param('s',$aRollNo);
				return $stmt->execute();
			}
			return false;
		}
		
		public static function &getValidJafList($aStudentDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$dept = $aStudentDTO->getDepartment();
				$disc = $aStudentDTO->getDiscipline();
				$cgpa = floatval($aStudentDTO->getCgpa());
				$roll = $aStudentDTO->getRollNo();
				
				$stmt = $con->prepare(self::$_validJafsQuery);
				$stmt->bind_param('ssds',$disc, $dept, $cgpa,$roll);
				$stmt->bind_result($jid, $jcid, $pos, $cname, $cid);
				
				$arr = array();
				if($stmt->execute()){
					while($stmt->fetch()){
						$dto = new JafDTO();
						$dto->setJafId($jid);
						$dto->setCompanyId($jcid);
						$dto->setPosition($pos);
						$dto->setCompanyName($cname);
						array_push($arr, $dto);
					}
					return $arr;
				}
			}
			return array();				
		}
		
		public static function acceptJaf($aJafId, $aCid, $aRollNo){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_acceptJafQuery);
				$stmt->bind_param('sss',$aJafId, $aCid, $aRollNo);
				return $stmt->execute();
			}
			return false;
		}
		
		public static function &getPlacedStudentList(){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_allPlacedStudentsQuery);
				$stmt->bind_result($roll, $dept, $disc, $name, $cname, $pos);
				if($stmt->execute()){
					$arr = array();
					while($stmt->fetch()){
						$dto = new PlacedStudentDTO();
						$dto->setRollNo($roll);
						$dto->setDepartment($dept);
						$dto->setDiscipline($disc);
						$dto->setName($name);
						$dto->setCompanyName($cname);
						$dto->setPosition($pos);
						array_push($arr,$dto);
					}
					return $arr;
				}
			}
			return array();
		}
	}
?>
