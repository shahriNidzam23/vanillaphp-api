<?php
include 'config.php';
header('Content-Type: application/json');


switch ($_POST['functionname']) {
	case 'vote':
		vote($conn);
		break;
	case 'delete':
		delete($conn);
		break;
	case 'getCandidate':
		getCandidate($conn);
		break;
	default:
		echo "error function not found";
		break;
}

function vote($conn) {
	$id = $_SESSION['id'];
	$cid = $_POST['data'];
	 $cquery = "SELECT * FROM candidate WHERE studentID = $cid";
	if($results = $conn->query($cquery)){
	     if($results->num_rows){
	         while ($row = $results->fetch_assoc()) {
	            $vtotal = $row["vTotal"] + 1;
	            $cuquery = "UPDATE candidate SET vTotal = '$vtotal' WHERE studentID = $cid";

				if ($conn->query($cuquery)) {
					$query = "UPDATE user SET vStatus = 'done' WHERE id = $id";
					if ($conn->query($query)) {
							echo json_encode("success");
					} else {
					    echo json_encode("Error user: " . $conn->error);
					}
				} else {
					echo json_encode("Error user: " . $conn->error);
				}	
	        }
	    }
	} else{
		echo json_encode("Error user: " . $conn->error);
	}

	mysqli_close($conn);
}

function delete($conn) {
	$cid = $_POST['data'];
	$query = "DELETE FROM candidate WHERE studentID = $cid";
	if ($conn->query($query)) {
			echo json_encode("success");
	} else {
	    echo json_encode("Error user: " . $conn->error);
	}	
	mysqli_close($conn);
}

function getCandidate($conn){
	$id = $_POST['data'];
	$yearElec = (string)date("Y");
	$query = "SELECT * FROM candidate LEFT JOIN img ON candidate.image = img.id WHERE candidate.yElection = '$yearElec' AND candidate.studentID = '$id'";
	if($results = $conn->query($query)){
			if($results->num_rows){
				while ($row = $results->fetch_assoc()) {
					$res[] = $row;
				}
		    		echo json_encode($res);
			} else {
		    	echo json_encode("no candidate");
			}
		} else {
			die('error: ' . $conn->error);
		}

		
	mysqli_close($conn);
}
?>