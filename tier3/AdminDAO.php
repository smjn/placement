<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	include_once "AuthenticateHelper.php";
	include_once "../common/AdminDTO.php";
	include_once "../common/StudentDTO.php";
	include_once "DBConnection.php";
	
	class AdminDAO{
		private static $_adminAuthQuery = "SELECT adminid FROM admin WHERE username=? AND password=?";
		private static $_studentListQuery = "SELECT name, rollno, dept, disc, cgpa, is_dpc, is_placed, is_registered FROM students WHERE 1=1";
		private static $_toggleDPCQuery = "UPDATE students SET is_dpc=(1-is_dpc) WHERE rollno=?";
		
		public static function authenticate($aAdminDTO){
			$con = DBConnection::getInstance()->getConnection();
			if($con){
				$stmt = $con->prepare(self::$_adminAuthQuery);
				return AuthenticateHelper::doAuthenticate($stmt, $aAdminDTO->getUsername(), $aAdminDTO->getPassword());
			}
		}
		
		public static function &getStudentList($aStudentSearchDTO=NULL){
			$con = DBConnection::getInstance()->getConnection();
			$arr = array();
			if($con != NULL){				
				$stmt = self::getStudentSearchStatement($con, $aStudentSearchDTO);
				$stmt->bind_result($name,$roll,$dept,$disc,$cgpa,$is_dpc,$is_placed,$is_reg);
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
					array_push($arr, $studentDTO);
				}
			}
			return $arr;
		}
		
		private static function getStudentSearchStatement($aCon, $aStudentSearchDTO){
			$augmentedQuery = self::$_studentListQuery;
			$arr = array();
			$type = "";
			$vars = array();
			$stmt = NULL;
						
			if($aStudentSearchDTO != NULL){
				$name = $aStudentSearchDTO->getName();
				$roll = $aStudentSearchDTO->getRollNo();
				$dept = $aStudentSearchDTO->getDepartment();
				$disc = $aStudentSearchDTO->getDiscipline();								
				$isDpc = $aStudentSearchDTO->getIsDpc();
				$isReg = $aStudentSearchDTO->getIsRegistered();
				$isPlaced = $aStudentSearchDTO->getIsPlaced();				
				
				if(isset($name) && strcmp($name,"")){
					$augmentedQuery .= " AND lower(name)=?";
					$arr["1"] = strtolower($name);
					$type .= "s";
				}
				
				if(isset($roll) && strcmp($roll,"")){
					$augmentedQuery .= " AND rollno=?";
					$arr["2"] = $roll;
					$type .= "s";
				}
				
				if(isset($dept) && strcmp($dept,"")){
					$augmentedQuery .= " AND dept=?";
					$arr["3"] = $dept;
					$type .= "s";
				}
				
				if(isset($disc) && strcmp($disc,"")){
					$augmentedQuery .= " AND disc=?";
					$arr["4"] = $disc;
					$type .= "s";
				}
				
				if(isset($isDpc) && strcmp($isDpc,"")){
					$augmentedQuery .= " AND is_dpc=?";
					$arr["5"] = $isDpc;
					$type .= "s";
				}
				
				if(isset($isReg) && strcmp($isReg,"")){
					$augmentedQuery .= " AND is_registered=?";
					$arr["6"] = $isReg;
					$type .= "s";
				}
				
				if(isset($isPlaced) && strcmp($isPlaced,"")){
					$augmentedQuery .= " AND is_placed=?";
					$arr["7"] = $isPlaced;
					$type .= "s";
				}

				foreach($arr as $key=>&$val){
					$vars[] = &$val;
				}
				
				$stmt = $aCon->prepare($augmentedQuery);
				//var_dump($augmentedQuery, array_merge(array($type),$vars));
				if(strlen($type) != 0)					
					call_user_func_array(array($stmt, "bind_param"), array_merge(array($type),$vars));
			}
			else{
				$stmt = $aCon->prepare($augmentedQuery);
			}
			if($stmt->execute()){
				return $stmt;
			}				
		}
		
		public static function toggleDPC($aStudentDTO){
			$roll = $aStudentDTO->getRollNo();
			if(isset($roll)){
				$con = DBConnection::getInstance()->getConnection();
				$stmt = $con->prepare(self::$_toggleDPCQuery);
				$stmt->bind_param("s",$roll);	
				return $stmt->execute();
			}
			return false;
		}
	}
?>
