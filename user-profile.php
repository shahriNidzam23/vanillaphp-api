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
$query = "SELECT * FROM user INNER JOIN img ON user.image = img.id WHERE user.id = '$id'";
if($results = $conn->query($query)){
    if($results->num_rows){
        while ($row = $results->fetch_assoc()) {
            ?>
                <div class="image">
                    <img src="assets/img/profile-bg.jpg" alt="..."/>
                </div>
                <div class="content">
                    <div class="author">
                         <a>
                          <img id="imgUser" class="avatar border-gray" src="<?php echo $row['image'] ?>" alt="..."/>

                          <h4 class="title" id="user-detail"><?php echo $row['fname'] ?><br />
                            <small><?php echo $id ?></small> <br/>
                             <small><?php echo $row['programme'] ?></small> <br/>
                             <small><?php echo $row['year'] ?></small>
                          </h4>
                        </a>
                    </div>
                </div>
            <?php
        }
    }

}


mysqli_close($conn);
?>