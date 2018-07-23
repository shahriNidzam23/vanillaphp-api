<?php
include 'config.php';
header('Content-Type: application/json');


switch ($_POST['functionname']) {
	case 'logout':
		logout($conn);
		break;
	case 'register':
		register($conn);
		break;
	default:
		echo "error function not found";
		break;
}

function register($conn) {
	$yElection = (string)date("Y");
	$id = $_POST['data']['id'];
	$electionID =  $yElection . "-" . $id;
	$image = $_POST['data']['img'];
	$fname = $_POST['data']['name'];
	$email = $_POST['data']['email'];
	$phone = $_POST['data']['phone'];
	$gender = $_POST['data']['gender'];
	$programme = $_POST['data']['program'];
	$year = $_POST['data']['year'];
	$nationality = $_POST['data']['nation'];
	$slogan = $_POST['data']['slogan'];
	$vTotal = 0;
	$aboutMe = "";

	$imgquery = "INSERT INTO img (id, image) VALUES ('', '$image')";

	if ($conn->query($imgquery)) {
    $last_id = $conn->insert_id;
	$query = "INSERT INTO candidate (electionID, studentID, fname, gender, email, phone, programme, yStudy, nationality, image,  slogan, aboutMe, yElection, vTotal) VALUES ('$electionID', '$id', '$fname', '$gender', '$email', '$phone', '$programme', '$year', '$nationality',  '$last_id', '$slogan', '$aboutMe', '$yElection', '$vTotal')";
		if ($conn->query($query)) {
			$_SESSION['id'] = $id;
			$_SESSION['success'] = "You are now logged in";
			echo json_encode("Data Inserted");
		} else {
		    echo json_encode("Error user: " . $conn->error);
		}

	} else {
	    echo json_encode("Error img: " . $conn->error);
	}

	mysqli_close($conn);
}

function logout($conn) {
	$id = $_SESSION['id'];
	$_SESSION['id'] = null;
	echo json_encode($id);
}
?>