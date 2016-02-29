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

    function releaseChange(ev){
      var selectE = document.getElementById("release_list");
      var releaseId = selectE.options[selectE.selectedIndex].value;
      window.location.href = "sprintPlanning.php?release_id=".concat(releaseId);
    }

    function sprintPost() {
      var form = document.createElement("form");
      var releaseID = document.getElementById("releaseID");
      var elements = document.getElementsByClassName("sPlanStory");
      form.setAttribute("method", "post");
      form.setAttribute("action", "sprintPlanning.php?update=True&release_id=".concat(releaseID.getAttribute("name")));

      for(var i=0; i<elements.length; i++) {
        var hiddenField = document.createElement("input");
        var sprintId = $(elements[i]).closest("td").attr("value");
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
  <?php
    $conn = new mysqli('localhost', 'root', '', 'scrum_web_app_db');
    if($conn->connect_errno > 0)
    {
      die('Unable to connect to database [' . $conn->connect_error . ']');
    }
    if(isset($_GET['update']))
    {
      $totalDefined = 0;
      $successUpdate = 0;
      foreach ($_POST as $key => $value)
      { 
        $totalDefined = $totalDefined + 1;   
        $updateSprintSql = 'UPDATE story_table SET sprint_table_id = '. $value .' WHERE id = '. $key; 
        if ($conn->query($updateSprintSql) === TRUE) 
        {
          $successUpdate = $successUpdate + 1;
        }
      }
      if($totalDefined == $successUpdate)
      {
        echo '<div class="alert alert-success"><strong>Success!</strong> Sprints have been successfully updated</div>';
      } 
      else 
      {
        echo '<div class="alert alert-failure"><strong>There was an Error updating some of the stories!</strong> ' . $updateSprintSql . '<br>' . $conn->error . '</div>';
      }
    }
  ?>
  <div class="row">
    <h2>Sprint Planning</h2>
  </div>
  <div class="row">
    <p>Select the release which you would like to start planning:</p>
    <select class="col-lg-4" id="release_list" onchange="releaseChange(event)">
      <option value=0></option>
    <?php
      $sql = mysqli_query($conn, 'SELECT id, release_name FROM release_table');
      while($row = mysqli_fetch_array($sql))          
      {
        echo '<option value='. $row['id'].' ';
        if(isset($_GET['release_id']))
        {
          if($_GET['release_id'] == $row['id'])
          {
            echo 'selected="selected"';
          }
        }
        echo '>'. $row['release_name'].'</option>';
      }
    ?>
    </select>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <h3>
      <?php
        $releaseName = 'Release';
        if(isset($_GET['release_id']))
        { 
          $releaseNameSql = mysqli_query($conn, 'SELECT * FROM release_table WHERE id =' . $_GET['release_id']);
          while($row = mysqli_fetch_array($releaseNameSql))
          {
            $releaseName = $row['release_name'];
          }
        }
        echo $releaseName;
      ?>
      <span id="releaseID" style="display:hidden;" name="<?php if(isset($_GET['release_id'])){echo $_GET['release_id'];?>"</span></h3>
    </div>
    <div class="col-lg-4">
      <button class="btn btn-success pull-right" id="update_sprint" onclick="sprintPost()" style="margin-top: 10px;">Save Changes <span class="glyphicon glyphicon-save"></button>
    </div>
  </div>
  <div class="row">
    <div class="table-responsive"> 
      <table class="table table-bordered">
      <thead>
        <tr>
        <th> Unplanned Stories </th>
          <?php
              $sql = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE release_table_id = ' . $_GET['release_id']);
              $sql2 = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE release_table_id = ' . $_GET['release_id']);
              while($row = mysqli_fetch_array($sql))
              {
                echo '<th>'. $row['sprint_name'] .'<br> '. date('d/m/Y', strtotime($row['sprint_start_date'])) .' - '. date('d/m/Y', strtotime($row['sprint_end_date'])) .'<br><a class="btn btn-default" id="go_to_sprint" href="taskboard.php?sprint_id='. $row['id'] .'" style="margin-top: 5px;">Go To <span class="glyphicon glyphicon-arrow-right"></a></th>';
              }
            
          ?>
        </tr>
      </thead>
      <tbody>
        <tr>
        <td value="NULL" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">
          <?php
            $sqlTemp = mysqli_query($conn, 'SELECT * FROM story_table WHERE sprint_table_id IS NULL');
            while($rowTemp = mysqli_fetch_array($sqlTemp))
            {
              echo '<div class="sPlanStory" id="'. $rowTemp['id'] .'" draggable="true" ondragstart="drag(event)"><strong>'. $rowTemp['story_name'] .'</strong><br>Estimation: '. $rowTemp['story_estimation'] .' hrs<br>Priority: '. $rowTemp['story_priority'] .'</div>';   
            }
            echo '</td>';
            while ($row2 = mysqli_fetch_array($sql2))
            { 
              $sql3 = mysqli_query($conn, 'SELECT * FROM story_table WHERE sprint_table_id = '. $row2['id']);
              echo '<td value="'. $row2['id'] .'" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">'; 
              while($row3 = mysqli_fetch_array($sql3))
              {
                echo '<div class="sPlanStory" id="'. $row3['id'] .'" draggable="true" ondragstart="drag(event)"><strong>'. $row3['story_name'] .'</strong><br>Estimation: '. $row3['story_estimation'] .' hrs<br>Priority: '. $row3['story_priority'] .'</div>';   
              }
            }
          }
          $conn->close();
          ?>
          </td>
        </tr>
      </tbody>
      </table>
      </div> 
    </div>
  </div>
</div>
</body>
</html>
