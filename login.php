<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Login</title>

    
    
</head>
<body>
    <?php
    /* FOR INFORMATION SECURITY PROJECT */
    /* SQL INJECTION */
    /* VULNERABLE CODE*/

    
    session_start();

    $_SESSION["user"]="";
    $_SESSION["usertype"]="";
    
    date_default_timezone_set('Asia/Karachi');
    $date = date('Y-m-d');

    $_SESSION["date"]=$date;
    

    include("connection.php");

    
    if($_POST){

        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $result= $database->query("select * from webuser where email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype=='p'){
         
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){


              
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    
                    header('location: patient/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }elseif($utype=='a'){
                //TODO
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows==1){


                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    
                    header('location: admin/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }


            }elseif($utype=='d'){
                //TODO
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows==1){

                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');

                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }


        
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
    /* END OF VULNERABLE CODE */ 

    /* START OF SECURE CODE */
    /*
    if ($_POST) {

        $email = trim($_POST['useremail']); // Trim leading/trailing whitespace for better defense
        $password = $_POST['userpassword'];
    
        $error = '<label for="promter" class="form-label"></label>';
    
        $sql = "SELECT * FROM webuser WHERE email = ?"; // Prepared statement using placeholder
    
        $stmt = $database->prepare($sql); // Prepare the statement
        $stmt->bind_param('s', $email); // Bind the email parameter securely
        $stmt->execute(); // Execute the prepared statement
    
        $result = $stmt->get_result(); // Get the result
    
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $utype = $row['usertype'];
    
            if ($utype === 'p') {
                $sql_patient = "SELECT * FROM patient WHERE pemail = ? AND ppassword = ?";
                $stmt_patient = $database->prepare($sql_patient);
                $stmt_patient->bind_param('ss', $email, $password); // Bind both email and password
                $stmt_patient->execute();
    
                $result_patient = $stmt_patient->get_result(); // Get the result
    
                if ($result_patient->num_rows === 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'p';
                    header('location: patient/index.php');
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype === 'a') {
                // Similar logic with prepared statements for admin check
                $sql_admin = "SELECT * FROM admin WHERE aemail = ? AND apassword = ?";
                $stmt_admin = $database->prepare($sql_admin);
                $stmt_admin->bind_param('ss', $email, $password); // Bind both email and password
                $stmt_admin->execute();
    
                $result_admin = $stmt_admin->get_result(); // Get the result
    
                if ($result_admin->num_rows === 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'a';
                    header('location: admin/index.php');
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }
            } elseif ($utype === 'd') {
                // Similar logic with prepared statements for doctor check
                $sql_doctor = "SELECT * FROM doctor WHERE docemail = ? AND docpassword = ?";
                $stmt_doctor = $database->prepare($sql_doctor);
                $stmt_doctor->bind_param('ss', $email, $password); // Bind both email and password
                $stmt_doctor->execute();
    
                $result_doctor = $stmt_doctor->get_result(); // Get the result
    
                if ($result_doctor->num_rows === 1) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'd';
                    header('location: doctor/index.php');
                }else{
                    $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
                }

            }
            
        }else{
            $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant found any acount for this email.</label>';
        }


        
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
    /* END OF SECURE CODE*/ 

    ?>
     





    <center>
    <div class="container">
        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <p class="header-text">Welcome Back!</p>
                </td>
            </tr>
        <div class="form-body">
            <tr>
                <td>
                    <p class="sub-text">Login with your details to continue</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST">
                <td class="label-td">
                    <label for="useremail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <label for="userpassword" class="form-label">Password: </label>
                </td>
            </tr>

            <tr>
                <td class="label-td">
                    <input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
                </td>
            </tr>


            <tr>
                <td><br>
                <?php echo $error ?>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="submit" value="Login" class="login-btn btn-primary btn">
                </td>
            </tr>
        </div>
            <tr>
                <td>
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                    <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                    <br><br><br>
                </td>
            </tr>
                        
                        
    
                        
                    </form>
        </table>

    </div>
</center>
</body>
</html>
