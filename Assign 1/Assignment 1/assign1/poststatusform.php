<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html" ; charset="UTF-8" />
    <link rel="stylesheet" href="style.css">
    <title>Post Status Form</title>
  </head>
  <body>
    <div id="container">
      <div class="header">
        <h1>Status Posting System</h1>
      </div>
      <div id="body">
        <div class="content">
        <form class="form" method="post" action="poststatusprocess.php">
            <p>
                Status Code (required): <input type="text" name="statuscode" placeholder="Eg.S0001" required>
            </p>
            <p>
                Status (required): <input size="50" type="text" name="status" required>
            </p>

            <p>
                Share: 
                <input type="radio" name="share" value="public" required>Public
                <input type="radio" name="share" value="friends" required>Friends
                <input type="radio" name="share" value="only me" required>Only Me
            </p>
            <p>
                Date(dd/mm/yyyy): <input type="text" name="date" value="<?php echo date('d/m/Y') //get the server date?>" required/>
            </p>
            <p>
                Permission Type: 
                <input type="checkbox" name="AllowLike" value="Allow Like" required>Allow Like
                <input type="checkbox" name="AllowComment" value="Allow Comment">Allow Comment
                <input type="checkbox" name="AllowShare" value="Allow Share">Allow Share
            </p>

            <p>
                <input type="submit" value="Post" class="button">
                <input type="reset" value="Reset" class="button">
            </p>
            <div class="links">
                <a href="http://szf2254.cmslamp14.aut.ac.nz/assign1/">Return to Home Page</a>
            </div>
        </form>
        </div>
      </div>
    </div>
  </body>
</html>


