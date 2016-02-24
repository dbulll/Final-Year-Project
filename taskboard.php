<!DOCTYPE html>
<html lang="en">
<head>
  <title>No Name</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
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

    function sprintChange(ev){
      var selectE = document.getElementById("sprint_list");
      var sprintId = selectE.options[selectE.selectedIndex].value;
      window.location.href = "taskboard.php?id=".concat(sprintId);
    }

    function taskboardPost() {
      var form = document.createElement("form");
      var sprintID = document.getElementById("sprintID");
      var elements = document.getElementsByClassName("sPlanStory");
      form.setAttribute("method", "post");
      form.setAttribute("action", "taskboard.php?update=True&id=".concat(sprintID.getAttribute("name")));

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
            <li><a href="epicBacklog.php">Epic Backlog</a></li>
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
        <li class="active"><a href="taskboard.php">Task Board</a></li>
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
          $updateSprintSql = 'UPDATE story_table SET story_state = '. $value .' WHERE id = '. $key; 
          if ($conn->query($updateSprintSql) === TRUE) 
          {
            $successUpdate = $successUpdate + 1;
          }
        }
        if($totalDefined == $successUpdate)
        {
          echo '<div class="alert alert-success"><strong>Success!</strong> Story states have been successfully updated</div>';
        } 
        else 
        {
          echo '<div class="alert alert-failure"><strong>There was an Error updating some of the story states!</strong> ' . $updateSprintSql . '<br>' . $conn->error . '</div>';
        }
      }
    ?>
    <h2>Task Board</h2>
  </div>
  <div class="row">
    <p>Select the sprint for related taskboard</p>
    <select class="col-lg-4" id="sprint_list" onchange="sprintChange(event)">
    <option value=0></option>
    <?php
      $sql = mysqli_query($conn, 'SELECT id, sprint_name, release_table_id FROM sprint_table');
      while($row = mysqli_fetch_array($sql))          
      {
        echo '<option value='. $row['id'].' ';
        if(isset($_GET['id']))
        {
          if($_GET['id'] == $row['id'])
          {
            echo 'selected="selected"';
          }
        }
        echo '>Release '. $row['release_table_id'].'. '.$row['sprint_name'].'</option>';
      }
    ?>
    </select>
  </div>
  <div class="row">
    <div class="col-lg-8">
      <h3>
      <?php
        $sprintName = 'Sprint';
        if(isset($_GET['id']))
        { 
          $sprintNameSql = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE id =' . $_GET['id']);
          while($row = mysqli_fetch_array($sprintNameSql))
          {
            $sprintName = $row['sprint_name'];
          }
        }
        echo $sprintName;
      ?>
      <span id="sprintID" style="display:hidden;" name="<?php echo $_GET['id']; ?>"</span></h3>
    </div>
    <div class="col-lg-4">
      <button class="btn btn-success pull-right" id="update_taskboard" onclick="taskboardPost()" style="margin-top: 10px;">Save Changes <span class="glyphicon glyphicon-save"></button>
    </div>
  </div>
  <div class="row">
    <div class="table-responsive"> 
      <table class="table table-bordered">
      <thead>
        <tr>
          <th> Unplanned </th>
          <th> To Do </th>
          <th> In Progress </th>
          <th> Done </th>   
        </tr>
      </thead>
      <tbody>
        <tr>
          <?php
            if(isset($_GET['id']))
            {
              $sqlUnplanned = mysqli_query($conn, 'SELECT * FROM story_table WHERE story_state = 0 AND sprint_table_id = '. $_GET['id']);
              $sqlTodo = mysqli_query($conn, 'SELECT * FROM story_table WHERE story_state = 1 AND sprint_table_id = '. $_GET['id']);
              $sqlInprogress = mysqli_query($conn, 'SELECT * FROM story_table WHERE story_state = 2 AND sprint_table_id = '. $_GET['id']);
              $sqlDone = mysqli_query($conn, 'SELECT * FROM story_table WHERE story_state = 3 AND sprint_table_id = '. $_GET['id']);
              echo '<td value=0 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
              while($rowUnplanned = mysqli_fetch_array($sqlUnplanned))
              {
                echo '<div class="sPlanStory" id="'. $rowUnplanned['id'] .'" draggable="true" ondragstart="drag(event)"><strong>'. $rowUnplanned['story_name'] .'</strong><br>Estimation: '. $rowUnplanned['story_estimation'] .' hrs<br>Priority: '. $rowUnplanned['story_priority'] .'</div>';   
              }
              echo '</td>';
              echo '<td value=1 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
              while($rowTodo = mysqli_fetch_array($sqlTodo))
              {
                echo '<div class="sPlanStory" id="'. $rowTodo['id'] .'" draggable="true" ondragstart="drag(event)"><strong>'. $rowTodo['story_name'] .'</strong><br>Estimation: '. $rowTodo['story_estimation'] .' hrs<br>Priority: '. $rowTodo['story_priority'] .'</div>';   
              }
              echo '</td>';
              echo '<td value=2 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
              while ($rowInprogress = mysqli_fetch_array($sqlInprogress))
              { 
                echo '<div class="sPlanStory" id="'. $rowInprogress['id'] .'" draggable="true" ondragstart="drag(event)"><strong>'. $rowInprogress['story_name'] .'</strong><br>Estimation: '. $rowInprogress['story_estimation'] .' hrs<br>Priority: '. $rowInprogress['story_priority'] .'</div>'; 
              }
              echo '</td>';
              echo '<td value=3 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
              while ($rowDone = mysqli_fetch_array($sqlDone))
              { 
                echo '<div class="sPlanStory" id="'. $rowDone['id'] .'" draggable="true" ondragstart="drag(event)"><strong>'. $rowDone['story_name'] .'</strong><br>Estimation: '. $rowDone['story_estimation'] .' hrs<br>Priority: '. $rowDone['story_priority'] .'</div>'; 
              }
              echo '</td>';
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
</td>
</body>
</html>