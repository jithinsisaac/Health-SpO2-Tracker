<?php
        $link = mysqli_connect("localhost","root","","udemyfullstack"); 

        if(mysqli_connect_error()){
            die("Not connected to MySQL Database. Error! :("."<br>");
        }
?>