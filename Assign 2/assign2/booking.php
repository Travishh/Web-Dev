<!--Travis Hun_19056383 file booking.php for posting the data from booking.js to the database with a randBookingRef() function that generate a booking reference with the correct format -->
<?php
    //get input from booking.js
    $name = $_POST['cus_name'];
    $phone = $_POST['phone_No'];
    $unitNo = $_POST['unit_No'];
    $stNo = $_POST['street_No'];
    $stname = $_POST['street_Name'];
    $suburb = $_POST['suburb'];
    $destSuburb = $_POST['dest_Suburb'];
    $pickupDate = $_POST['pickup_Date'];
    $pickupTime = $_POST['pickup_Time'];
    $status = "unassigned";
    $bookingNo = randBookingRef();
    date_default_timezone_set('Pacific/Auckland'); //set time zone to auckland
    $bookingDate = date('d/m/Y h:i:s a', time()); //get date dd/mm/yyyy
    $currentDate = date('d/m/Y');  //for comparing with pickup date 
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
   } else {
        // Upon successful connection
        //check if table exists
        //if not exists create the table
        $tableExists=mysqli_query($conn,"select * from $$sql_table");
        if(!$tableExists){ 
            mysqli_query($conn,"create table if not exists $sql_table (booking_No varchar(50) primary key, cus_Name varchar(50), phone_No varchar(50), unit_No varchar(50), street_No varchar(30), street_Name varchar(100), suburb varchar(100), dest_Suburb varchar(100), pickup_Date varchar(30), pickup_Time time, booking_Date varchar(50), status varchar(50))");
        }
            
        //if the table exitst 
        //regex
        $phonePattern="/^[0-9]{9,12}$/"; //number from 0-9, 12 number max
        $datePattern='/(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}/'; //set pattern for date 'dd/mm/yy' day[1-31], month[1-12], year[4digits]
        //temporarily cast int to $phone for validation
        $phoneValid = intval($phone);
        //get booking ref Number code from db to check for duplicate
        $select = mysqli_query($conn, "SELECT * FROM $$sql_table WHERE booking_No = '".$bookingNo."'"); 
        //preparing for empty check- trim spaces
        $name = trim($name);
        $phone = trim($phone);
        $stNo = trim($stNo);
        $stname = trim($stname);
        $pickupDate = trim($pickupDate);
        //check if the inputs required are empty    
        if((isset($name) === true && $name==='') || (isset($phone) === true && $phone ==='') || (isset($stNo) === true && $stNo==='') || (isset($stname) === true && $stname==='') || (isset($pickupDate) === true && $pickupDate==='') || empty($pickupTime)){
            echo "<p style='color: red;'>Please make sure that the <strong>Customer Name, Phone Number, Street Number, Street Name, Pickup Date and Time </strong>are not empty!</p>";
        }
        elseif(!preg_match($phonePattern,$phoneValid)){ //validate phone number
            echo "<p style='color: red;'> Phone number must be numeric with length between 10 to 12 numbers!</p>";
        }
        elseif(!preg_match($datePattern, $pickupDate) || strlen($pickupDate) > 11){ //validate date
            echo "<p style='color: red;'> Date must be in the format of dd/mm/yyyy!</p>";
        }
        elseif($pickupDate < $currentDate){
            echo "<p style='color: red;'> Pickup Date cannot be earlier than current date(",$currentDate,")!</p>";
        }
        elseif(mysqli_num_rows($select)){
            $bookingNo = randBookingRef(); // assign new reference number if duplicate
        }
        else{
            //if everything is passed insert into database
            $query = "insert into $sql_table"
            ."(booking_No, cus_Name, phone_No, unit_No, street_No, street_Name, suburb, dest_Suburb, pickup_Date, pickup_Time, booking_Date, status)"
                . "values"
            ."('$bookingNo','$name','$phone', '$unitNo', '$stNo', '$stname', '$suburb', '$destSuburb', '$pickupDate', '$pickupTime', '$bookingDate', '$status')";
             $result = mysqli_query($conn, $query);
             if(!$result){
                 echo "<p>Something is wrong with ",	$query, "</p>";
             } else {
                 // display an operation successful message
                 echo "<center><div class='Booked'><h3>Thank you for your booking!</h3>";
                 echo "<p name='reference'>Booking reference number: <strong>", $bookingNo,"</strong><br>";
                 echo "Pickup Time: <strong>", $pickupTime,"</strong><br>";
                 echo "Pickup Date: <strong>", $pickupDate,"</strong></p></div></center>";
             }
             mysqli_free_result($result);   
             mysqli_close($conn); //close connection
        }
    }

    //Generate unique Booking reference number 'BRN+5digits'    
    function randBookingRef(){
        $prefix="BRN";
        $fiveDigits= rand(00000,99999);
        $bookRef = $prefix.$fiveDigits;
        return $bookRef;
    }
  ?>