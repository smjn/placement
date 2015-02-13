	<?php
	class AuthenticateHelper{		
		public static function doAuthenticate($aStmt, $aUser, $aPass){
			$aStmt->bind_param('ss', $aUser, $aPass);
			try{
				if($aStmt->execute()){
					$aStmt->store_result();
					
					if($aStmt->num_rows() == 1)
						return true;
					else
						return false;
				}
			}
			catch(Exception $aEx){
				die("Could not authenticate: ".$aEx->getMessage());
			}
		}
	}
?>
