<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png" />
</head>
<body>
    <?php
    include("../include/header.php");
    
    include("../include/connection.php");
    $doc = $_SESSION['doctor'];
    $query = "SELECT * FROM doctors WHERE username='$doc'";
    
    $res = mysqli_query($connect, $query);

    while($row = mysqli_fetch_array($res)){
        $username = $row['username'];
        $profiles = $row['profile'];
    }
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2" style="margin-left: -30px;">
                    <?php
                    include("sidenav.php");
                    ?>
                </div>
                <div class="col-md-10">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><?php echo $username; ?> Profile</h4>

                                <?php
                                if(isset($_POST['update'])){
                                    $profile = $_FILES['profile']['name'];

                                    if(empty($profile)){

                                    }else{
                                        $query = "UPDATE doctors SET profile='$profile' WHERE username='$doc'";

                                        $result = mysqli_query($connect, $query);
                                        
                                        if($result){
                                            move_uploaded_file($_FILES['profile']['tmp_name'], "img/$profile");
                                        }
                                    }
                                }
                                ?>

                                <form method="post"enctype="multipart/form-data">
                                <?php
                                echo "<img src='img/$profiles' class='col-md-12' style='height: 250px; width: 250px;'>";
                                
                                ?>    

                                <br><br>
                                <div class="form-group">
                                    <label>UPDATE PROFILE</label>
                                    <input type="file" name="profile" class="form-control">
                                </div>
                                <br>
                                <input type="submit" name="update" value="UPDATE" class="btn btn-success">
                                </form>
                            </div>
                            <div class="col-md-6">
                                <?php
                                
                                    if(isset($_POST['change'])){
                                        $uname = $_POST['uname'];

                                        if(empty($uname)){

                                        }else{
                                            $query = "UPDATE doctors SET username='$uname' WHERE username='$doc'";
                                            $res = mysqli_query($connect, $query);

                                            if($res){
                                                $_SESSION['doctor'] = $uname;
                                            }
                                        }
                                    }
                                ?>
                                <br>
                                <form method="post">
                                    <h5 class="text-center my-4">Update Username</h5>
                                    <label>Update Username</label>
                                    <input type="text" name="uname" class="form-control" autocomplete="off" placeholder="Username">
                                    <br>
                                    <input type="submit" name="change" class="btn btn-success" value="Update Username">
                                </form>
                                <br><br>


                                <?php
                                
                                if(isset($_POST['update_pass'])){
                                    $old_pass = $_POST['old_pass'];
                                    $new_pass = $_POST['new_pass'];
                                    $con_pass = $_POST['con_pass'];

                                    $error = array();

                                    $old = mysqli_query($connect, "SELECT * FROM doctors WHERE username='$doc'");

                                    $row = mysqli_fetch_array($old);
                                    $pass = $row['password'];

                                    if(empty($old_pass)){
                                        $error['p'] = "Enter Old Password";
                                    }else if(empty($new_pass)){
                                        $error['p'] = "Enter New Password";
                                    }else if(empty($con_pass)){
                                        $error['p'] = "Confirm Password";
                                    }else if($old_pass != $pass){
                                        $error['p'] = "Invalid Old Password";
                                    }else if($new_pass != $con_pass){
                                        $error['p'] = "Password does not match";
                                    }

                                    if(count($error) == 0){
                                        $query = "UPDATE doctors SET password='$new_pass' WHERE username='$doc'";

                                        mysqli_query($connect, $query);
                                    }

                                }

                                if(isset($error['p'])){
                                    $e = $error['p'];
                                    $show = "<h5 class='text-center alert alert-danger'>$e</h5>";
                                }else{
                                    $show="";
                                }


                                ?>

                                <form method="post">
                                    <h5 class="text-center my-4">Update Password</h5>
                                    <div>
                                        <?php
                                            echo $show;
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Old Password</label>
                                        <input type="password" name="old_pass" class="form-control" placeholder="Old Password">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password</label>
                                        <input type="password" name="new_pass" class="form-control" placeholder="New Password">
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="con_pass" class="form-control" placeholder="Confirm Password">
                                    </div>

                                    <input type="submit" name="update_pass" class="btn btn-info" value="Update Password">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</body>
</html>