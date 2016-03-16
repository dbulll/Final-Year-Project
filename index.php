<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scrumble</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
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
        <li class="active"><a href="index.php">Home</a></li>
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
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php"><span class="glyphicon glyphicon-user"></span> 
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
      </ul>
    </div>
  </div>
</nav>
  
<!-- Main Container -->

<div class="container">
  <h1>Website under contstruction</h1>
  <p>Bare in mind that the website is still being worked on and functionality may not be working as expected.</p>
  <h1>Upcoming Features</h1>
  <ul>
    <li>1a When looking at ongoing sprints, consider End of Actual line of burndown graph should decline with average work hours towards the end to see just how far behind you are falling. Extra line coming off the actual line on current day pointing down to the expected end date.</li>
    <li>1b Predicted end date statistcs on sprint.</li>
    <li>2 Remove blank entry on dropdowns or block the redirect to id=0</li>
    <li>3 Include priorities with different colour for story bar chart</li>
    <li>4 Release should include inputs for:</li>
    <ul>
    <li>5 Days of the week - CheckBoxes</li>
    </ul>
    <li>6 Release Length Statistics and graphs</li>
    <li>7 Recycle Bin for Items Preventing the user from accidentally deleting data</li>
    <li>8 Colour coded elements on the task board for tasks that have overun the estimated hours.</li>
    <li>9 The inputs should reflect the estimation values for the BurnDown Graph</li>
    <li>10 Edit for Elements</li>
    <li>11 Validate Task hours dates</li>
    <li>12 Homepage design with links to Agile/Scrum tutorials and Screenshots of the site.</li>
    <li>13 Tutorial</li>
    <li>14 Multiple Removes at the same time (check box for each element in a seperate column)</li>
    <li>15 Sprint planning should take up whole width of screen to get more columns in view, currenty 1/4 being cut off sides.</li>
  </ul>
</div>
</body>
</html>
