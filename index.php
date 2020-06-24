<?php  
    include 'src/backend.php';
?>

<html lang="en">
    <head>
        <title>Health SpO2 Tracker</title> 
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 

        <!-- Local packages -->
        <!-- jQuery -->
            <script src="src/jquery-3.5.1.min.js"></script>
        <!-- jQuery UI -->                        
            <link href="src/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
            <script src="src/jquery-ui-1.12.1/jquery-ui.js"></script> 
        <!-- jQueryUI Time Picker jonthornton-->
            <link rel="stylesheet" href="src/jonthornton-jquery-timepicker/jquery.timepicker.css">
            <script src="src/jonthornton-jquery-timepicker/jquery.timepicker.min.js"></script>
        <!-- ChartJS -->
            <script src="src/Chart.js/Chart.bundle.js"></script> 
        <!-- Bootstrap CSS, PopperJS, Bootstrap JS -->
            <link rel="stylesheet" href="src/bootstrap-4.5.0-dist/css/bootstrap.min.css">
            <script src="src/popper.min.js"></script>
            <script src="src/bootstrap-4.5.0-dist/js/bootstrap.min.js"></script>   
        <link rel="stylesheet" type="text/css" href="css/style.css">    
    </head>

    <body>
        <div class="container">
            <h2><b>SpO2 (Oxy Saturation)</b></h2>
            <h3><b>Monitoring & Tracking</b></h3>
            <p> &copy;Jithin Saji Isaac (June 2020)<br>
            <a href="https://github.com/jithinsisaac"><img src="images/GitHub-Mark-32px.png" alt="" width="20" height="20"></a>
            <a href="https://jithinisaac.dblabs.in"><img src="images/web.png" alt="" width="20" height="20"></a>  
            </p>
            <h4><span class="badge badge-danger">Testing: User Auth not implemented</span></h4>
            <br>

            <!-- USER REGISTRATION BUTTON-->
            <div class="form-group row d-flex justify-content-center">                            
                <div class="col-sm-4 align-self-center">
                    <label for="InputName" ><b> New User?  </b></label>  
                    <button class="btn btn-warning border border-danger" type="button"   data-target="#adduser"  id="adduserButton">
                        <b>Register</b>                     
                    </button>
                </div>        
            </div> 

            <!-- USER REGISTRATION FORM -->
            <div id="adduser">
                <div class="card-transparent card-body">
                    <form action="" method="POST" id="adduserForm" name="registerForm" onsubmit="return validateForm1()">
                        <div class="form-group row d-flex justify-content-center">
                            <div class="col-sm-3 align-self-center row d-flex justify-content-center"> 
                                <input type="text" class="form-control" id="adduserInput" name="username" placeholder="Enter an username">
                                <small id="pwdHelp" class="form-text text-muted">Valid characters: A-Z,a-z,0-9,._@</small>
                            </div>
                            <div class="form-group">
                                    <input type="hidden" name="registerOrEnterdata" value=0>
                            </div>
                        </div> 
                        <button type="submit" class="btn btn-danger btnboundary" onclick="return regUserMessage()">Submit</button> 
                    </form>
                </div>
            </div>              

            <!-- ERROR FOR USER REGISTRATION FORM-->
            <div id="error1">
                <?php
                    if($success1){
                        echo '<div class="alert alert-success col-sm-5 mx-auto" role="alert"><b>'.$success1.'</b></div>';
                    } 
                    if($failure1){
                        echo '<div class="alert alert-danger col-sm-5 mx-auto" role="alert"><b>'.$failure1.'</b></div>';
                    }            
                ?>
            </div>

            <!-- ENTER & TRACK VITALS BUTTONS-->
            <p>
                <button class="btn btn-dark" type="button" id="enterButton">
                  Enter your vitals
                </button>
                <button class="btn btn-dark" type="button" id="trackButton">
                  Track your vitals
                </button>
            </p>

            <!-- ERROR FOR USER SP02 ENTRY -->
            <div id="error2">
                <?php
                    if($success2){
                        echo '<div class="alert alert-success col-sm-3 mx-auto" role="alert"><b>'.$success2.'</b></div>';
                    } 
                    if($failure2){
                        echo '<div class="alert alert-danger col-sm-3 mx-auto" role="alert"><b>'.$failure2.'</b></div>';
                    }            
                ?>
            </div>

            <!-- ENTER YOUR VITALS FORM-->
            <div  id="collapseExample1">
                <div class="card-transparent card-body initDivs">
                    <form method="POST" name="spo2enterForm" onsubmit="return validateForm2()">
                        <div class="form-group row d-flex justify-content-center">                            
                            <div class="col-sm-4 align-self-center">   
                                <?php
                                    //For Drop Down list of registered users
                                    $dropdownUserListQuery = "SELECT name FROM healthtracker_users"; 
                                    $result2 = mysqli_query($link,$dropdownUserListQuery);
                                    echo '<select name="regUserName" id="regUserName1" class="form-control"> <option value="" selected>Select username, if registered<br></option>';
                                    if ($result2 = mysqli_query($link,$dropdownUserListQuery)){    
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                ?>
                            </div>        
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="registerOrEnterdata" value=1>
                        </div>

                        <!-- Date picker by choosing from dropdown which is cumbersome -->
                        <!-- <div class="form-group row d-flex justify-content-center">
                            <div class="col-sm-3 align-self-center   row d-flex justify-content-center">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@Date</div>
                                    </div> 
                                    <input type="text" id="datepicker" class="form-control" placeholder="Choose date of record" name="date">
                                </div>
                            </div>
                        </div>  -->

                        <!-- Date picker by inline div which is easy -->
                        <div class="form-group row d-flex justify-content-center">
                            <div class="col-sm-2 align-self-center   row d-flex justify-content-center">
                                     <!-- Date of record entry <div id="datepicker"></div> -->
                                    <input type="text" id="inputDatepickerForm" class="form-control" name="date" readonly/> 
                                    <div id="inlineDatepickerDiv"></div>                                   
                            </div>
                        </div> 

                        <!-- Time picker -->
                        <div class="form-group row justify-content-center">
                            <div class="col-auto">                                  
                                <input type="text" id="setTimeExample" class="form-control input-sm" name="time" placeholder="Enter Time">
                            </div>
                            <div class="col-auto">
                                <button type="button" id="setTimeButton"  class=" btn-warning border border-danger btn-sm btnboundary ">Set current time</button>
                            </div>
                        </div> 

                        <!-- SpO2 input -->
                        <div class="form-group row d-flex justify-content-center">
                            <div class="col-sm-3 align-self-center "> 
                                <div class="input-group mb-2" id="spo2group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><b>@SpO2 in %</b></div>
                                    </div> 
                                    <input type="number" class="form-control"  placeholder="Enter here" name="spo2input" min="50" max="100">
                                </div>
                            </div>
                        </div> 

                        <button type="submit" class="btn btn-danger btnboundary ">Submit</button>
                    </form>
                </div>
            </div>

            <!-- TRACK YOUR VITALS FORM-->
            <div id="collapseExample2">
                <div class="card-transparent card-body initDivs">
                    <form method="POST" name="trackForm"   onsubmit="return validateForm3()">
                        <div class="form-group row d-flex justify-content-center">                            
                            <div class="col-sm-4 align-self-center">   
                                <?php
                                    //For Drop Down list of registered users
                                    $dropdownUserListQuery = "SELECT name FROM healthtracker_users"; 
                                    $result2 = mysqli_query($link,$dropdownUserListQuery);
                                    echo '<select name="regUserName" id="regUserName" class="form-control"> <option value="" selected>Select username to retrieve data<br></option>';
                                    if ($result2 = mysqli_query($link,$dropdownUserListQuery)){    
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                ?>
                            </div>        
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="registerOrEnterdata" value=2>
                        </div>

                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="submit" name="view" value="Data" id="dataButton" class="btn btnboundary btn-danger">View Data</button>
                            <button type="submit" name="view" value="Graph" id="graphButton" class="btn btnboundary btn-danger">View Graph</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- VIEW DATA AND GRAPH-->
            <div class="d-flex justify-content-center" id="viewDataIDusername">
                <?php
                        if($viewStatus == 'Data'){
                            echo "<div class=''><b>Username: ".$_POST["regUserName"]."</div>"."<br>";
                        }
                        if($viewStatus == 'Graph'){
                            echo "<div class=''><b>Username: ".$_POST["regUserName"]."</div>"."<br>";
                        }
                ?>
            </div>
            
            <div class="row justify-content-md-center" >                
                    <?php
                        if($viewStatus == 'Data'){
                            
                            $checkUserQuery3 = "SELECT userid FROM healthtracker_users WHERE name =('".$_POST["regUserName"]."')";
                            
                            //echo $checkUserQuery3; echo "<br>";
                            $result3 = mysqli_query($link,$checkUserQuery3);
                            //print_r ($result3); echo "<br>";
                            $row2 = mysqli_fetch_array($result3);
                            //print_r ($row2); echo "<br>";
                            //echo $row2["userid"]; echo "<br>";

                            if($result3 = mysqli_query($link,$checkUserQuery3)){
                            
                                //$viewDataQuery = "SELECT dateofentry,timeofentry,spo2reading FROM healthtracker_data WHERE userid=(".$row2["userid"].")"; 
                                //echo $viewDataQuery; echo "<br>";
                                //$result4 = mysqli_query($link,$viewDataQuery);
                                //print_r ($result4); echo "<br>";
                                //$row3 = mysqli_fetch_array($result4);
                                //print_r ($row3); echo "<br>";
                                //echo $row3["spo2reading"]; echo "<br>"; 

                                $viewDataQuery = "SELECT dateofentry,timeofentry,spo2reading FROM healthtracker_data WHERE userid=(".$row2["userid"].")"; 
                                if ($result4 = mysqli_query($link,$viewDataQuery)){  
                                    if( mysqli_num_rows($result4) != 0){    
                                        //print_r ($result4);
                                        //echo "Username selected: ".$_POST["regUserName"]."<br>"."<br>";
                                        echo "<div class='col col-lg-5' id='viewDataID'>";
                                        echo "<br><table class='table table-striped table-dark  table-hover table-sm text-center rounded'>
                                        <thead class='thead-light'> 
                                            <tr>
                                                <th scope='col'>#</th>
                                                <th scope='col'>Date</th>
                                                <th scope='col'>Time</th>
                                                <th scope='col'>SpO2 Reading</th>
                                            </tr>
                                        </thead>                
                                        <tbody>";

                                        while ($row3 = mysqli_fetch_array($result4)){
                                            //print_r ($row3); echo "<br>"; 
                                        
                                            $field1name = $row3["dateofentry"];
                                            $field2name = $row3["timeofentry"];
                                            $field3name = $row3["spo2reading"];

                                            echo '<tr> 
                                            <td class="counterCell"></td> 
                                            <td>'.$field1name.'</td> 
                                            <td>'.$field2name.'</td> 
                                            <td>'.$field3name.'</td> 
                                            </tr>';
                                        } 
                                        echo "</tbody></table></div>";                   
                                    } else {
                                    echo "<div class='col col-lg-5' id='viewDataID'><b>No entries found.</b></div></div>";
                                    }
                                    
                                }
                            }
                        }
                        if($viewStatus == 'Graph'){
                            //echo "Graph Data to be updated soon!"; 
                            $checkUserQuery3 = "SELECT userid FROM healthtracker_users WHERE name =('".$_POST["regUserName"]."')";
                            $result3 = mysqli_query($link,$checkUserQuery3); 
                            //print_r ($result3); echo "<br>";
                            $row2 = mysqli_fetch_array($result3);
                            //print_r($row2); echo "<br>";

                            if($result3 = mysqli_query($link,$checkUserQuery3)){
                                $viewDataQuery = "SELECT dateofentry,spo2reading FROM healthtracker_data WHERE userid=(".$row2["userid"].")"; 
                                if ($result4 = mysqli_query($link,$viewDataQuery)){  
                                    $NoOfRows= mysqli_num_rows($result4);
                                    //echo $NoOfRows;
                                    if( mysqli_num_rows($result4) != 0){     
                                        
                                        $chartData = array();
                                        foreach( $result4 as $row3){
                                            //$chartData[]= $row3;
                                            $dateofentry[]= $row3['dateofentry'];                                            
                                            $spo2reading[]= $row3['spo2reading'];
                                        }   

                                        //$array_with_data = array(1,1,1,1,1,1,2,1,2);
                                        //print json_encode($array_with_data);
                                        //$arraydata = json_encode($array_with_data);
                                        //print_r ($dateofentry);
                                        //print_r ($spo2reading);
                                        $dateofentryJson = json_encode($dateofentry); echo "<br>"; 
                                        $spo2readingJson = json_encode($spo2reading);

                                        echo "<div class='col col-lg-8' id='viewDataID'>";
                                        echo "<canvas id='chart_0' height='800' width='800'></canvas>";  
                                        echo "</div>";   

                                    } else{
                                        echo "<div class='col col-lg-8' id='viewDataID'><b>No entries found.</b></div>";
                                    }
                                }
                            }

           
                        }
                    ?>
                
            </div>                  
        </div> 
        <!-- JAVASCRIPT         -->
        <script type="text/javascript" src="js/script.js"></script>         
        <!-- CHART JAVASCRIPT         -->
        <script>
            //labels: < ?php echo $dateofentryJson; ?>,
           // data: < ?php echo $spo2readingJson; ?>
            var data = {
                labels: <?php echo $dateofentryJson; ?>,
                datasets: [{
                label: "SpO2 readings",
                backgroundColor: 
                   // 'rgba(255, 99, 132, 1)',
                  //  'rgba(54, 162, 235, 1)', 
                    "rgba(75, 192, 192, 0.7)",
                  //  'rgba(153, 102, 255, 1)',
                  //  'rgba(255, 159, 64, 1)'
                
                borderColor: 
                  //  'rgba(255, 99, 132, 1)',
                  //  'rgba(54, 162, 235, 1)', 
                    'rgba(75, 192, 192, 1)',
                  //  'rgba(153, 102, 255, 1)',
                  //  'rgba(255, 159, 64, 1)'
                
                borderWidth: 0,
                hoverBackgroundColor: "rgba(255,99,132,0.4)",
                hoverBorderColor: "rgba(255,99,132,1)",
                data: <?php echo $spo2readingJson; ?>
                }]
            };

            var option = {
                responsive: true,
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            display: true,
                            color: "rgba(255,99,132,0.2)"
                        },
                        ticks: {
                            fontColor: "black",
                            fontSize: 16, 
                            beginAtZero: false,
                            min: 50,
                            max: 100
                        }
                        }],
                        xAxes: [{
                            gridLines: {
                            display: false
                        },
                        ticks: {
                            fontColor: "black", 
                            beginAtZero: false,
                        }
                        }]
                    },
                    legend: {
                    labels: {
                        fontColor: "black",
                        fontSize: 16
                    }
                },
            };

            Chart.Bar('chart_0', {
                options: option,
                data: data
            });
        </script>
    </body> 
</html>
