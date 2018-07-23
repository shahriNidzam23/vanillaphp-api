<?php
include 'config.php';
header('Content-Type: application/json');


switch ($_POST['functionname']) {
	case 'register':
		register($conn);
		break;
	case 'update':
		update($conn);
		break;
	case 'userProfile':
		userProfile($conn);
		break;
	case 'updateUser':
		updateUser($conn);
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
			echo json_encode("Data Inserted");
		} else {
		    echo json_encode("Error user: " . $conn->error);
		}

	} else {
	    echo json_encode("Error img: " . $conn->error);
	}

	mysqli_close($conn);
}

function update($conn) {
	$imageid = $_POST['data']['id'];
	$image = $_POST['data']['image'];
	$studentID = $_POST['data']['studentID'];
	$fname = $_POST['data']['fname'];
	$gender = $_POST['data']['gender'];
	$email = $_POST['data']['email'];
	$phone = $_POST['data']['phone'];
	$programme = $_POST['data']['programme'];
	$yStudy = $_POST['data']['yStudy'];
	$nationality = $_POST['data']['nationality'];
	$slogan = $_POST['data']['slogan'];

	$imgquery = "UPDATE img SET image = '$image' WHERE id = '$imageid'";

	if ($conn->query($imgquery)) {
		$query = "UPDATE candidate SET fname = '$fname', gender = '$gender', email = '$email', phone = '$phone', programme = '$programme', yStudy = '$yStudy', nationality = '$nationality', slogan = '$slogan' WHERE studentID = '$studentID'";
		if ($conn->query($query)) {
			echo json_encode("success");
		} else {
		    echo json_encode("Error user: " . $conn->error);
		}

	} else {
	    echo json_encode("Error img: " . $conn->error);
	}

	mysqli_close($conn);
}

function userProfile($conn) {
	$id = $_SESSION['id'];
	$query = "SELECT * FROM user INNER JOIN img ON user.image = img.id WHERE user.id = '$id'";
	if($results = $conn->query($query)){
	    if($results->num_rows){
	        while ($row = $results->fetch_assoc()) {
					$res[] = $row;
			}
			$res[0]["studentID"] = $id;
		    echo json_encode($res);

		}
	}

	mysqli_close($conn);
}

function updateUser($conn) {
	$imageid = $_POST['data']['id'];
	$image = $_POST['data']['image'];

	$studentID = $_POST['data']['studentID'];
	$fname = $_POST['data']['fname'];
	$gender = $_POST['data']['gender'];
	$email = $_POST['data']['email'];
	$phone = $_POST['data']['phone'];
	$programme = $_POST['data']['programme'];
	$year = $_POST['data']['year'];
	$nationality = $_POST['data']['nationality'];

	$imgquery = "UPDATE img SET image = '$image' WHERE id = '$imageid'";

	if ($conn->query($imgquery)) {
		$query = "UPDATE user SET fname = '$fname', gender = '$gender', email = '$email', phone = '$phone', programme = '$programme', nationality = '$nationality', year = '$year'WHERE id = '$studentID'";
		if ($conn->query($query)) {
			echo json_encode("success");
		} else {
		    echo json_encode("Error user: " . $conn->error);
		}

	} else {
	    echo json_encode("Error img: " . $conn->error);
	}

	mysqli_close($conn);
}
?>