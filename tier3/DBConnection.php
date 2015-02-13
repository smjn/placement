<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	final class DBConnection{
		private $m_con;
		private static $_obj=NULL; 
		
		//add your default params here
		private function __construct($aHost = "", $aUser = "", $aPass = "", $aDb = ""){
			$this->m_con = mysqli_connect($aHost, $aUser, $aPass, $aDb);
		}
		
		public static function getInstance(){
			if(isset(self::$_obj))
				return self::$_obj;
			else{
				try{
					self::$_obj = new DBConnection();
					return self::$_obj;
				}
				catch(Exception $aEx){
					var_dump($aEx);
					die("Could not connect to DB: ".$aEx->getMessage());
				}
			}
		}
		
		public function getConnection(){
			return $this->m_con;
		}
	}
?>
