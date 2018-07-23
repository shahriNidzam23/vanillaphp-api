<?php
include 'config.php';
header('Content-Type: application/json');


switch ($_POST['functionname']) {
	case 'chart':
		chart($conn);
		break;
	default:
		echo "error function not found";
		break;
}

function chart($conn) {
	$yearElec = (string)date("Y");
	$row = [];
	$row["voting"] = [];
	$row["programme"] = [];
	$row["year"] = [];
	$userquery = "SELECT year, programme  FROM user WHERE NOT fname = 'admin' AND NOT id = '1' AND vStatus = 'done'";
	$candidatequery = "SELECT electionID, vTotal, fname FROM candidate WHERE yElection = '$yearElec'";

	if($results = $conn->query($candidatequery)){
	    if($results->num_rows){
	        while ($srow = $results->fetch_assoc()) {
				array_push($row["voting"],$srow);
			}
			
			if($userresults = $conn->query($userquery)){
			    if($userresults->num_rows){
			        while ($userrow = $userresults->fetch_assoc()) {
						array_push($row["programme"],$userrow["programme"]);
						array_push($row["year"],$userrow["year"]);
					}
					
				}
			}

			echo json_encode($row);
		}
	}

	mysqli_close($conn);
}
?>