<?php
include 'config.php';
header('Content-Type: application/json');
switch ($_POST['functionname']) {
	case 'login':
		login($conn);
		break;
	case 'signup':
		signup($conn);
		break;
	default:
		echo "error function not found";
		break;
}


function login($conn) {
	$id = $_POST['id'];
	$password = md5($_POST['pw']);
	if($_POST['id'] == "admin"){
		$query = "SELECT * FROM user WHERE fname='$id' AND password='$password'";
	} else {
		$query = "SELECT * FROM user WHERE id='$id' AND password='$password'";
	}

	if($results = $conn->query($query)){
		if($results->num_rows){
			while ($row = $results->fetch_assoc()) {
				$_SESSION['id'] = $id;
	    		echo json_encode($row);
			}
		} else {
	    	echo json_encode("no user");
		}
	} else {
		die('error: ' . $conn->error);
	}

	mysqli_close($conn);
}


function signup($conn) {
	$image = $_POST['data']['img'];
	$id = $_POST['data']['id'];
	$fname = $_POST['data']['name'];
	$email = $_POST['data']['email'];
	$phone = $_POST['data']['phone'];
	$gender = $_POST['data']['gender'];
	$programme = $_POST['data']['program'];
	$year = $_POST['data']['year'];
	$nationality = $_POST['data']['nation'];
	$fTemplateId = (int)$_POST['data']['fTemplateId'];
	$password = md5($_POST['data']['pwd']);
	$vStatus = "none";

	$imgquery = "INSERT INTO img (id, image) VALUES ('', '$image')";

	if ($conn->query($imgquery)) {
    $last_id = $conn->insert_id;
	$query = "INSERT INTO user (id, fname, gender, email, phone, programme, nationality, year, password, vStatus, image, fTemplateId) VALUES ('$id', '$fname', '$gender', '$email', '$phone', '$programme', '$nationality', '$year', '$password', '$vStatus', '$last_id', '$fTemplateId')";
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
?>