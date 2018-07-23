<?php
// variable declaration
$dbhost = "localhost";
$username = "root";
$password = "";
$db = "studentcouncilvotingdb";

// connect to database
$conn = mysqli_connect($dbhost, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_SESSION['id'];

if($id == "admin"){
    $query = "SELECT * FROM user INNER JOIN img ON user.image = img.id WHERE user.fname = '$id'";
} else {
    $query = "SELECT * FROM user INNER JOIN img ON user.image = img.id WHERE user.id = '$id'";
}

if($results = $conn->query($query)){
    if($results->num_rows){
        while ($row = $results->fetch_assoc()) {
             echo "<img class='avatar border-gray' src='" . $row['image'] . "' alt='...'/>";
             echo "<h4 class='title'>" . $row['fname'] . "</h4>";
        }
    }
} else {
    die('error: ' . $conn->error);
}


mysqli_close($conn);
?>