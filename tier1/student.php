<?php
	error_reporting(E_ALL);
	ini_set('display_errors', True);
	
	session_start();
	require "verifySession.php";
	include_once "../common/StudentDTO.php";
	include_once "../tier2/StudentBL.php";
	include_once "../tier2/PlacedDataFormatHelper.php";
	
	$studentDTO = new StudentDTO();
	$studentDTO->setRollNo($_SESSION['user']);
	$studentDTO->setPassword($_SESSION['pass']);
	$tab = "";
	$jafTable = "";
	$errString = "";
	$statusString = "";
	$show = "";
	
	if(!StudentBL::getInstance()->authenticate($studentDTO))
		header("Location: logout.php");
		
	$user = $_SESSION["user"];
	$arr = StudentBL::getInstance()->getStudentFromRollNo($user);
	$name = $arr[0]->getName();
	$isReg = $arr[0]->getIsRegistered();
	
	if(isset($_GET["stat"]))
		$show = $_GET["stat"];		
	
	if(!$isReg){
		$tab =<<<EOT
<form name="updatereg" id="updatereg" method="POST" action="student.php">
	<fieldset class="searchFields" name="regfield" id="regfield">
		<legend>Registration Status</legend>
		<span id="errString" name="errString">Registration Pending</span>
		<p>Registration is pending. Please click the Register button to register for placement.</p>
		<input type="submit" name="regbut" id="regbut" value="Register" />
	</fieldset>
</form>
EOT;
	}
	
	if(isset($_POST["regbut"])){
		if(StudentBL::getInstance()->updateRegistration($user))
			$tab =<<<EOT
<center>
	<span id="statusString" name="statusString">Successfully Registered!</span>
</center>
EOT;
	
		$isReg = true;	
	}
	
	if(isset($_POST["acceptbut"])){		
		$jid = $_POST["jid"];
		$cid = $_POST["cid"];
		if(StudentBL::getInstance()->acceptJaf($jid, $cid, $user))
			$statusString = "Successfully accpeted JAF ".$jid;
		else
			$errString = "Unable to accept JAF ".$jid;
	}
	
	if($isReg){
		if($show == "1"){
			$jafs = StudentBL::getInstance()->getValidJafList($arr[0]);
			$formatter = new JafDataFormatHelper($jafs,"student.php?stat=".$show);
			$jafTable = $formatter->getStudentJafListTable("dataTable", "row1", "row2");
		}
		else if($show == "2"){
			$results = StudentBL::getInstance()->getPlacedStudentList();
			$formatter = new PlacedDataFormatHelper($results);
			$jafTable = $formatter->getPlacedStudentListTable("dataTable", "row1", "row2");
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Student landing page</title>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>		
		<div id="wrapper">
			<a href="logout.php">Logout</a><?if ($isReg):?>|<a href="student.php?stat=1">View Jafs</a>|<a href="student.php?stat=2">Results</a><?php endif; ?>
			<center>
				<h2>Welcome <?php echo $name; ?></h2>
				<?php echo $tab; ?>
				<br />
				<span id="errString" name="errString"><?php echo $errString;?></span><span id="statusString" name="statusString"><?php echo $statusString;?></span>
				<?php echo $jafTable; ?>
			</center>
		</div>	
	</body>
</html>
