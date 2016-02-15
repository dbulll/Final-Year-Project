<!DOCTYPE html>
<html lang="en">
<head>
  <title>No Name</title>
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
      <a class="navbar-brand" href="index.html">No Name</a>
    </div>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Backlog<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="active"><a href="epicBacklog.php">Epic Backlog</a></li>
            <li><a href="storyBacklog.php">User Story Backlog</a></li>
            <li><a href="taskbacklog.php">Task Backlog</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Planning<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="releasePlanning.php">Feature/Release Planning</a></li>
            <li><a href="sprintPlanning.php">Sprint Planning</a></li>
          </ul>
        </li>
        <li><a href="taskBoard.html">Task Board</a></li>
        <li><a href="review.html">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<!-- Main Container -->

<div class="container">
  <h3>Sprint Planning</h3>
  <div class="table-responsive col-lg-3">        
    <table class="table table-striped">
      <thead>
        <tr>
          <th>User Stories</th>
          <th>Epic</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $conn = new mysqli('localhost', 'root', '', 'tempdb');
        if($conn->connect_errno > 0)
        {
          die('Unable to connect to database [' . $conn->connect_error . ']');
        }
        $sql = mysqli_query($conn, 'SELECT * FROM tablefour');
        while($row = mysqli_fetch_array($sql))
        {
          $sql2 = mysqli_query($conn, 'SELECT epicName FROM tableThree WHERE id = ' . $row['epic_id']);
          $result = mysqli_fetch_array($sql2);
          echo '     
            <tr>
              <td> '. $row['storyName'] .'</td>
              <td> '. $result[0] .'</td>
            </tr>';
        }?>
      </tbody>
    </table> 
  </div>
  <div class="table-responsive col-lg-9">        
    <table class="table table-striped">
      <thead>
        <tr>
          <?php
            $conn = new mysqli('localhost', 'root', '', 'tempdb');
            if($conn->connect_errno > 0)
            {
              die('Unable to connect to database [' . $conn->connect_error . ']');
            }
            $sql = mysqli_query($conn, 'SELECT * FROM sprintTable WHERE release_id = ' . $_GET['id']);
            while($row = mysqli_fetch_array($sql))
            {
              echo '<th>' . $row['id'] . '</th>';
            }
          ?>
          <th>Sprint 1</th>
          <th>Sprint 2</th>
          <th>Sprint 3</th>
        </tr>
      </thead>
      <tbody>
        <tr>
        </tr>
      </tbody>
    </table> 
  </div>


</div>
</body>
</html>
