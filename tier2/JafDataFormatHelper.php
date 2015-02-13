<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	
	include_once "../common/JafDTO.php";
	
	class JafDataFormatHelper{
		private $m_arr;
		private $m_action;
		
		public function __construct($aArr, $aAction){
			$this->m_arr = $aArr;
			$this->m_action = $aAction;
		}
		
		public function getJafListTable($aTableClass, $aRow1, $aRow2){			
			$tab = <<<EOT
<table class='$aTableClass'>
	<tr class = '$aRow1'>
		<th>Jaf Id</th>
		<th>Position</th>
		<th>CGPA</th>
		<th>Department</th>
		<th>Discipline</th>
		<th>Action</th>
	</tr>
EOT;
			$flag = false;
			foreach($this->m_arr as $jafDTO){
				$row = $flag?$aRow1:$aRow2;
				$flag = !$flag;
				$data = <<<EOT
	<tr class='$row'>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
EOT;
			
				$data = sprintf($data,	$jafDTO->getJafId(),
										$jafDTO->getPosition(),
										$jafDTO->getCgpa(),
										$jafDTO->getDepartment(),
										$jafDTO->getDiscipline());
				
				$button = <<<EOT
		<td>
			<form name = 'deletejaf' id='deletejaf' method='POST' action='%s'>
				<input type='hidden' name='jid' id='jid' value='%s' />
				<input type='submit' name='deletebut' id='deletebut' value='Delete' />
			</form>
		</td>
	</tr>
EOT;
				$button = sprintf($button,	$this->m_action,
											$jafDTO->getJafId());
				$tab .= $data.$button;				
			}
			$tab .= "\n</table>";
			return $tab;
		}
		
		public function getStudentJafListTable($aTableClass, $aRow1, $aRow2){			
			$tab = <<<EOT
<table class='$aTableClass'>
	<tr class = '$aRow1'>
		<th>Jaf Id</th>
		<th>Company Name</th>
		<th>Position</th>
		<th>Action</th>
	</tr>
EOT;
			$flag = false;
			foreach($this->m_arr as $jafDTO){
				$row = $flag?$aRow1:$aRow2;
				$flag = !$flag;
				$data = <<<EOT
	<tr class='$row'>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
EOT;
			
				$data = sprintf($data,	$jafDTO->getJafId(),
										$jafDTO->getCompanyName(),
										$jafDTO->getPosition());
				
				$button = <<<EOT
		<td>
			<form name = 'acceptjaf' id='acceptjaf' method='POST' action='%s'>
				<input type='hidden' name='jid' id='jid' value='%s' />
				<input type='hidden' name='cid' id='cid' value='%s' />
				<input type='submit' name='acceptbut' id='acceptbut' value='Accept' />
			</form>
		</td>
	</tr>
EOT;
				$button = sprintf($button,	$this->m_action,
											$jafDTO->getJafId(),
											$jafDTO->getCompanyId());
				$tab .= $data.$button;				
			}
			$tab .= "\n</table>";
			return $tab;
		}
	}
?>

