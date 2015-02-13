<?php
	error_reporting(-1);
	ini_set('display_errors', 'On');
	class CompanyDataFormatHelper{
		private $m_arr;
		
		public function __construct($aArr){
			$this->m_arr = $aArr;
		}
		
		public function getCompanyListTable($aTableClass, $aRow1, $aRow2){			
			$tab = <<<EOT
<table class='$aTableClass'>
	<tr class = '$aRow1'>
		<th>Name</th>
		<th>Location</th>
		<th>Status</th>
		<th>Added By</th>
		<th>Added On</th>
	</tr>
EOT;
			$flag = false;
			foreach($this->m_arr as $companyDTO){
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
			
				$data = sprintf($data,	$companyDTO->getName(),
										$companyDTO->getLocation(),
										$companyDTO->getStatus(),
										$companyDTO->getAddedBy(),
										$companyDTO->getAddedOn());

				$tab .= $data;					
			}
			$tab .= "\n</table>";
			return $tab;
		}
	}
?>

