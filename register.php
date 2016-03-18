<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Case</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-2.2.0.js"></script>
  <script src="js/validator.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Navigation Bar -->

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Scrumble</a>
    </div>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Backlog<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="epicBacklog.php">Epic Backlog</a></li>
            <li><a href="storyBacklog.php">Story Backlog</a></li>
            <li><a href="taskBacklog.php">Task Backlog</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Planning<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="releasePlanning.php">Feature/Release Planning</a></li>
            <li><a href="sprintPlanning.php">Sprint Planning</a></li>
          </ul>
        </li>
        <li><a href="taskboard.php">Task Board</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Review<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="sprintReview.php">Sprint Review</a></li>
            <li><a href="releaseReview.php">Release Review</a></li>
          </ul>
        </li>
      </ul>
      <!--<ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="login.php"><span class="glyphicon glyphicon-user"></span> 
        <?php
          include 'php/userConnectionStart.php';
          if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
          {
            echo $_SESSION['Username'];
          }
          else
          {
            echo 'Sign Up / Sign In';
          }
        ?>
        </a></li>
      </ul>-->
    </div>
  </div>
</nav>

<!-- Main Container -->
<div class="container">
<!-- Account Icon and Sign Up Form-->
  <div class="row">
  <?php
    if(!empty($_POST['username']) && !empty($_POST['password']))
    {
        $username = mysql_real_escape_string($_POST['username']);
        $password = md5(mysql_real_escape_string($_POST['password']));
        $email = mysql_real_escape_string($_POST['email']);
         
         $checkusername = mysqli_query($conn, "SELECT * FROM user_table WHERE user_name = '".$username."'");
          
         if(mysqli_num_rows($checkusername) == 1)
         {
            echo "<h1>Error</h1>";
            echo "<p>Sorry, that username is taken. Please go back and try again.</p>";
         }
         else
         {
            $registerquery = mysqli_query($conn, "INSERT INTO user_table (user_name, user_password, user_email) VALUES('".$username."', '".$password."', '".$email."')");
            if($registerquery)
            {
                echo "<h1>Success</h1>";
                echo "<p>Your account was successfully created. Please <a href=\"login.php\">click here to login</a>.</p>";
            }
            else
            {
                echo "<h1>Error</h1>";
                echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
            }       
         }
    }
    else
    {
        ?>
             
           <h1>Register</h1>
             
           <p>Please enter your details below to register.</p>
            <div class="col-lg-6"> 
              <form method="post" action="register.php" name="registerform" id="registerform">
              <fieldset>
                <label for="username">Username:</label><input type="text" name="username" id="username" class="form-control col-lg-4"/><br />
                <label for="password">Password:</label><input type="password" name="password" id="password" class="form-control col-lg-4" /><br />
                <label for="email">Email Address:</label><input type="text" name="email" id="email" class="form-control col-lg-4"/><br />
                <button class="btn btn-default pull-right" type="submit" name="register" id="register" style="margin-top:10px;" disabled>Register</button>
              </fieldset>
              </form>
            </div>
             
           <?php
        }
    ?>
  </div>
</div>
</body>
</html>
