<!DOCTYPE html>
<html lang="en">
<head>
  <title>Scrumble</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-2.2.0.js"></script>
  <script src="js/validator.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    function allowDrop(ev) {
      ev.preventDefault();
    }

    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      ev.target.appendChild(document.getElementById(data));
    }
  </script>
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
      <a class="navbar-brand" href="index.html">Scrumble</a>
    </div>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.html">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Backlog<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="active"><a href="epicBacklog.php">Epic Backlog</a></li>
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
        <li><a href="review.php">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<!-- Main Container -->

<div class="container">

<div class="row">
  <h2>Sprint Planning</h2>
  <div class="table-responsive col-lg-3"> 
    <h3>User Stories</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>User Stories</th>
          <th>Epic</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
        if($conn->connect_errno > 0)
        {
          die('Unable to connect to database [' . $conn->connect_error . ']');
        }
        $sql = mysqli_query($conn, 'SELECT * FROM story_table');
        while($row = mysqli_fetch_array($sql))
        {
          $sql2 = mysqli_query($conn, 'SELECT epicName FROM epic_table WHERE id = ' . $row['epic_id']);
          $result = mysqli_fetch_array($sql2);
          echo '     
            <tr>
            <td> <div id="sPlanStory" draggable="true" ondragstart="drag(event)">'. $row['storyName'] .'</div></td>
            <td> '. $result[0] .'</td>
            </tr>';
        }
      ?>
      </tbody>
    </table> 
  </div>
  
  </div>

  <div class="row">
    <div class="col-lg-12" style="background-color: gray; text-align: center;">DIVIDER </div>
  </div>


  <div class="row">
    <h2>Sprint Planning</h2>
  </div>
  <div class="row">
    <div class="col-lg-3">
      <div class="row">
        <h3 style="text-align: center;">User Stories</h3>
      </div>
      <?php
        $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
        if($conn->connect_errno > 0)
        {
          die('Unable to connect to database [' . $conn->connect_error . ']');
        }
        $sql = mysqli_query($conn, 'SELECT * FROM story_table');
        while($row = mysqli_fetch_array($sql))
        {
          $sql2 = mysqli_query($conn, 'SELECT epicName FROM epic_table WHERE id = ' . $row['epic_id']);
          $result = mysqli_fetch_array($sql2);
          echo '<div class="row" id="sPlanStory" draggable="true" ondragstart="drag(event)" style="background-color: lavender;border-style: solid;text-align: center;border-width: 1px;margin: 5px;">'. $row['storyName'] .'</div>';   
            //<tr>
            //<td> <div id="sPlanStory" draggable="true" ondragstart="drag(event)">'. $row['storyName'] .'</div></td>
            //<td> '. $result[0] .'</td>
            //</tr>';
        }
      ?>
    </div>
    <div class="col-lg-9">
      <div class="row"> 
       <h3>Release</h3> 
      </div>
      <div class="row">
        <?php
          $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
          if($conn->connect_errno > 0)
          {
            die('Unable to connect to database [' . $conn->connect_error . ']');
          }
          $sql = mysqli_query($conn, 'SELECT * FROM sprintTable WHERE release_id = ' . $_GET['id']);
          $rowcount = mysqli_num_rows($sql);
          while($row = mysqli_fetch_array($sql))
          {
            echo '<div class="col-lg-4"><div class="row">'. $row['sprintName'] .'<br> '. date('d/m/Y', strtotime($row['sprintStartDate'])) .' - '. date('d/m/Y', strtotime($row['sprintEndDate'])) .'</div> <div class=row id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" style="width:200px;height:300px;padding:10px;border-style:dashed;border-width:1px;"> </div> </div>';
          }
          $conn->close();
        ?>
      </div>
    </div>
  </div>



  <div class="table-responsive col-lg-9">   
      <h3>Release</h3>     
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Sprint Details</th>
            <th>Stories</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
            if($conn->connect_errno > 0)
            {
              die('Unable to connect to database [' . $conn->connect_error . ']');
            }
            $sql = mysqli_query($conn, 'SELECT * FROM sprintTable WHERE release_id = ' . $_GET['id']);
            $rowcount = mysqli_num_rows($sql);
            while($row = mysqli_fetch_array($sql))
            {
              echo '<tr><td>'. $row['sprintName'] .'<br> '. date('d/m/Y', strtotime($row['sprintStartDate'])) .' - '. date('d/m/Y', strtotime($row['sprintEndDate'])) .'</td><td><div id="div1" ondrop="drop(event)" ondragover="allowDrop(event)" style="width:200px;height:70px;padding:10px;"></div></td>';
            }
          ?>
          </tr>
        </tbody>
      </table> 
    </div>
</body>
</html>
