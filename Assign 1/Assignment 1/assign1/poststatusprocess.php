<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="UTF-8" />
    <link rel="stylesheet" href="style.css">
    <title>Post Status</title>
  </head>
  <body>
  <div id="container">
    <div class="header">
      <h1>Status Posting System</h1>
    </div>
    <div id="body">
      <div class="content">
  <?php
        // sql info or use include 'file.inc'
   require_once('../../conf/sqlinfo.inc.php');

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
       $tableExists=mysqli_query($conn,"select * from $sql_tble");
        if(!$tableExists){ 
            mysqli_query($conn,"create table if not exists $sql_tble (status_code varchar(10) primary key, status varchar(255), share varchar(10),date varchar(15), permission_like varchar(15), permission_comment varchar(15), permission_share varchar(15))");
        }

       //if the table exitst 
       // Get data from the form
       //regex
       $statusCodePattern="/^(S)\d\d\d\d$/"; //set pattern for status code 'S+4digits'
       $statusPattern='/^[a-zA-Z0-9,\.,\?,\!,\s]*$/'; //set pattern for status only allow alphanumeric, comma, space, period, exclamation point
       $datePattern='/(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/\d{4}/'; //set pattern for date 'dd/mm/yy' day[1-31], month[1-12], year[4digits]
       $select = mysqli_query($conn, "SELECT * FROM $sql_tble WHERE status_code = '".$_POST['statuscode']."'"); //get status code from db to check for duplicate
        if(mysqli_num_rows($select)) {
            echo 'This Status Code is already exist!. Please try another one!';
        }else{
            if(!empty($_POST["statuscode"]) && preg_match($statusCodePattern, $_POST["statuscode"])){ //check if empty and pattern if pass, set the data 
                $statusCode = $_POST["statuscode"];
                if(strlen(trim($_POST["status"])) !=0 && preg_match($statusPattern, $_POST["status"])){ //check if empty and pattern if pass, set the data 
                    $status	= $_POST["status"];
                    if(!empty($_POST["date"]) && preg_match($datePattern, $_POST["date"])){ //check if empty and pattern if pass, set the data
                        $date	= $_POST["date"];
                        $share	= $_POST["share"];
                        $permissionLike = $_POST["AllowLike"];
                        $permissionComment = $_POST["AllowComment"];
                        $permissionShare = $_POST["AllowShare"];
        
                        // Set up the SQL command to add the data into the table
                        $query = "insert into $sql_tble"
                        ."(status_code, status, share, date,permission_like, permission_comment, permission_share)"
                            . "values"
                        ."('$statusCode','$status','$share', '$date', '$permissionLike', '$permissionComment', '$permissionShare')";
                        // executes the query
                        $result = mysqli_query($conn, $query);
                        // checks if the execution was successful
                        if(!$result) {
                        echo "<p>Something is wrong with ",	$query, "</p>";
                        } else {
                        // display an operation successful message
                        echo "<p>The Status has been posted!</p>";
                        } // if successful query operation
        
                        // close the database connection
                        mysqli_close($conn);
                    }else{
                        echo "Wrong Format! Date Format must be dd/mm/yyyy! AND Cannot be empty!"; //error message
                    }
                }else{
                    echo "Wrong Format! Status can only contain alphanumericals, spaces, comma, period, exclamation point, question mark AND Cannot be empty!";
                }

            }else{
                echo "Wrong Format! The Status code must start with an \"S\" followed by four digits. Eg.S0001 AND Cannot be empty! ";
            }
            }  // if successful database connection
        }
  ?>

        <div class="links">
          <a href="http://szf2254.cmslamp14.aut.ac.nz/assign1/">Return to Home Page</a>
          <a href="http://szf2254.cmslamp14.aut.ac.nz/assign1/poststatusform.php">Return to Post Status Page</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>