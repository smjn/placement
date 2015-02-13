<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	
	session_start();
	require "verifySession.php";
	include_once "../common/CompanyDTO.php";
	include_once "../common/JafDTO.php";
	include_once "../tier2/CompanyBL.php";
	include_once "../tier2/JafDataFormatHelper.php";
	
	$companyDTO = new CompanyDTO();
	$companyDTO->setName($_SESSION['user']);
	$companyDTO->setPassword($_SESSION['pass']);
	
	if(!CompanyBL::getInstance()->authenticate($companyDTO))
		header("Location: logout.php");
		
	$user = $_SESSION["user"];
	$arr = CompanyBL::getInstance()->getCompanyFromName($user);
	$name = $arr[0]->getName();
	$id = $arr[0]->getCompanyId();
	$isErr = false;
	$cgpa = "";
	$dept = "";
	$desc = "";
	$pos = "";
	$errString = "";
	$statusString = "";
	$jafs = "";
	$tab = "";
	$show = "";
	$placeTab = "";
	
	if(isset($_POST["subbut"])){
		$cgpa = $_POST["cgpa"];
		$dept = $_POST["dept"];
		$disc = $_POST["disc"];
		$pos = $_POST["pos"];
		
		$jafDTO = new JafDTO();
		$jafDTO->setCompanyId($id);
		
		if(isset($_POST["pos"]) && $pos != ""){
			$jafDTO->setPosition($pos);
		}
		else{
			$errString .= "Position not set! <br />";
			$isErr = true;
		}
		
		if(isset($_POST["cgpa"]) && $cgpa != ""){
			$jafDTO->setCgpa($cgpa);
		}
		else{
			$errString .= "CGPA not set! <br />";
			$isErr = true;
		}
		
		if(isset($_POST["dept"]) && $dept != "0"){
			$jafDTO->setDepartment($dept);
		}
		else{
			$errString .= "Department not set! <br />";
			$isErr = true;
		}
		
		if(isset($_POST["disc"]) && $disc != "0"){
			$jafDTO->setDiscipline($disc);
		}
		else{
			$errString .= "Discpline not set! <br />";
			$isErr = true;
		}
		
		if(!$isErr){
			if(!CompanyBL::getInstance()->addJaf($jafDTO))
				$errString = "Could not add JAF!";
			else
				$statusString = "Successfully added JAF";
		}
	}
	
	if(isset($_POST["deletebut"])){
		$jid = $_POST["jid"];
		if(CompanyBL::getInstance()->deleteJafById($jid))
			$statusString = "JAF deleted successfully!";
		else
			$errorString = "Could not delete JAF";
	}
	
	$statusString2="";
	$errString2="";
	if(isset($_POST["placebut"])){
		$roll = $_POST["rollno"];
		$jid = $_POST["jafid"];
		if($roll == ""){
			$errString2 .= "Roll Number not set!<br />";
			$isErr = true;
		}
		if($jid == ""){
			$errString2 .= "JAF ID not set!<br />";
			$isErr = true;
		}
		if(!$isErr){
			if(CompanyBL::getInstance()->placeStudent($id, $jid, $roll))
				$statusString2 = "Accepted!";
			else
				$errString2 = "Could not accept student!";
		}
	}
	
	if(isset($_GET["stat"])){
		$show = $_GET["stat"];
		if($_GET["stat"] == "1"){
			$jafs = CompanyBL::getInstance()->getJafsFromCompanyId($id);			
			if(count($jafs) > 0){
				$formatter = new JafDataFormatHelper($jafs,"company.php?stat=".$show);
				$tab = $formatter->getJafListTable("dataTable","row1","row2");
			}
		}
		if($_GET["stat"] == "2"){
			$placeTab =<<<EOT
<form name="placestudent" id="placestudent" method="POST" action="company.php?stat=$show">
	<fieldset name="placefields" id="placefields" class="searchFields">
		<legend>Update placement status</legend>
		<table class="searchTable">
			<tr>
				<td>Jaf Id</td>
				<td>Roll Number</td>
				<td></td>
			</tr>
			<tr>
				<td><input type="text" name="jafid" id="jafid" /></td>
				<td><input type="text" name="rollno" id="rollno" /></td>
				<td><input type="submit" name="placebut" id="placebut" value="Accept" /></td>
			</tr>
			<tr>
				<td colspan="3">
					<span id="errString" name="errString">$errString2</span>
					<span id="statusString" name="statusString">$statusString2</span>
				</td>
			</tr>
		</table>
	</fieldset>
</form>
EOT;
		}
	}
?>

<html>
	<head>
		<title>Company landing page</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<div id="wrapper">
			<a href="logout.php">Logout</a>|<a href="company.php?stat=1">Show Jafs</a>|<a href="company.php?stat=2">Update Results</a>
			<center>
				<h2>Welcome <?php echo $name;?></h2>
				<form name="addjaf" id="addjaf" method="POST" action="company.php?stat=<?php echo $show; ?>">
					<fieldset name="addjaffields" id="addjaffields" class="searchFields">
						<legend>Add new jaf</legend>
						<table class="searchTable">
							<tr>
								<td>Position</td>
								<td>Min CGPA</td>
								<td>Department</td>
								<td>Discipline</td>
								<td></td>
							</tr>
							<tr>
								<td><input type="text" name="pos" id="pos" /></td>
								<td><input type="text" name="cgpa" id="cgpa" /></td>
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
								<td>
									<input type="submit" name="subbut" id="subbut" value="Submit" />
								</td>								
							</tr>
							<tr>
								<td colspan="4">
									<span id="errString" name="errString"><?php echo $errString;?></span>
									<span id="statusString" name="statusString"><?php echo $statusString;?></span>
								</td>
							</tr>
						</table>
					</fieldset>
				</form>
				<?php echo $tab; ?>
				<?php echo $placeTab; ?>
			</center>
		</div>
	</body>
</html>
