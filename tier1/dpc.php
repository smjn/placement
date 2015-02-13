<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	
	session_start();
	require "verifySession.php";
	include_once "../tier2/DPCBL.php";
	include_once "../common/CompanyDTO.php";
	include_once "../common/StudentDTO.php";
	include_once "../tier2/CompanyDataFormatHelper.php";
	
	$dpcDTO = new StudentDTO();
	$dpcDTO->setRollNo($_SESSION['user']);
	$dpcDTO->setPassword($_SESSION['pass']);
	
	if(!DPCBL::getInstance()->authenticate($dpcDTO))
		header("Location: logout.php");		
	
	$errString = "";
	$statusString = "";
	$field = array("compname"=>"Name","comploc"=>"Location","status"=>"Status");
	$isErr = false;
	$name = "";
	$loc = "";
	$status = "";

	if(isset($_POST["subbut"])){
		if(isset($_POST["compname"]) && $_POST["compname"] != "")
			$name = $_POST["compname"];
		else{
			$errString .= $field["compname"]." Not set.<br />";
			$isErr = true;
		}
			
		if(isset($_POST["comploc"]) && $_POST["comploc"] != "")
			$loc = $_POST["comploc"];
		else{
			$errString .= $field["comploc"]." Not set.<br />";
			$isErr = true;
		}
			
		if(isset($_POST["status"]) && $_POST["status"] != "--Select--")
			$status = $_POST["status"];
		else{
			$errString .= $field["status"]." Not set.<br />";
			$isErr = true;
		}
		
		if(!$isErr){
			$companyDTO = new CompanyDTO();
			$companyDTO->setName($name);
			$companyDTO->setLocation($loc);
			$companyDTO->setStatus($status);
			$companyDTO->setPassword($name);
			$companyDTO->setAddedBy($_SESSION["user"]);
			
			if(DPCBL::getInstance()->addCompany($companyDTO)){
				$statusString = "Company info added successfully";
			}
		}		
	}
	
	$arr = DPCBL::getInstance()->getCompanyList();
	$formatter = new CompanyDataFormatHelper($arr);
	$tab = $formatter->getCompanyListTable("dataTable","row1","row2");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>DPC landing page</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<a href="logout.php">Logout</a>
		<center>
			<h2>Welcome</h2>
		</center>
		<div name="wrapper" id="wrapper">
			<center>							
				<div name="addcompdiv" id="addcompdiv">
					<form name = 'addComp' id = 'addComp' method = 'POST' action = 'dpc.php'>
						<fieldset name="addcompany" id="addcompany" class="searchFields">
							<legend>Add Company Info</legend>
							<table class="searchTable">
								<tr>
									<td>Name</td>
									<td>Location</td>
									<td>Status</td>							
								</tr>
								<tr>
									<td><input type='text' name='compname' id='compname' value='<?php echo $name; ?>'/></td>
									<td><input type='text' name='comploc' id='comploc' value='<?php echo $loc; ?>' /></td>
									<td>
										<select name="status" id="status">
											<option value="--Select--">--Select--</option>
											<option value="C1">C1</option>
											<option value="C2">C2</option>
											<option value="C3">C3</option>
											<option value="Others">Others</option>
										</select>
									</td>
									<td>
										<input type='submit' name='subbut' id='subbut' value='Add company' />
									</td>
									<td>
										<input type='submit' name='resetbut' id='resetbut' value='Reset' />
									</td>	
								</tr>
								<tr>
									<td colspan="5">
										<span id="errString" name="errString"><?php echo $errString;?></span>
										<span id="statusString" name="statusString"><?php echo $statusString;?></span>
									</td>
								</tr>						
							</table>			
						</fieldset>
					</form>
				</div>			
				<br />
				<div name="searchcompdiv" id="searchcompdiv">
					<?php echo $tab; ?>
				</div>
			</center>
		</div>
	</body>
</html>

