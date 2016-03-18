<?php
  include 'php/userConnectionStart.php';
?>
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
      <a class="navbar-brand" href="index.php">Scrumble</a>
    </div>
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
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
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Review<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="sprintReview.php">Sprint Review</a></li>
            <li><a href="releaseReview.php">Release Review</a></li>
          </ul>
        </li>
      </ul>
      <!--<ul class="nav navbar-nav navbar-right">
        <li><a href="login.php"><span class="glyphicon glyphicon-user"></span> 
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
  <div class="row">
    <a class="btn btn-nav" id="releasePlanningButton" href="releasePlanning.php" style="margin-bottom: 10px;"><span class="glyphicon glyphicon-arrow-left"></span> Release Planning
    </a>
    <a class="btn btn-nav pull-right" id="taskboardButton" href="taskboard.php" style="margin-bottom: 10px;">Taskboard <span class="glyphicon glyphicon-arrow-right"></span>
    </a>
  </div>
  <?php
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
    <button class="btn btn-help pull-right" data-toggle="collapse" data-target="#help_div">Page Help</button>
  </div>
  <div class="row pageDesc collapse" id="help_div">
    <h4>Page Help <span class="glyphicon glyphicon-exclamation-sign"></h4>
    <p>This page of the planning helps to assign unplanned User Stories into the upcoming Sprint's for a given Release.</p>
    <ul style="text-align: left;">
      <li>Return to the Release Planning using the 'Release Planning' button</li>
      <li>Move on to the Taskboard using the 'Taskboard' button</li>
      <li>Select which Release you would like to plan for using the dropdown selection above the table</li>
      <li>Drag & Drop the Story elements into different columns of the table</li>
      <li>Save the changes made to the User Stories using the 'Save Changes' button</li>
      <li>Go To a specific Sprint's Taskboard using the associated 'Go To' button</li>
      <li>Show/Hide this Page Help box using the 'Page Help' button</li>
    </ul>
  </div>
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
      <table class="table">
      <thead>
        <tr>
        <th> Unplanned Stories </th>
          <?php
              $sql = mysqli_query($conn, 'SELECT a . * , b.release_work_hours, b.release_sprint_length FROM sprint_table a, release_table b WHERE a.release_table_id = b.id AND release_table_id = ' . $_GET['release_id']);
              
              while($row = mysqli_fetch_array($sql))
              {
                $available_hours = $row['release_work_hours'] * $row['release_sprint_length'];
                $planned_hours_sql = mysqli_query($conn, 'SELECT SUM(task_hours_estimation) FROM task_table a, story_table b WHERE a.story_table_id = b.id AND sprint_table_id = '. $row['id'] );
                $planned_hours = mysqli_fetch_array($planned_hours_sql);
                $sprint_planned_hours = $planned_hours[0];
                if($planned_hours[0] == NULL){$sprint_planned_hours = 0;}
                $colorCode = 'green';
                if($available_hours < $sprint_planned_hours ){$colorCode = 'red';}
                echo '<th>'. $row['sprint_name'] .'<br> '. date('d/m/Y', strtotime($row['sprint_start_date'])) .' - '. date('d/m/Y', strtotime($row['sprint_end_date'])) .'<br>Hours Available: '. $available_hours .'<br><p style="color:'. $colorCode .';">Hours Planned: '. $sprint_planned_hours.'</p><a class="btn btn-default" id="go_to_sprint" href="taskboard.php?sprint_id='. $row['id'] .'" style="margin-top: 5px;">Go To <span class="glyphicon glyphicon-arrow-right"></a></th>';
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
              $story_estimation = mysqli_query($conn, 'SELECT SUM(task_hours_estimation) AS story_estimation FROM task_table WHERE story_table_id = '.$rowTemp['id']);
              $story_estimation_array = mysqli_fetch_array($story_estimation);
              if($story_estimation_array['story_estimation'] == NULL)
              {
                $story_estimation_array['story_estimation'] = 0;
              }
              echo '<div class="sPlanStory" id="'. $rowTemp['id'] .'" draggable="true" ondragstart="drag(event)"><h4>'. $rowTemp['story_name'] .'</h4>Estimation: '. $story_estimation_array['story_estimation'] .' hrs<br>Priority: '. $rowTemp['story_priority'] .'</div>';   
            }
            echo '</td>';
            $sql2 = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE release_table_id = ' . $_GET['release_id']);
            while ($row2 = mysqli_fetch_array($sql2))
            { 
              $sql3 = mysqli_query($conn, 'SELECT * FROM story_table WHERE sprint_table_id = '. $row2['id']);
              echo '<td value="'. $row2['id'] .'" class="droptarget" ondrop="drop(event)" ondragover="allowDrop(event)">'; 
              while($row3 = mysqli_fetch_array($sql3))
              {
                $story_estimation2 = mysqli_query($conn, 'SELECT SUM(task_hours_estimation) AS story_estimation FROM task_table WHERE story_table_id = '.$row3['id']);
                $story_estimation_array2 = mysqli_fetch_array($story_estimation2);
                if($story_estimation_array2['story_estimation'] == NULL)
                {
                  $story_estimation_array2['story_estimation'] = 0;
                }
                echo '<div class="sPlanStory" id="'. $row3['id'] .'" draggable="true" ondragstart="drag(event)"><h4>'. $row3['story_name'] .'</h4>Estimation: '. $story_estimation_array2['story_estimation'] .' hrs<br>Priority: '. $row3['story_priority'] .'</div>';   
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
