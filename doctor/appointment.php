<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" text="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="shortcut icon" type="image/x-icon" href="../img/favicon.png" />
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
</head>
<body>
    <?php
    include("../include/header.php");
    include("../include/connection.php");

    $doc = $_SESSION['doctor'];
    $query = "SELECT * FROM doctors WHERE username='$doc'";
    $res = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($res);

    if(isset($_POST['add'])){

        $firstname = $_POST['fname'];
        $lastname = $_POST['sname'];
        $date = $_POST['date'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $addr = $_POST['address'];
        $phone = $_POST['phone'];
        $doct = $_POST['doct'];
        $visitno = $_POST['visitno'];
        $diag = $_POST['diagnosis'];
        $doc_id = $row['id'];

        $error = array();

        if(empty($firstname)){
            $error['add'] = "Enter Firstname";
        }else if(empty($date)){
            $error['add'] = "Enter Date";
        }else if(empty($age)){
            $error['add'] = "Enter Age";
        }else if(empty($addr)){
            $error['add'] = "Enter Address";
        }else if(empty($phone)){
            $error['add'] = "Enter Mobile Number";
        }else if(empty($diag)){
            $error['add'] = "Write Diagnosis";
        }

        if(count($error) == 0){
            $query = "INSERT INTO patients(firstname,lastname,gender,age,email,phone,doctor_id,doctor_username,doctor,visit_no,diagnosis,date_reg)
             VALUES ('$firstname','$lastname','$gender','$age','$email','$phone','$doc_id','$doc','$doct','$visitno','$diag','$date')";
            
            $result = mysqli_query($connect, $query);
            if($result){
                echo "<script>alert('Patient successfully Added')</script>";

                header("Location: index.php");
            }else{
                echo "<script>alert('Failed')</script>";
            }
        }
    }

    if(isset($error['add'])){
        $s = $error['add'];

        $show = "<h5 class='text-center alert alert-danger'>$s</h5>";
    }else{
        $show = "";
    }
    ?>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <!-- <div class="col-md-2" style="margin-left: -30px;"></div> -->
                
                <div class="col-md-12" style="margin-top: 40px;">
                    <div class="col-md-12">
                        <div class="col-md-11 jumbotron" style="left: 5%">
                            <div class="row">
                                <div class="row register-left mx-2" style="color: #03045e; display: flex; justify-text: center; align-items: center; "> 
                                <h3><?php echo $row['hospital']; ?></h3>
                                </div>
                                <div class="col-sm-6 register-right mx-1" style="left: 50%;">
                                <i class="fa-solid fa-hospital fa-3x"></i>
                                </div>
                            </div>
                            <hr style="background-color: gray">
                            <div>
                                <?php echo $show; ?>
                            </div>
                            
                            <form method="post" id="add-patient">
                                <div class="form-group" style="color: #03045e">
                                    <label>Patient Name:</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                        <input type="text" name="fname" class="form-control" autocomplete="off" placeholder="Firstname" value="<?php if(isset($_POST['fname'])) echo $_POST['fname']; ?>">
                                        </div>
                                        <div class="col-md-5">
                                        <input type="text" name="sname" class="form-control" style="display: flex;" autocomplete="off" placeholder="Lastname" value="<?php if(isset($_POST['sname'])) echo $_POST['sname']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label>Date of examination:</label>
                                            <input type="date" name="date" class="form-control" autocomplete="off" placeholder="Date" value="<?php if(isset($_POST['date'])) echo $_POST['date']; ?>">
                                        </div>
                                        <div class="col-md-5">
                                            <label>Age:</label>
                                            <input type="number" name="age" class="form-control" autocomplete="off" placeholder="Age" value="<?php if(isset($_POST['age'])) echo $_POST['age']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <label>Weight</label>
                                            <input type="text" name="weight" class="form-control" autocomplete="off" placeholder="Weight" value="<?php if(isset($_POST['weight'])) echo $_POST['weight']; ?>">
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Select Gender</label>
                                    <input type="radio" name="gender" value="Male" checked> Male
                                    <input type="radio" name="gender" value="Female"> Female
                                </div>
                                <div class="form-group" style="color: #03045e">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" autocomplete="off" placeholder="Address" value="<?php if(isset($_POST['address'])) echo $_POST['address']; ?>">
                                </div>
                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" autocomplete="off" placeholder="Email Address" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Mobile Number</label>
                                            <input type="number" name="phone" class="form-control" autocomplete="off" placeholder="Mobile Number" value="<?php if(isset($_POST['phone'])) echo $_POST['phone']; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Doctor Name</label>
                                            <input type="text" name="doct" class="form-control" autocomplete="off" placeholder="Doctor Name" value="<?php if(isset($_POST['doct'])) echo $_POST['doct']; else echo $row['firstname']." ".$row['lastname']; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Visit No.</label>
                                            <input type="number" name="visitno" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['visitno'])) echo $_POST['visitno']; else echo 1;?>">
                                        </div>
                                    </div>
                                </div>
                                <hr style="background-color:gray">
                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <label>Chief Complaint</label>
                                            <input type="text" name="complaint" class="form-control" autocomplete="off" placeholder="Chief Complaint" value="<?php if(isset($_POST['complaint'])) echo $_POST['complaint']; ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label>H/o</label>
                                            <input type="text" name="ho" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['ho'])) echo $_POST['ho']; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>History of present illness:</label>
                                    <input type="text" name="investigation" class="form-control" autocomplete="off" placeholder="History" value="<?php if(isset($_POST['investigation'])) echo $_POST['investigation']; ?>">
                                </div>

                                                               

                                <h4>Pain History</h4>
                                <hr style="background-color: gray">
                                <div class="form-group" style="color: #03045e">
                                    <div class="row" style="margin-left:10rem;">
                                        <div class="col-md-3">
                                            <label>Site: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Onset: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <select name="onset" class="form-control">
                                                <option></option>
                                                <option>Sudden</option>
                                                <option>Gradual</option>
                                            </select>
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Type: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="type" class="form-control">
                                                <option></option>
                                                <option>Acute</option>
                                                <option>Subacute</option>
                                                <option>Chronic</option>
                                            </select>
                                        </div><br><br>
                                        

                                        <div class="col-md-3">
                                            <label>Nature: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="nature" class="form-control">
                                                <option></option>
                                                <option>Sharp pain</option>
                                                <option>Burning pain</option>
                                                <option>Stabbing pain</option>
                                                <option>Cramping pain</option>
                                                <option>Throbbing pain/ Pulsating</option>
                                                <option>Dull aching pain</option>
                                            </select>
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Duration: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Since" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Progression: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="progression" class="form-control">
                                                <option></option>
                                                <option>Non-progressive</option>
                                                <option>Increasing with time</option>
                                                <option>Decreasing with time</option>
                                            </select>                         
                                       </div><br><br>

                                        <div class="col-md-3">
                                            <label>Radiation: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="radiation" class="form-control">
                                                <option></option>
                                                <option>Radiating</option>
                                                <option>Non-radiating</option>
                                            </select> 
                                     </div><br><br>

                                        <div class="col-md-3">
                                            <label>Quantity: </label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="range" id="quantity" name="quantity" min="0" max="100" required>
                                            <span id="quantity-value">0</span>
                                       </div>

                                        <div class="col-md-3">
                                            <label>Aggravating Factor: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Relieving Factor: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Medical History: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                          <select name="medical history" class="form-control">
                                                <option placeholder="Know case of-"></option>
                                                <option>None</option>
                                                <option>Diabetes</option>
                                                <option>Hypertension</option>
                                                <option>Hyperthyroidism</option>
                                                <option>Hypothyroidism</option>
                                                <option>Stable angina</option>
                                                <option>Tuberculosis</option>
                                                <option>Unstable angina</option>
                                            </select>
                                         </div><br><br>

                                        <div class="col-md-3">
                                            <label>Drug History: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>
                                        
                                    </div>
                                </div>

                                <h4>Examination</h4>
                                <hr style="background-color: gray">
                                <div class="form-group" style="color: #03045e">
                                    <div class="row" style="margin-left:10rem;">
                                        <div class="col-md-3">
                                            <label>Temperature: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Temperature" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Blood Pressure:</label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Blood Pressure" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Respiratory rate: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Respiratory rate" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Pulse rate: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Pulse rate" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Attitude of limb: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Attitude of limb" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Muscle tone: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="muscle tone" class="form-control">
                                                <option></option>
                                                <option>Normal</option>
                                                <option>Flaccid</option>
                                                <option>Spastic</option>
                                            </select>
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Swelling: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="swelling" class="form-control">
                                                <option></option>
                                                <option>Not present</option>
                                                <option>Present</option>
                                            </select> 
                                       </div><br><br>

                                        <div class="col-md-3">
                                            <label>Skin condition: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="Skin condition" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Scar: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                          <select name="scar" class="form-control">
                                                <option></option>
                                                <option>Not present</option>
                                                <option>Present</option>
                                            </select>
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Tenderness: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="scar" class="form-control">
                                                <option></option>
                                                <option>Grade1- No pain</option>
                                                <option>Grade2- Patient complains of pain and winces</option>
                                                <option>Grade3- Patient complains of pain and withdraws</option>
                                                <option>Grade4- Patient will not allow palpation of the joint</option>
                                            </select>
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Trigger point: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="scar" class="form-control">
                                                <option></option>
                                                <option>Not present</option>
                                                <option>Present</option>
                                            </select>
                                        </div><br><br>

                                        <div class="col-md-3">
                                            <label>Crepitus: </label>
                                        </div>  
                                        <div class="col-md-7">  
                                           <select name="scar" class="form-control">
                                                <option></option>
                                                <option>Not present</option>
                                                <option>Present</option>
                                            </select>      
                                        <div><br><br>
                                        
                                    </div>
                                </div>
                           </div>
                                <h4>Assesment</h4>
                                <hr style="background-color: gray">
                                <div class="form-group" stylr="color: #03045e">
                                    <div class="shoulder">
                                        <h5 style="color:green;">Shoulder joint</h5>
                                        <div class="table" style="margin-left:10rem;">
                                            <table>
                                               <tr>
                                                  <th style="align-text:right;">Range of motion</th> 
                                                  <th style="align-text:right;">Rt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                                  <th></th>
                                                  <th style="align-text:right;">Normal</th>
                                                  <th style="align-text:right;">Lt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                               </tr>

                                               <tr>
                                                  <td style="align-text:right;">Flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-180</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                               </tr>

                                                <tr>
                                                  <td style="align-text:right;">Extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-60</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Ext.rotation</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-90</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Int.rotation</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-70</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Abduction</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-180</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Adduction</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-50</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <td>End range:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Normal-Bone to Bone</option>
                                                     <option>Normal-soft tissue approximate</option>
                                                     <option>Normal-Tissue stretch</option>
                                                     <option>Abnormal-Muscular spasm</option>
                                                     <option>Abnormal-Hard capsular</option>
                                                     <option>Abnormal-Soft capsular</option>
                                                     <option>Abnormal-Bone to Bone</option>
                                                     <option>Abnormal-Springy Block</option>
                                                  </td>
                                                </tr>
                                               <tr>
                                                    <td>Positive special Test:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Neer's Test-Shoulder impingement</option>
                                                     <option>Hawkins-Kennedy Test-Shoulder impingement</option>
                                                     <option>Empty can test-Supraspinatus muscle</option>
                                                     <option>Drop arm test-Rotator cuff tear</option>
                                                     <option>Yergason's test-Biceps tendon</option>
                                                     <option>Apperehension test-Glenohumeral instability</option>
                                                    </td>
                                              </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="Elbow joint">
                                        <h5 style="color:green;">Elbow joint</h5>
                                        <div class="table" style="margin-left:10rem;">
                                            <table>
                                               <tr>
                                                  <th style="align-text:right;">Range of motion</th> 
                                                  <th style="align-text:right;">Rt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                                  <th></th>
                                                  <th style="align-text:right;">Normal</th>
                                                  <th style="align-text:right;">Lt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                               </tr>

                                               <tr>
                                                  <td style="align-text:right;">Flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-150</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                               </tr>

                                                <tr>
                                                  <td style="align-text:right;">Extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <td>End range:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Normal-Bone to Bone</option>
                                                     <option>Normal-soft tissue approximate</option>
                                                     <option>Normal-Tissue stretch</option>
                                                     <option>Abnormal-Muscular spasm</option>
                                                     <option>Abnormal-Hard capsular</option>
                                                     <option>Abnormal-Soft capsular</option>
                                                     <option>Abnormal-Bone to Bone</option>
                                                     <option>Abnormal-Springy Block</option>
                                                  </td>
                                               </tr>

                                               <tr>
                                                    <td>Positive special Test:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Tinel's sign-Ulnar nerve compression</option>
                                                     <option>Cozen's test-Lateral epicondiylitis</option>
                                                     <option>Mill's test-Lateral epicondylitis</option>
                                                     <option>Golfer's elbow test-Medial epicondylitis</option>
                                                  </td>
                                              </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="Wrist joint & Hand">
                                        <h5 style="color:green;">Wrist joint & Hand</h5>
                                        <div class="table" style="margin-left:10rem;">
                                            <table>
                                               <tr>
                                                  <th style="align-text:right;">Range of motion</th> 
                                                  <th style="align-text:right;">Rt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                                  <th></th>
                                                  <th style="align-text:right;">Normal</th>
                                                  <th style="align-text:right;">Lt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                               </tr>

                                               <tr>
                                                  <td style="align-text:right;">Flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-80</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                               </tr>

                                                <tr>
                                                  <td style="align-text:right;">Extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-70</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Radial deviation</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-20</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Ulnar deviation</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-30</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Finger flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-90</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Finger extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-10</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <td>End range:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Normal-Bone to Bone</option>
                                                     <option>Normal-soft tissue approximate</option>
                                                     <option>Normal-Tissue stretch</option>
                                                     <option>Abnormal-Muscular spasm</option>
                                                     <option>Abnormal-Hard capsular</option>
                                                     <option>Abnormal-Soft capsular</option>
                                                     <option>Abnormal-Bone to Bone</option>
                                                     <option>Abnormal-Springy Block</option>
                                                  </td>
                                               </tr>

                                               <tr>
                                                    <td>Positive special Test:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Phalen's test-carpal tunnel syndrome</option>
                                                     <option>Tinel's test-carpal tunnel syndrome</option>
                                                     <option>Finkelstein test-De Quervain's tenosynovitis</option>
                                                     <option>Allen's test-Vascular insufficiency</option>
                                                     <option>Froment's test-Ulnar nerve palsy</option>
                                                  </td>
                                               </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="Hip joint">
                                        <h5 style="color:green;">Hip joint</h5>
                                        <div class="table" style="margin-left:10rem;">
                                            <table>
                                               <tr>
                                                  <th style="align-text:right;">Range of motion</th> 
                                                  <th style="align-text:right;">Rt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                                  <th></th>
                                                  <th style="align-text:right;">Normal</th>
                                                  <th style="align-text:right;">Lt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                               </tr>

                                               <tr>
                                                  <td style="align-text:right;">Flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-120</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                               </tr>

                                                <tr>
                                                  <td style="align-text:right;">Extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-30</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Ext.rotation</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-45</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Int.rotation</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-40</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Abduction</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-45</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Adduction</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-30</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <td>End range:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Normal-Bone to Bone</option>
                                                     <option>Normal-soft tissue approximate</option>
                                                     <option>Normal-Tissue stretch</option>
                                                     <option>Abnormal-Muscular spasm</option>
                                                     <option>Abnormal-Hard capsular</option>
                                                     <option>Abnormal-Soft capsular</option>
                                                     <option>Abnormal-Bone to Bone</option>
                                                     <option>Abnormal-Springy Block</option>
                                                  </td>
                                              </tr>

                                               <tr>
                                                    <td>Positive special Test:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Thomas test-Hip flexor contractures</option>
                                                     <option>Trendelenberg test-Glutens medius weakness</option>
                                                     <option>Ober's test-iliotibial band tightness</option>
                                                     <option>Faber test-SI joint pathology</option>
                                                     <option>Straight Leg Raise-Sciatic nerve irritation</option>
                                                  </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="Knee joint">
                                        <h5 style="color:green;">Knee joint</h5>
                                        <div class="table" style="margin-left:10rem;">
                                            <table>
                                               <tr>
                                                  <th style="align-text:right;">Range of motion</th> 
                                                  <th style="align-text:right;">Rt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                                  <th></th>
                                                  <th style="align-text:right;">Normal</th>
                                                  <th style="align-text:right;">Lt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                               </tr>

                                               <tr>
                                                  <td style="align-text:right;">Flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-135</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                               </tr>

                                                <tr>
                                                  <td style="align-text:right;">Extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-15</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <td>End range:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Normal-Bone to Bone</option>
                                                     <option>Normal-soft tissue approximate</option>
                                                     <option>Normal-Tissue stretch</option>
                                                     <option>Abnormal-Muscular spasm</option>
                                                     <option>Abnormal-Hard capsular</option>
                                                     <option>Abnormal-Soft capsular</option>
                                                     <option>Abnormal-Bone to Bone</option>
                                                     <option>Abnormal-Springy Block</option>
                                                  </td>
                                                </tr>

                                               <tr>
                                                    <td>Positive special Test:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>McMurray test-Meniscal tear</option>
                                                     <option>Lachman test-ACL integrity</option>
                                                     <option>Anterior drawer test-ACL integrity</option>
                                                     <option>Posterior drawer test-PCL integrity</option>
                                                     <option>Varus Stress test-MCL integrity</option>
                                                     <option>valgus Stress test-LCL integrity</option>
                                                   </td>
                                              </tr>

                                            </table>
                                        </div>
                                    </div>


                                    <div class="Ankle joint & Toe">
                                        <h5 style="color:green;">Ankle joint & Toe</h5>
                                        <div class="table" style="margin-left:10rem">
                                            <table>
                                               <tr>
                                                  <th style="align-text:right;">Range of motion</th> 
                                                  <th style="align-text:right;">Rt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                                  <th></th>
                                                  <th style="align-text:right;">Normal</th>
                                                  <th style="align-text:right;">Lt side</th>
                                                  <th style="align-text:left;">MMT</th>
                                               </tr>

                                               <tr>
                                                  <td style="align-text:right;">Dorsiflexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-20</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                               </tr>

                                                <tr>
                                                  <td style="align-text:right;">Plantarflexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-50</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Inversion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-35</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Eversion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-20</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Toe flexion</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-90</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                  <td style="align-text:right;">Toe extension</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;"value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                  <td></td>
                                                  <td style="align-text:right;">0-20</td>
                                                  <td><input type="text" name="t1" class="form-control" style="max-width:8rem; align-text:right;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>"></td>
                                                  <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                                </tr>

                                                <tr>
                                                    <td>End range:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Normal-Bone to Bone</option>
                                                     <option>Normal-soft tissue approximate</option>
                                                     <option>Normal-Tissue stretch</option>
                                                     <option>Abnormal-Muscular spasm</option>
                                                     <option>Abnormal-Hard capsular</option>
                                                     <option>Abnormal-Soft capsular</option>
                                                     <option>Abnormal-Bone to Bone</option>
                                                     <option>Abnormal-Springy Block</option>
                                                  </td>
                                              </tr>

                                               <tr>
                                                    <td>Positive special Test:</td>
                                                    <td colspan="3"><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Thompson test-Achilles tendon rupture</option>
                                                     <option>Talar tilt test-Lateral ankle ligament integrity</option>
                                                     <option>Anterior drawer test(ankle)-Anterior talofibular integrity</option>
                                                     <option>Plantar fasciitis test-Plantar fasciitis</option>
                                                     <option>Mulder's Sign-Morton's neuroma</option>
                                                    </td>
                                               </tr>

                                            </table>
                                        </div>
                                    </div>

                                    <div class="Cranial nerve examination">
                                        <div style="color:green;">
                                          <h5>Cranial nerve examination</h5>                                            
                                        </div>

                                        <table class="col-md-10" style="margin-left:10rem;">
                                            <tr>
                                              <th>Testing</th>
                                              <th>Impaired cranial nerves</th>
                                            </tr>
                                            <tr>
                                                <td>Odour identification</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 1-Olfactory nerve </td>
                                            </tr>
                                            <tr>
                                                <td>Visual field testing</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 2-Optic</td>
                                            </tr>
                                            <tr>
                                                <td>Extraoccular movement</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 3,4,6-Oculomotor,Trochlear,Abducens nerve</td>
                                            </tr>
                                            <tr>
                                                <td>Face sensation,Jaw jerk</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 5-Trigeminal nerve </td>
                                            </tr>
                                            <tr>
                                                <td>Smile,Frown,Sad face</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 7-Facial nerve </td>
                                            </tr>
                                            <tr>
                                                <td>Romberg test,hearing test</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 8-Vestibulocochlear nerve </td>
                                            </tr>
                                            <tr>
                                                <td>Gag reflex</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 9,10-Glossopharyngeal,Vagus </td>
                                            </tr>
                                            <tr>
                                                <td>Shoulder shrug,Head rotation</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 11-Acessory nerve </td>
                                            </tr>
                                            <tr>
                                                <td>Tongue strength and movement</td>
                                                <td><input type="checkbox" name="checkbox" value="<?php if(isset($_POST['checkbox'])) echo $_POST['checkbox']; ?>">CN 12-Hypoglossal nerve </td>
                                            </tr>
                                        </table>
                                    </div><br><br>

                                    <div class="flex" style="display:flex; justify-content:space-between;">
                                        <div class="Sensory examination">
                                        <h4 style="color:green;">Sensory examination</h4>
                                        <table style="margin-left:10rem;">
                                            <tr>
                                                <th>Superficial Sensations</th>
                                            </tr>
                                            <tr>
                                                <td>Touch</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                            <tr>
                                                <td>Pain</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                            <tr>
                                                <td>Temperature</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                            <tr>
                                                <th>Deep Sensation</th>
                                            </tr>
                                            <tr>
                                                <td>Proprioception</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                            <tr>
                                                <td>Pressure</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                            <tr>
                                                <td>Kinesthesia</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                            <tr>
                                                <td>Vibration</td>
                                                <td><select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>0</option>
                                                     <option>1</option>
                                                     <option>2</option>
                                                     <option>3</option>
                                                     <option>4</option>
                                                     <option>5</option>
                                                  </td>
                                            </tr>
                                        </table>                                        
                                        </div>

                                        <div class="Motor examination">
                                            <h4 style="color:green;">Motor examination</h4>
                                            <table>
                                                <tr>
                                                    <th>Muscle tone:</th>
                                                    <td>
                                                    <select class="form-control" style="align-text:center;" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                                     <option></option>
                                                     <option>Flaccidity</option>
                                                     <option>Hypotonia</option>
                                                     <option>Normal</option>
                                                     <option>Mild hypertonia</option>
                                                     <option>Severe hypertonia</option>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Myotome:</th>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C1/C2-Neck flexion/extension </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C3-neck lateral flexion </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C4-Shoulder elevation </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C5-Shoulder </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C6-Elbow flexion/Wrist extension </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C7-Elbow extension/Wrist flexion</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">C8-Ulnar deviation,Thumb extension </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">T1-Finger abduction</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">L2-Hip flexion</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">L3-Knee flexion</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">L4-Ankle dorsiflexion</td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">L5-Great toe extension </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">S1-Ankle plantarflexion </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox">S2-Knee flexion</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <div class="investigations">
                                   <h4 style="color:gray">Investigations</h4><br>
                                   <div style="margin-left:10rem;">
                                   <input type="checkbox" name="checkbox">X-ray <br>
                                   <input type="checkbox" name="checkbox">MRI <br>
                                   <input type="checkbox" name="checkbox">CT-SCAN <br><br>
                                   <div class="col-md-7">
                                      <input type="text" class="form-control" placeholder="finding shows...">
                                    </div>
                                   </div>
                                </div>

                                <div class="diagnosis">
                                    <h4 style="color:gray;">Diagnosis</h4><br>
                                    <div class="col-md-7" style="margin-left:10rem;">
                                      <input type="text" class="form-control" placeholder="Diagosis">
                                    </div>
                                </div><br><br>

                                <h4>Treatment</h4>
                                <hr style="background-color: gray">
                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="icepack" value="<?php if(isset($_POST['icepack'])) echo $_POST['icepack']; ?>">
                                        <label> ICE PACK</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t1" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t1'])) echo $_POST['t1']; ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="hotpack" value="<?php if(isset($_POST['hotpack'])) echo $_POST['hotpack']; ?>">
                                        <label> HOT PACK</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t2" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t2'])) echo $_POST['t2']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="tens" value="<?php if(isset($_POST['tens'])) echo $_POST['tens']; ?>">
                                        <label> T.E.N.S</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t3" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t3'])) echo $_POST['t3']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="ultrasound" value="<?php if(isset($_POST['ultrasound'])) echo $_POST['ultrasound']; ?>">
                                        <label> ULTRASOUND</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t4" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t4'])) echo $_POST['t4']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="ift" value="<?php if(isset($_POST['ift'])) echo $_POST['ift']; ?>">
                                        <label> I.F.T</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t5" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t5'])) echo $_POST['t5']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="fems" value="<?php if(isset($_POST['fems'])) echo $_POST['fems']; ?>">
                                        <label> FARADIC EMS</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t6" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t6'])) echo $_POST['t6']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="gems" value="<?php if(isset($_POST['gems'])) echo $_POST['gems']; ?>">
                                        <label> GALVANIC EMS</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t7" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t7'])) echo $_POST['t7']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="mat" value="<?php if(isset($_POST['mat'])) echo $_POST['mat']; ?>">
                                        <label> MATRIX</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t8" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t8'])) echo $_POST['t8']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="pmvm" value="<?php if(isset($_POST['pmvm'])) echo $_POST['pmvm']; ?>">
                                        <label> PASSIVE MOVEMENTS</label><br>
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t9" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t9'])) echo $_POST['t9']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="color: #03045e">
                                    <div class="row">
                                        <div class="col-md-3">
                                        <input type="checkbox" name="other" value="<?php if(isset($_POST['other'])) echo $_POST['other']; ?>">
                                        <label> OTHER</label><br>
                                        </div>
                                        <div class="col-md-5">
                                            <label>Specify: </label>
                                            <input type="text" name="otmt" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['otmt'])) echo $_POST['otmt']; ?>">
                                        </div>
                                        <div class="col-md-3">
                                            <label>time: </label>
                                            <input type="text" name="t9" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['t9'])) echo $_POST['t9']; ?>">
                                        </div>
                                    </div>
                                </div>

                                <h4>Exercises</h4>
                                <hr style="background-color: gray">
                                <div class="form-group" style="color: #03045e">
                                    <input type="checkbox" name="neck" value="Neck">
                                    <label> Neck</label><br>
                                    <input type="checkbox" name="shoulder" value="Shoulder">
                                    <label> Shoulder</label><br>
                                    <input type="checkbox" name="elbow" value="Elbow">
                                    <label> Elbow</label><br>
                                    <input type="checkbox" name="forearm" value="Forearm">
                                    <label> Forearm</label><br>
                                    <input type="checkbox" name="wrist" value="Wrist">
                                    <label> Wrist</label><br>
                                    <input type="checkbox" name="fingers" value="Fingers">
                                    <label> Fingers</label><br>
                                    <input type="checkbox" name="back" value="Back">
                                    <label> Back</label><br>
                                    <input type="checkbox" name="core" value="Core">
                                    <label> Core</label><br>
                                    <input type="checkbox" name="hip" value="Hip">
                                    <label> Hip</label><br>
                                    <input type="checkbox" name="knee" value="Knee">
                                    <label> Knee</label><br>
                                    <input type="checkbox" name="ankle" value="Ankle">
                                    <label> Ankle</label><br>
                                    <input type="checkbox" name="toes" value="Toes">
                                    <label> Toes</label><br>
                                </div>
                           </div>

                         <h4>Follow Up</h4>
                            <hr style="background-color: gray">
                            <div class="form-group" style="color: #03045e">
                                <input type="text" name="followup" class="form-control" autocomplete="off" placeholder="" value="<?php if(isset($_POST['followup'])) echo $_POST['followup']; ?>">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4" style="left: 5%">
                                <input type="submit" form = "add-patient" name="add" class="btn btn-success download-btn" value="Download as PDF">
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const downloadBtn = document.querySelector(".download-btn");

        downloadBtn.addEventListener("click", () => {
            window.print();

        
            //----------Method2----------//
            // var divId = "appointment-form";
            // var printtexts = document.getElementById(divId).innerHTML;
            // var originaltexts = document.body.innerHTML;
            // document.body.innerHTML = printtexts;
            // window.print();
            // document.body.innerHTML = originaltexts;
        
        });

        document.getElementById('quantity').addEventListener('input', updateValue);
        function updateValue() {
            const input = this;
            const span = input.nextElementSibling;
            span.textContent = input.value;
        }
    </script>
</body>
</html>