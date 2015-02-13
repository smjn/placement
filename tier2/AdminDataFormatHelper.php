<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	class AdminDataFormatHelper{
		private $m_arr;
		private $m_action;
		
		public function __construct($aArr, $aAction){
			$this->m_arr = $aArr;
			$this->m_action = $aAction;
		}
		
		public function getStudentListTable($aTableClass, $aRow1, $aRow2){			
			$tab = <<<EOT
<table class='$aTableClass'>
	<tr class = '$aRow1'>
		<th>Name</th>
		<th>Roll Number</th>
		<th>Department</th>
		<th>Discipline</th>
		<th>CGPA</th>
		<th>DPC</th>
		<th>Registered</th>
		<th>Placed</th>
		<th>Action</th>
	</tr>
EOT;
			$flag = false;
			foreach($this->m_arr as $studentDTO){
				$row = $flag?$aRow1:$aRow2;
				$flag = !$flag;
				$data = <<<EOT
	<tr class='$row'>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
EOT;
			
				$data = sprintf($data,	$studentDTO->getName(),
										$studentDTO->getRollNo(),
										$studentDTO->getDepartment(),
										$studentDTO->getDiscipline(),
										$studentDTO->getCgpa(),
										$studentDTO->getIsDpc(),
										$studentDTO->getIsRegistered(),
										$studentDTO->getIsPlaced());
				
				$butVal = !strcmp($studentDTO->getIsDpc(),"1")?'Unset DPC':'Set DPC';
				$status = !strcmp($studentDTO->getIsDpc(),"1")?1:2;
				$button = <<<EOT
		<td>
			<form name = 'update' id='update' method='POST' action='%s'>
				<input type='hidden' name='rollno' id='rollno' value='%s' />
				<input type='hidden' name='status' id='status' value='%s' />
				<input type='submit' name='updatebut' id='updatebut' value='%s' />
			</form>
		</td>
	</tr>
EOT;
				$button = sprintf($button,	$this->m_action,
											$studentDTO->getRollNo(),
											$status,
											$butVal);
				$tab .= $data.$button;					
			}
			$tab .= "\n</table>";
			return $tab;
		}
	}
?>
