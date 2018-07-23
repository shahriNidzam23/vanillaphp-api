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
$yearElec = (string)date("Y");
$query = "SELECT * FROM candidate LEFT JOIN img ON candidate.image = img.id WHERE candidate.yElection = '$yearElec'";


$userquery = "SELECT * FROM user WHERE id='$id'";
if($results = $conn->query($userquery)){
    if($results->num_rows){
        while ($row = $results->fetch_assoc()) {
            $vstatus = $row["vStatus"];
        }
    }

}

if($results = $conn->query($query)){
    if($results->num_rows){
        ?>

        <div class="card">
        <ul id="tabs-list" class="tabs" data-persist="true">
        <?php
        $temp = $results;
        while ($row = $temp->fetch_assoc()) {
            ?>
                <li><a href="#<?php echo $row["studentID"] ?>" style="text-transform: uppercase;"><?php echo $row["fname"] ?></a></li>
            <?php
        }

        if($id == 'admin') {
            ?>
                <li id="plusTab"><a href="#viewPlus">+</a></li>
            <?php
        }

        ?>
        </ul>
        <div class="tabcontents" id="candidateProfileVote">
        <?php
        mysqli_data_seek($results, 0);
        while ($row = $results->fetch_assoc()) {
            ?>
            <div id="<?php echo $row["studentID"] ?>">
                <div class="card card-user">
                    <div class="image">
                        <img src="assets/img/back-1.jpg" alt="..."/>
                    </div>
                    <div class="content">
                        <div class="author">
                            <a>
                            <img class="avatar border-gray" src="<?php echo $row["image"] ?>" alt="..."/>

                            <h4 class="title"><?php echo $row["fname"] ?><small>(<?php echo $row["electionID"] ?>)</small><br />
                                <small><?php echo $row["slogan"] ?></small><br/>
                                <small><?php echo $row["programme"] ?></small><br/>
                                <small><?php echo $row["yStudy"] ?></small><br/>
                            </h4>
                            <!-- <pre><?php echo $row["aboutMe"] ?></pre> -->
                            </a>
                        </div>
                        <p class="description text-center"> 
                        </p>
                    </div>
                    <hr>
                    <?php 
                        if($id != "admin" && $vstatus == "none"){
                    ?>
                    <div class="text-center">
                        <button class="btn btn-simple" style="color:blue;text-transform: uppercase;" id="vote-button" ng-click="vote(<?php echo $row["studentID"] ?>, <?php echo $id ?>)">VOTE <?php echo $row["fname"] ?></button>
                    </div>
                    <?php
                    } else if($id == "admin") {
                    ?>
                    <div class="text-center">
                        <button class="btn btn-simple" style="color:green;text-transform: uppercase;" id="edit-button" ng-click="editModal(<?php echo $row["studentID"] ?>, '<?php echo $row["fname"] ?>')">EDIT <?php echo $row["fname"] ?></button>
                        <button class="btn btn-simple" style="color:red;text-transform: uppercase;" id="delete-button" ng-click="delete(<?php echo $row["studentID"] ?>, '<?php echo $row["fname"] ?>')">DELETE <?php echo $row["fname"] ?></button>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }

        ?>
        <?php 
            if($id == "admin"){
                ?>
                    <div id="viewPlus">
                        <h5 id="note" style="color: black"><strong>Note: Upload image size 120 pixel x 120 pixel</strong></h5>

                        <div class="form-group" id="img-group" style="text-align:center;">
                            <input type="file" name="myImg" id="imgUpload" ng-model="imgSrc" accept=".jpg" required>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-first-id">Matric ID</label>
                            <input type="text" name="r-form-first-id" placeholder="Matric ID" class="r-form-first-name form-control" id="r-form-first-id" ng-model="singupId">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-last-name">Full name</label>
                            <input type="text" name="r-form-last-name" placeholder="Full name" class="r-form-last-name form-control" id="r-form-last-name" ng-model="singupName">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-email">Gender</label>
                            <select class="form-control" id="r-form-gender" ng-model="singupGender">
                                <option value="" style="color:gray" disabled selected>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-email">Phone</label>
                            <input type="text" name="r-form-email" placeholder="Phone" class="r-form-email form-control" id="r-form-email" ng-model="singupPhone">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-email">Email</label>
                            <input type="text" name="r-form-email" placeholder="Email" class="r-form-email form-control" id="r-form-email" ng-model="singupEmail">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-programme">Programme</label>
                            <select class="form-control" id="r-form-programme" ng-model="singupProgram">
                                <option value="" disabled selected><font color="gray">Programme</font></option>
                                <option ng-repeat="item in programme" value="{{item}}">{{item}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-year">Year of Study</label>
                            <select class="form-control" id="r-form-year" ng-model="singupYear">
                                <option value="" disabled selected><font color="grey">Year of Study</font></option>
                                <option ng-repeat="item in year" value="{{item}}">{{item}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-nation">Nationality</label>
                            <select class="form-control" id="r-form-nation" ng-model="singupNation">
                                <option value="" disabled selected><font color="grey">Nationality</font></option>
                                <option ng-repeat="item in nation.data" value="{{item}}">{{item.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-last-name">Slogan (Not More than 25 words)</label>
                            <input type="text" name="r-form-last-name" placeholder="Slogan (Not More than 25 words)" class="r-form-last-name form-control" id="r-form-last-name" ng-model="singupSlogan">
                        </div>
                    <div class="text-center">
                        <button class="btn btn-simple" style="color:blue;text-transform: uppercase;" ng-click="registerCandidate()">Register Candidate</button>
                    </div>
                    </div>
                <?php
            }
        ?>
        </div>
        </div>
        <?php
    } else {
             if($id == 'admin') {
            ?>
                <div class="card">
                    <ul id="tabs-list" class="tabs" data-persist="true">
                    <li id="plusTab"><a href="#viewPlus">+</a></li>
                </ul>
                <div class="tabcontents" id="candidateProfileVote">
                    <div id="viewPlus">
                        <h5 id="note" style="color: black"><strong>Note: Upload image size 120 pixel x 120 pixel</strong></h5>

                        <div class="form-group" id="img-group" style="text-align:center;">
                            <input type="file" name="myImg" id="imgUpload" ng-model="imgSrc" accept=".jpg" required>
                        </div>
                        <br/>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-first-id">Matric ID</label>
                            <input type="text" name="r-form-first-id" placeholder="Matric ID" class="r-form-first-name form-control" id="r-form-first-id" ng-model="singupId">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-last-name">Full name</label>
                            <input type="text" name="r-form-last-name" placeholder="Full name" class="r-form-last-name form-control" id="r-form-last-name" ng-model="singupName">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-email">Gender</label>
                            <select class="form-control" id="r-form-gender" ng-model="singupGender">
                                <option value="" style="color:gray" disabled selected>Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-email">Phone</label>
                            <input type="text" name="r-form-email" placeholder="Phone" class="r-form-email form-control" id="r-form-email" ng-model="singupPhone">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-email">Email</label>
                            <input type="text" name="r-form-email" placeholder="Email" class="r-form-email form-control" id="r-form-email" ng-model="singupEmail">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-programme">Programme</label>
                            <select class="form-control" id="r-form-programme" ng-model="singupProgram">
                                <option value="" disabled selected><font color="gray">Programme</font></option>
                                <option ng-repeat="item in programme" value="{{item}}">{{item}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-year">Year of Study</label>
                            <select class="form-control" id="r-form-year" ng-model="singupYear">
                                <option value="" disabled selected><font color="grey">Year of Study</font></option>
                                <option ng-repeat="item in year" value="{{item}}">{{item}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-nation">Nationality</label>
                            <select class="form-control" id="r-form-nation" ng-model="singupNation">
                                <option value="" disabled selected><font color="grey">Nationality</font></option>
                                <option ng-repeat="item in nation.data" value="{{item}}">{{item.name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="r-form-last-name">Slogan (Not More than 25 words)</label>
                            <input type="text" name="r-form-last-name" placeholder="Slogan (Not More than 25 words)" class="r-form-last-name form-control" id="r-form-last-name" ng-model="singupSlogan">
                        </div>
                    <div class="text-center">
                        <button class="btn btn-simple" style="color:blue;text-transform: uppercase;" ng-click="registerCandidate()">Register Candidate</button>
                    </div>
                    </div>
                </div>

            <?php
            }

    }
} else {
    die('error: ' . $conn->error);
}


mysqli_close($conn);
?>