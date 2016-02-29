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
      window.location.href = "taskboard.php?sprint_id=".concat(sprintId);
    }

    function taskboardPost() {
      var form = document.createElement("form");
      var sprintID = document.getElementById("sprintID");
      var elements = document.getElementsByClassName("sPlanTask");
      form.setAttribute("method", "post");
      form.setAttribute("action", "taskboard.php?update=True&sprint_id=".concat(sprintID.getAttribute("name")));

      for(var i=0; i<elements.length; i++) {
        var hiddenField = document.createElement("input");
        var stateId = $(elements[i]).closest("td").attr("value");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", elements[i].id);
        hiddenField.setAttribute("value", stateId);
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
        <li class="active"><a href="taskboard.php">Task Board</a></li>
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
    include 'php/connectionStart.php';
    if(isset($_GET['updateTask'])){include 'php/taskUpdate.php';}
    if(isset($_GET['update'])){include 'php/taskboardUpdate.php';}
  ?>
  <div class="row">
    <h2>Task Board</h2>
  </div>
  <?php include 'php/sprint_selection.php' ?>
  <div class="row">
    <div class="col-lg-8">
      <h3>
      <?php
        $sprintName = 'Sprint';
        if(isset($_GET['sprint_id']))
        { 
          $sprintNameSql = mysqli_query($conn, 'SELECT * FROM sprint_table WHERE id =' . $_GET['sprint_id']);
          while($row = mysqli_fetch_array($sprintNameSql))
          {
            $sprintName = $row['sprint_name'];
          }
        }
        echo $sprintName;
      ?>
      <span id="sprintID" style="display:hidden;" name="<?php echo $_GET['sprint_id']; ?>"</span></h3>
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
            if(isset($_GET['sprint_id']))
            {
              $sprintStorySql = mysqli_query($conn, 'SELECT id FROM story_table WHERE sprint_table_id = '. $_GET['sprint_id']);
              $storyIdArray = '';
              $loopCounter = 0 ;
              while($sql11 = mysqli_fetch_array($sprintStorySql))
              { 
                if($loopCounter == 0)
                {
                  $storyIdArray = $storyIdArray.$sql11['id'];
                  $loopCounter = $loopCounter+ 1;
                }
                else
                {
                  $storyIdArray = $storyIdArray. ',' .$sql11['id']; 
                }
              }  
              $sqlUnplanned = mysqli_query($conn, 'SELECT * FROM task_table WHERE task_state = 0 AND story_table_id IN ('.$storyIdArray.')');
              $sqlTodo = mysqli_query($conn, 'SELECT * FROM task_table WHERE task_state = 1 AND story_table_id IN ('.$storyIdArray.')');
              $sqlInprogress = mysqli_query($conn, 'SELECT * FROM task_table WHERE task_state = 2 AND story_table_id IN ('.$storyIdArray.')');
              $sqlDone = mysqli_query($conn, 'SELECT * FROM task_table WHERE task_state = 3 AND story_table_id IN ('.$storyIdArray.')');
              if($sqlUnplanned == FALSE or $sqlTodo == FALSE or $sqlInprogress == FALSE or $sqlDone == FALSE)
                {
                  $x = 0;
                  while($x < 4)
                  {
                    echo '<td id="taskStateTd">There are currently no stories planned for this sprint.</td>';
                    $x++;
                  }
                }
              else
              {
                echo '<td value=0 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
                while($rowUnplanned = mysqli_fetch_array($sqlUnplanned))
                {
                  echo '<div class="sPlanTask" id="'. $rowUnplanned['id'] .'" draggable="true" ondragstart="drag(event)">';
                  echo '<strong>'. $rowUnplanned['task_name'] .'</strong><br>';
                  echo 'Estimation: '. $rowUnplanned['task_estimation'] .' hrs<br>';
                  echo 'Hours Spent: '. $rowUnplanned['task_actual'] .' hrs<br>';
                  echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal'.$rowUnplanned['id'].'" id="tb_modal_button" style="margin:5px;">Add Hours <span class="glyphicon glyphicon-plus"></button><br>';
                  echo '<div class="row">
                        <!-- Modal -->
                          <div class="modal fade" id="myModal'.$rowUnplanned['id'].'"  role="dialog">
                            <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Update Hours </h4>
                                </div>
                                <div class="modal-body">
                                <form action="taskboard.php?sprint_id='. $_GET['sprint_id'] .'&updateTask='. $rowUnplanned['id'] .'" class="form-horizontal" data-toggle="validator" id="taskUpdateHours" method="post" novalidate="true" role="form">
                                <div class="form-group">
                                  <label class="col-lg-5 control-label" for="task_hours">Hours Spent:</label>
                                  <div class="col-lg-6 has-feedback">
                                      <input class="form-control" name="task_hours" maxlength="2" pattern="^[0-9]{1,2}$" type="text" required/>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-7">
                                    <button class="btn btn-success" id="submit_button" type="submit" >Update <span class="glyphicon glyphicon-plus"></button>
                                  </div>
                                </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';
                }
                echo '</td>';
                echo '<td value=1 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
                while($rowTodo = mysqli_fetch_array($sqlTodo))
                {
                  echo '<div class="sPlanTask" id="'. $rowTodo['id'] .'" draggable="true" ondragstart="drag(event)">';
                  echo '<strong>'. $rowTodo['task_name'] .'</strong><br>';
                  echo 'Estimation: '. $rowTodo['task_estimation'] .' hrs<br>';
                  echo 'Hours Spent: '. $rowTodo['task_actual'] .' hrs<br>';
                  echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal'.$rowTodo['id'].'" id="tb_modal_button" style="margin:5px;">Add Hours <span class="glyphicon glyphicon-plus"></button><br>';
                  echo '<div class="row">
                        <!-- Modal -->
                          <div class="modal fade" id="myModal'.$rowTodo['id'].'"  role="dialog">
                            <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Update Hours </h4>
                                </div>
                                <div class="modal-body">
                                <form action="taskboard.php?sprint_id='. $_GET['sprint_id'] .'&updateTask='. $rowTodo['id'] .'" class="form-horizontal" data-toggle="validator" id="taskUpdateHours" method="post" novalidate="true" role="form">
                                <div class="form-group">
                                  <label class="col-lg-5 control-label" for="task_hours">Hours Spent:</label>
                                  <div class="col-lg-6 has-feedback">
                                      <input class="form-control" name="task_hours" maxlength="2" pattern="^[0-9]{1,2}$" type="text" required/>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-7">
                                    <button class="btn btn-success" id="submit_button" type="submit" >Update <span class="glyphicon glyphicon-plus"></button>
                                  </div>
                                </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';  
                }
                echo '</td>';
                echo '<td value=2 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
                while ($rowInprogress = mysqli_fetch_array($sqlInprogress))
                { 
                  echo '<div class="sPlanTask" id="'. $rowInprogress['id'] .'" draggable="true" ondragstart="drag(event)">';
                  echo '<strong>'. $rowInprogress['task_name'] .'</strong><br>';
                  echo 'Estimation: '. $rowInprogress['task_estimation'] .' hrs<br>';
                  echo 'Hours Spent: '. $rowInprogress['task_actual'] .' hrs<br>';
                  echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal'.$rowInprogress['id'].'" id="tb_modal_button" style="margin:5px;">Add Hours <span class="glyphicon glyphicon-plus"></button><br>';
                  echo '<div class="row">
                        <!-- Modal -->
                          <div class="modal fade" id="myModal'.$rowInprogress['id'].'"  role="dialog">
                            <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Update Hours </h4>
                                </div>
                                <div class="modal-body">
                                <form action="taskboard.php?sprint_id='. $_GET['sprint_id'] .'&updateTask='. $rowInprogress['id'] .'" class="form-horizontal" data-toggle="validator" id="taskUpdateHours" method="post" novalidate="true" role="form">
                                <div class="form-group">
                                  <label class="col-lg-5 control-label" for="task_hours">Hours Spent:</label>
                                  <div class="col-lg-6 has-feedback">
                                      <input class="form-control" name="task_hours" maxlength="2" pattern="^[0-9]{1,2}$" type="text" required/>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-7">
                                    <button class="btn btn-success" id="submit_button" type="submit" >Update <span class="glyphicon glyphicon-plus"></button>
                                  </div>
                                </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';
                }
                echo '</td>';
                echo '<td value=3 class="droptarget" id="taskStateTd" ondrop="drop(event)" ondragover="allowDrop(event)">';
                while ($rowDone = mysqli_fetch_array($sqlDone))
                { 
                  echo '<div class="sPlanTask" id="'. $rowDone['id'] .'" draggable="true" ondragstart="drag(event)">';
                  echo '<strong>'. $rowDone['task_name'] .'</strong><br>';
                  echo 'Estimation: '. $rowDone['task_estimation'] .' hrs<br>';
                  echo 'Hours Spent: '. $rowDone['task_actual'] .' hrs<br>';
                  echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal'.$rowDone['id'].'" id="tb_modal_button" style="margin:5px;">Add Hours <span class="glyphicon glyphicon-plus"></button><br>';
                  echo '<div class="row">
                        <!-- Modal -->
                          <div class="modal fade" id="myModal'.$rowDone['id'].'"  role="dialog">
                            <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Update Hours </h4>
                                </div>
                                <div class="modal-body">
                                <form action="taskboard.php?sprint_id='. $_GET['sprint_id'] .'&updateTask='. $rowDone['id'] .'" class="form-horizontal" data-toggle="validator" id="taskUpdateHours" method="post" novalidate="true" role="form">
                                <div class="form-group">
                                  <label class="col-lg-5 control-label" for="task_hours">Hours Spent:</label>
                                  <div class="col-lg-6 has-feedback">
                                      <input class="form-control" name="task_hours" maxlength="2" pattern="^[0-9]{1,2}$" type="text" required/>
                                      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                  </div>
                                </div>
                                <div class="form-group">
                                  <div class="col-lg-offset-5 col-lg-7">
                                    <button class="btn btn-success" id="submit_button" type="submit" >Update <span class="glyphicon glyphicon-plus"></button>
                                  </div>
                                </div>
                                </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>';
                }
                echo '</td>';
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
</td>
</body>
</html>