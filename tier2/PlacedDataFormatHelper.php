<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	class PlacedDataFormatHelper{
		private $m_arr;
		
		public function __construct($aArr){
			$this->m_arr = $aArr;
		}
		
		public function getPlacedStudentListTable($aTableClass, $aRow1, $aRow2){
			$tab =<<<EOT
<table class=$aTableClass>
	<tr class = '$aRow1'>
		<th>Name</th>
		<th>Roll No</th>
		<th>Department</th>
		<th>Discipline</th>
		<th>Company Name</th>
		<th>Position</th>
	</tr>
EOT;
			$flag = false;
			foreach($this->m_arr as $dto){
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
EOT;

			$data = sprintf($data,	$dto->getName(),
									$dto->getRollNo(),
									$dto->getDepartment(),
									$dto->getDiscipline(),
									$dto->getCompanyName(),
									$dto->getPosition());
				$tab .= $data;					
			}
			$tab .= "\n</table>";
			return $tab;
		}
	}
?>
