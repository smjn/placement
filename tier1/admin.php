<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	session_start();
	include_once "../tier2/AdminBL.php";
	include_once "../common/StudentDTO.php";
	include_once "../common/AdminDTO.php";
	include_once "../common/StudentSearchDTO.php";
	include_once "../tier2/AdminDataFormatHelper.php";
	require "verifySession.php";
	
	$adminDTO = new AdminDTO();
	$adminDTO->setUsername($_SESSION['user']);
	$adminDTO->setPassword($_SESSION['pass']);
	
	if(!AdminBL::getInstance()->authenticate($adminDTO))
		header("Location: logout.php");
		
	$createDTO = true;
	if(isset($_POST["updatebut"])){
		$roll = $_POST["rollno"];
		$status = $_POST["status"];
		$studentDTO = new StudentDTO();
		$studentDTO->setRollNo($roll);
		if(AdminBL::getInstance()->toggleDPC($studentDTO))
			$createDTO = false;		
	}
	
	$tab = "";
	$sname = "";
	$sroll = "";
	$dept = "";
	$disc = "";
	$sdpc = "";
	$sreg = "";
	$splaced = "";
	$searchDTO = NULL;
	
	if(isset($_POST["searchbut"])){
		$searchDTO = new StudentSearchDTO();
	}
	else if(!$createDTO){
		$searchDTO = unserialize($_SESSION["search"]);
	}
	
	if(isset($_POST["searchbut"]) || !$createDTO){
		if(isset($_POST["searchbut"])){
			if(isset($_POST["sname"])){
				$sname = $_POST["sname"];
				$searchDTO->setName($sname);
			}
			
			if(isset($_POST["sroll"])){
				$sroll = $_POST["sroll"];
				$searchDTO->setRollNo($sroll);
			}
			
			if(isset($_POST["dept"])){
				$dept = $_POST["dept"];
				if(strcmp($dept,"0"))
					$searchDTO->setDepartment($dept);
				else
					$searchDTO->setDepartment("");			
			}
			
			if(isset($_POST["disc"])){
				$disc = $_POST["disc"];
				if(strcmp($disc,"0"))
					$searchDTO->setDiscipline($disc);
				else
					$searchDTO->setDiscipline("");
			}
			
			if(isset($_POST["sdpc"])){
				$sdpc = "checked";
				$searchDTO->setIsDpc("1");
			}
			else
				$searchDTO->setIsDpc("");
			
			if(isset($_POST["sreg"])){
				$sreg = "checked";
				$searchDTO->setIsRegistered("1");
			}
			else
				$searchDTO->setIsRegistered("");
			
			if(isset($_POST["splaced"])){
				$splaced = "checked";
				$searchDTO->setIsPlaced("1");
			}
			else
				$searchDTO->setIsPlaced("");
			$_SESSION['search'] = serialize($searchDTO);
		}
		if(!$createDTO){
			$sname = $searchDTO->getName();
			$sroll = $searchDTO->getRollNo();
			$dept = $searchDTO->getDepartment();
			$disc = $searchDTO->getDiscipline();
			$sdpc = $searchDTO->getIsDpc();
			$sreg = $searchDTO->getIsRegistered();
			$splaced = $searchDTO->getIsPlaced();
		}
		$arr = AdminBL::getInstance()->getStudentList($searchDTO);
		$formatter = new AdminDataFormatHelper($arr,"admin.php");
		$tab = $formatter->getStudentListTable("dataTable", "row1", "row2");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>		
		<div id="wrapper">
			<a href="logout.php">Logout</a>
			<center>				
				<form name = "search" id = "search" method = "POST" action = "admin.php">
					<fieldset name="studentsearch" id="studentsearch" class="searchFields">
						<legend>Student Search</legend>
						<table class = "searchTable" cellspacing="2" cellpadding="2">
							<tr>
								<td>Name</td>
								<td>Roll Number</td>
								<td>Department</td>
								<td>Discipline</td>
								<td>DPC</td>
								<td>Registered</td>
								<td>Placed</td>
							</tr>
							
							<tr>
								<td><input type="text" name="sname" id="sname" value='<?php echo $sname;?>' /></td>
								<td><input type="text" name="sroll" id="sroll" value='<?php echo $sroll;?>'/></td>
								<td>
									<select name="dept" id="dept">
										<option value="0">--Select--</option>
										<option value="CSE">CSE</option>
										<option value="EE">EE</option>
										<option value="CE">CE</option>
										<option value="AE">AE</option>
										<option value="ES">ES</option>
										<option value="PH">PH</option>
										<option value="MT">MT</option>
										<option value="ME">ME</option>
									</select>
								</td>
								<td>
									<select name="disc" id="disc">
										<option value="0">--Select--</option>
										<option value="BTech">BTech</option>
										<option value="MTech">MTech</option>
										<option value="MSc">MSc</option>
										<option value="PhD">PhD</option>
									</select>
								</td>
								<td><input type="checkbox" name='sdpc' id='sdpc' value='DPC' <?php echo $sdpc;?> /></td>
								<td><input type="checkbox" name='sreg' id='sreg' value='Registered' <?php echo $sreg;?> /></td>
								<td><input type="checkbox" name='splaced' id='splaced' value='Placed' <?php echo $splaced;?> /></td>
							</tr>
							<tr>
								<td colspan='7'><input type='submit' name='searchbut' id='searchbut' value='Search' /></td>
							</tr>
						</table>
					</fieldset>
				</form>
				<br />
				<?php echo $tab; ?>
			</center>
		</div>
	</body>
</html>
