<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	include_once "../common/LoginDTO.php";
	include_once "../tier2/LoginBL.php";
	
	$errString = "";
	$user = "";
	
	if(isset($_POST["subBut"])){
		$user = $_POST["username"];
		if(isset($_POST["loginAs"])){
			$loginDTO = new LoginDTO();
			$loginDTO->setUsername($user);
			$loginDTO->setPassword($_POST["password"]);
			$loginDTO->setLoginAs($_POST["loginAs"]);
			
			$con = LoginBL::getInstance();
			if(!$con->authenticate($loginDTO))
				$errString = "Incorrect Username/Password";
			else{
				session_start();					
				$_SESSION["user"] = $_POST["username"];
				$_SESSION["pass"] = $_POST["password"];
				switch($_POST["loginAs"]){
					case "admin":
						header("Location: admin.php");
						break;
					case "dpc":
						header("Location: dpc.php");
						break;
					case "student":
						header("Location: student.php");
						break;
					case "company":
						header("Location: company.php");
						break;
				}
			}
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Placement cell login form</title>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
	<body>
		<div id="container">
			<center>
			<h2>Welcome to placement portal</h2>			
			<form id="loginForm" method="POST" action="index.php">
				<div id="tableWrapper">
					<fieldset class="loginFieldSet">
					<legend>Enter Login Info</legend>					
						<table class="loginTable" valign="center">
							<tr>
								<td class="cellLeft">Username</td>
								<td class="cellCenter"><input type="text" name="username" id="username" value="<?php echo $user; ?>"/></td>
							</tr>
							<tr>
								<td class="cellLeft">Password</td>
								<td class="cellCenter"><input type="password" name="password" id="password"/></td>
							</tr>
							<tr>
								<td class="cellLeft">Login as</td>
								<td class="cellCenter">
									<select name="loginAs" id="loginAs" >
										<option value="admin">Admin</option>
										<option value="dpc">DPC</option>
										<option value="student">Student</option>
										<option value="company">Company</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="2" class="cellCenter"><input type="submit" name="subBut" id="subBut" value="Login" /></td>
							</tr>
							<?php if (strlen($errString) > 0): ?>
								<tr>
									<td colspan="2" class="cellCenter"><span id="errString"><?php echo $errString; ?></span></td>
								</tr>
							<?php endif ?>
						</table>
					</fieldset>
				</div>
			</form>
			</center>
		</div>
	</body>
</html>
