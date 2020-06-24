<?php

session_start();
    
$link = mysqli_connect("localhost","root","","udemyfullstack"); 

if(mysqli_connect_error()){
    die("Not connected to MySQL Database. Error! :("."<br>");
}

$success1="";
$failure1=""; 
$success2="";
$failure2=""; 
$viewStatus=""; 
$viewStatus1="";

//REGISTERING NEW USER
    if(array_key_exists("registerOrEnterdata",$_POST)&&array_key_exists("username",$_POST)){
    $hello="heyyy";
    //Registering User Form with this extra flag
    if($_POST["registerOrEnterdata"] == '0'){

        //print_r ($_POST); 
        //echo "<br>";

        //Checking if username is already present in DB
        $checkUserQuery1 = "SELECT userid FROM healthtracker_users WHERE name ='".mysqli_real_escape_string($link,$_POST["username"])."'";
        //echo $checkUserQuery1;
        $result1 = mysqli_query($link,$checkUserQuery1);
        
        //Checks if there are rows where email is repeated
        if( mysqli_num_rows($result1) == 0){    
    
            $registerUserQuery = "INSERT INTO healthtracker_users (name) VALUES ('".mysqli_real_escape_string($link,$_POST["username"])."')"; 
            //echo $registerUserQuery;

            if (mysqli_query($link,$registerUserQuery)){
                //$success1 ="Username: '".$_POST["username"]."'<br>registered successfully :)"; 
                echo "<script type='text/javascript'>alert('Username `".$_POST["username"]."` registered successfully!'); </script>";
            } else {
                //$failure1 = "ERROR registering- SQL Error. <br>Please try again!";
                echo "<script type='text/javascript'>alert('ERROR registering- SQL Error. Please try again!'); </script>";                    
            }
        } else {
            //$failure1 = "Username already exists.<br> Please try with a different name!";
            echo "<script type='text/javascript'>alert('ERROR! Username already exists. Please try with a different name!'); </script>";
        }   
        //header("Location: #");          
    }        
}

//INSERTING NEW VALUE OF HEALTH PARAMETERS
if(array_key_exists("registerOrEnterdata",$_POST)&&array_key_exists("spo2input",$_POST)&&array_key_exists("regUserName",$_POST)){
    
    if($_POST["registerOrEnterdata"] == '1'){
        //print_r ($_POST);  
        //echo "<br>";

        $checkUserQuery2 = "SELECT userid FROM healthtracker_users WHERE name =('".$_POST["regUserName"]."')";
        //echo $checkUserQuery2;
        $result2 = mysqli_query($link,$checkUserQuery2);
        //print_r ($result2);
        $row1 = mysqli_fetch_array($result2);
        //print_r ($row1);
        //echo $row1["userid"];

        if($result2 =mysqli_query($link,$checkUserQuery2)){
             
            //$insertUserDataQuery = "INSERT INTO healthtracker_data (userid,dateofentry,spo2reading) VALUES (".$row1["userid"].",'".mysqli_real_escape_string($link,$_POST["date"])."',".mysqli_real_escape_string($link,$_POST["spo2input"]).")"; 
            $insertUserDataQuery = "INSERT INTO healthtracker_data (userid,dateofentry,timeofentry,spo2reading) VALUES (".$row1["userid"].",'".mysqli_real_escape_string($link,$_POST["date"])."','".mysqli_real_escape_string($link,$_POST["time"])."',".mysqli_real_escape_string($link,$_POST["spo2input"]).")"; 
            //echo $insertUserDataQuery;
            if (mysqli_query($link,$insertUserDataQuery)){
                //$success2 ="Data inserted successfully!"; 
                echo "<script type='text/javascript'>alert('Data inserted successfully!'); </script>";
            } else {
                //$failure2 = "ERROR-SQL inserting data. <br> Please enter valid data.";
                echo "<script type='text/javascript'>alert('ERROR entering data- SQL Error. Please try again!'); </script>";  
            }
        }
        //header("Location: #");
    }
}

//VIEW DATA/ VIEW GRAPH
if(array_key_exists("registerOrEnterdata",$_POST)&&array_key_exists("view",$_POST)&&array_key_exists("regUserName",$_POST)){
    //print_r ($_POST);    
    if($_POST["registerOrEnterdata"] == '2'){
    
        if($_POST["view"] == 'Data'){
            
            $viewStatus = 'Data';   

        }

        if($_POST["view"] == 'Graph'){

            $viewStatus = 'Graph'; 

        }
    }
}
?>