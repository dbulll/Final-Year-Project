<?php
  include 'php/userConnectionStart.php';
?>
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
  <?php
    if(isset($_POST['first_name']))
    {
      include 'php/sign_up.php';
    }
  ?>
<!-- Account Icon and Sign Up Form-->
  <div class="row">
  <?php
    if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
    {
         ?>
     
         <h1>Member Area</h1>
         <p>Thanks for logging in! You are <code><?=$_SESSION['Username']?></code> and your email address is <code><?=$_SESSION['EmailAddress']?></code>.</p>
         <a href="logout.php">Click here to logout</a>
          
         <?php
    }
    elseif(!empty($_POST['username']) && !empty($_POST['password']))
    {
        $username = mysql_real_escape_string($_POST['username']);
        $password = md5(mysql_real_escape_string($_POST['password']));
         
        $checklogin = mysqli_query($conn, "SELECT * FROM user_table WHERE user_name = '".$username."' AND user_password = '".$password."'");
         
        if(mysqli_num_rows($checklogin) == 1)
        {
            $row = mysqli_fetch_array($checklogin);
            $email = $row['user_email'];
             
            $_SESSION['Username'] = $username;
            $_SESSION['EmailAddress'] = $email;
            $_SESSION['LoggedIn'] = 1;
             
            echo "<h1>Success</h1>";
            echo "<p>We are now redirecting you to the member area.</p>";
            echo '<meta http-equiv="refresh" content="0;login.php">';
        }
        else
        {
            echo "<h1>Error</h1>";
            echo "<p>Sorry, your account could not be found. Please <a href=\"login.php\">click here to try again</a>.</p>";
        }
    }
    else
    {
        ?>
         
       <h1>Member Login</h1>
         
       <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
        <div class="col-lg-6"> 
          <form method="post" action="login.php" name="loginform" id="loginform">
          <fieldset>
            <label for="username">Username:</label><input type="text" name="username" id="username" class="form-control col-lg-4"/><br />
            <label for="password">Password:</label><input type="password" name="password" id="password" class="form-control col-lg-4"/><br />
            <button class="btn btn-default pull-right" type="submit" id="login" style="margin-top:10px;" disabled>Login</button>
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
