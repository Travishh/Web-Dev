<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="UTF-8" />
    <link rel="stylesheet" href="style.css">
    <title>Search Status</title>
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
                 //if not exists create the table
                  $tableExists=mysqli_query($conn,"select * from $sql_tble");
                  if(!$tableExists){ 
                      echo ("<p>There's currently no status availble, please post a status.</p>");
                  }
                // Get data from the form
                $searchStatus=$_GET["Search"];
            
                if(strlen(trim($_GET["Search"])) != 0){
                    // Set up the SQL command to retrieve the data from the table
                    $query = "select * from $sql_tble where status like UPPER('%$searchStatus%')";
                    // executes the query and store result into the result pointer
                    $result = mysqli_query($conn, $query);
                    //check if there's any result
                    $numRows = mysqli_num_rows($result); 
                    if(!$result || $numRows == 0) {
                        echo "<p>Status not found. Please try a different keyword.</p>";
                    } else {
                        // Display the retrieved records
                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<p><strong>Status Information</strong></p>";
                            echo "<div class=\"result\"><p>Status Code: ",$row["status_code"];
                            echo "<br/>Status: ",$row["status"],"</p>";
                            echo "<p>Share: ",$row["share"];
                            echo "<br/>Date: ",$row["date"];
                            echo "<br/>Permission: ",$row["permission_like"],"    ",$row["permission_comment"],"    ", $row["permission_share"],"</p></div>";
                        }
                        // Frees up the memory, after using the result pointer
                        mysqli_free_result($result);
                    } // if successful query operation
                    
                    // close the database connection
                    mysqli_close($conn);
                }else{
                    echo "<p>The search is empty. Please make sure the input is not empty.</p>";
                }     
            }  // if successful database connection       
        ?>

        <div class="links">
          <a href="http://szf2254.cmslamp14.aut.ac.nz/assign1/">Return to Home Page</a>
          <a href="http://szf2254.cmslamp14.aut.ac.nz/assign1/searchstatusform.html">Search another Status</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>