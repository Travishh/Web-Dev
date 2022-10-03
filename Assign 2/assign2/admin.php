<!--Travis Hun_19056383 file admin.php for Display the data in a table from the database based on user input-->
<?php
    
    $bookingRef = $_POST['bookRef'];
   require_once('../../conf/settings.php');

   // The @ operator suppresses the display of any error messages
   // mysqli_connect returns false if connection failed, otherwise a connection value
   $conn = @mysqli_connect($sql_host,
       $sql_user,
       $sql_pass,
       $sql_db
   );
 
   // Checks if connection is successful
   if (!$conn) {
       // Displays an error message
       echo "<p>Database connection failure</p>";
   } 
   else{

        //if no input
        $bookingRef = trim($bookingRef);
        if(isset($bookingRef) === true && $bookingRef===''){ //if the input is empty
            $query = "select * from $sql_table where status like 'unassigned'"; //Display everything where status = unassigned
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)==0){ //if there's no result
                echo "<p style='color: red;'>Unable to get the Booking Number</p>";
            }else{
                //create a HTML table
                echo "<div class='content'><table class='table table-bordered'>";
                echo "<tr>";
                echo "<th>Booking Reference Number</th>";
                echo "<th>Customer Name</th>";
                echo "<th>Phone</th>";
                echo "<th>Pickup Suburb</th>";
                echo "<th>Destination Suburb</th>";
                echo "<th>Pickup Date and Time</th>";
                echo "<th>Status</th>";
                echo "<th>Assign</th></tr>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>". $row["booking_No"]."</td>";
                    echo "<td>". $row["cus_Name"]."</td>";
                    echo "<td>". $row["phone_No"]."</td>";
                    echo "<td>". $row["suburb"]."</td>";
                    echo "<td>". $row["dest_Suburb"]."</td>";
                    echo "<td>". $row["pickup_Date"]. " ".$row["pickup_Time"]."</td>";
                    echo "<td>". $row["status"]."</td>";
                    echo "<td>". "<button name='Assign' id='Assign' type='button' class='btn' onClick = 'Assign()'>Assign</button>"."</td></tr>";

                }
                echo "</table></div>";
            }
        }else{
            //if have input
            $query = "select * from $sql_table where booking_No like '$bookingRef'";
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result)==0){
                echo "<p style='color: red;'>Please Check if the Reference Number is Correct!</p>";
            }else{
                //Create a HTML table
                echo "<div class='content'><table class='table table-bordered'>";
                echo "<tr>";
                echo "<th>Booking Reference Number</th>";
                echo "<th>Customer Name</th>";
                echo "<th>Phone</th>";
                echo "<th>Pickup Suburb</th>";
                echo "<th>Destination Suburb</th>";
                echo "<th>Pickup Date and Time</th>";
                echo "<th>Status</th>";
                echo "<th>Assign</th></tr>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>". $row["booking_No"]."</td>";
                    echo "<td>". $row["cus_Name"]."</td>";
                    echo "<td>". $row["phone_No"]."</td>";
                    echo "<td>". $row["suburb"]."</td>";
                    echo "<td>". $row["dest_Suburb"]."</td>";
                    echo "<td>". $row["pickup_Date"]. " ".$row["pickup_Time"]."</td>";
                    echo "<td>". $row["status"]."</td>";
                    echo "<td>". "<button name='Assign' id='Assign' type='button' class='btn' onClick = 'Assign()'>Assign</button>"."</td></tr>";
                }
                echo "</table></div>";
            }
        }
        //free result
        mysqli_free_result($result);
        // close the database connection
       mysqli_close($conn);           

    }
?>