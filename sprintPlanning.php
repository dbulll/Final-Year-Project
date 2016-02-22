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
  <script type="text/javascript">
    function allowDrop(ev) {
      ev.preventDefault();
    }

    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
      ev.target.style.border = "";
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      ev.target.appendChild(document.getElementById(data));
    }

    function sprintPost() {
      var form = document.createElement("form");
      var releaseID = document.getElementById("releaseID");
      var elements = document.getElementsByClassName("sPlanStory");
      form.setAttribute("method", "post");
      form.setAttribute("action", "sprintPlanning.php?id=".concat(releaseID.getAttribute('name')));

      for(var i=0; i<elements.length; i++) {
        var hiddenField = document.createElement("input");
        var sprintId = $(elements[i]).closest("td").attr("id");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", elements[i].id);
        hiddenField.setAttribute("value", sprintId);
        form.appendChild(hiddenField);
       }

      document.body.appendChild(form);
      form.submit();
    }

    document.addEventListener("dragenter", function(event) {
    if ( event.target.className == "droptarget" ) {
        event.target.style.border = "2px solid yellow";
    }});

    document.addEventListener("dragleave", function(event) {
    if ( event.target.className == "droptarget" ) {
        event.target.style.border = "";
    }}); 
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
  <div class="row">
    <h2>Sprint Planning</h2>
    <?php
      $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
      if($conn->connect_errno > 0)
      {
        die('Unable to connect to database [' . $conn->connect_error . ']');
      }
      $success=0;
      foreach ($_POST as $key => $value) {
        $updateSprintSql = 'UPDATE story_table SET sprint_table_id = '. $value .' WHERE id = '. $key; 
        if ($conn->query($updateSprintSql) === TRUE) 
        {
         echo '<div class="alert alert-success"><strong>Success!</strong> Sprints has been successfully updates</div>';
        } 
        else 
        {
          echo '<div class="alert alert-failure"><strong>Error!</strong> ' . $updateSprintSql . '<br>' . $conn->error . '</div>';
        }
    };
      //if(isset($_POST)){ 
      //echo "hello";
      //echo $_POST[1];
      //foreach ($_POST as $key => $value) {
        //echo $key;
        //echo $value;
        //}
     //}
    ?>
  </div>
  <div class="row">
    <div class="col-lg-2">
      <div class="row">
        <h3 style="text-align: center;">User Stories</h3>
      </div>
        <?php
          $sql = mysqli_query($conn, 'SELECT * FROM story_table');
          while($row = mysqli_fetch_array($sql))
          {
            echo '<div class="row sPlanStory" id="'. $row['id'] .'" draggable="true" ondragstart="drag(event)">'. $row['story_name'] .'</div>';   
          }
        ?>
    </div>
    <div class="table-responsive col-lg-10"> 
      <div class="row">
        <div class="col-lg-8">
          <h3>Release<span id="releaseID" style="display:hidden;" name="<?php echo $_GET['id'];?>"</span></h3>
        </div>
        <div class="col-lg-4">
          <button class="btn btn-success pull-right" id="update_sprint" onclick="sprintPost()" style="margin-top: 10px;">Save Changes <span class="glyphicon glyphicon-save"></button>
        </div>
      </div>
      <div class="row">
        <table class="table table-bordered">
        <thead>
          <tr>
            <?php
              $sql = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE release_table_id = ' . $_GET['id']);
              $sql2 = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE release_table_id = ' . $_GET['id']);
              while($row = mysqli_fetch_array($sql))
              {
                echo '<th>'. $row['sprint_name'] .'<br> '. date('d/m/Y', strtotime($row['sprint_start_date'])) .' - '. date('d/m/Y', strtotime($row['sprint_end_date'])) .'</th>';
              }
            ?>
          </tr>
        </thead>
        <tbody>
          <tr>
          <?php
            while ($row2 = mysqli_fetch_array($sql2))
              { echo '<td id="'. $row2['id'] .'" style="width:200px;height:500px;padding:0;" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)"><div style="width:150px;display:hidden;"></div></td>';
              }
            $conn->close();
            ?>
          </tr>
        </tbody>
        </table>
      </div> 
    </div>
  </div>
</div>
</body>
</html>
