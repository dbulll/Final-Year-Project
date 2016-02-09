<!DOCTYPE html>
<html lang="en">
<head>
  <title>No Name</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.12.0.js"></script>
  <script src="js/validator.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

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
            <li class="active"><a href="storyBacklog.php">User Story Backlog</a></li>
            <li><a href="taskbacklog.php">Task Backlog</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Planning<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="releasePlanning.html">Feature/Release Planning</a></li>
            <li><a href="sprintPlanning.html">Sprint Planning</a></li>
          </ul>
        </li>
        <li><a href="taskboard.html">Task Board</a></li>
        <li><a href="review.html">Review</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.html"><span class="glyphicon glyphicon-user"></span> Sign Up / Sign In</a></li>
      </ul>
    </div>
  </div>
</nav>
  
<div class="container">
  <h3>User Story Backlog</h3>
  <div class="table-responsive">        
    <table class="table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Story Name</th>
          <th>Description</th>
          <th>Priority</th>
          <th>Estimation (Hrs)</th>
          <th>Epic Owner</th>
          <th>Tasks (No.)</th>
          <th></th>
          <th></th>
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
            ?>
              <tr>
                <td><?php echo $row['id']?></td>
                <td><?php echo $row['storyName']?></td>
                <td><?php echo $row['storyDescription']?></td>
                <td><?php echo $row['priority']?></td>
                <td><?php echo $row['estimation']?></td>
                <td><?php echo $row['epic_id']?></td>
                <td>priority</td>
                <td>estimations</td>
                <td>1</td>
                <td>
                  <a class="btn btn-info" id="expandButton" href="storyBacklog.php?id=<?php echo $row['id']?>">
                    Expand <span class="glyphicon glyphicon-arrow-right"></span>
                  </a>
                </td>
                <td>
                  <a class="btn btn-danger" id="removeButton" href="epicRemove.php?id=<?php echo $row['id']?>">
                    Remove <span class="glyphicon glyphicon-remove"></span>
                  </a>
                </td>
                </tr>
            <?php
          }
        ?>
      </tbody>
    </table> 
  </div>
</div>

<div class="container">
  <h3> Create New Story </h3>
  <form class="form-horizontal col-lg-8 col-lg-offset-2" id="storyCreationForm" data-toggle="validator" role="form" novalidate="true" action="storyCreate.php" method="post">
    <div class="row form-group has-feedback">
      <label class="control-label" for="story_name">Story Name:</label>
      <input type="text" class="form-control" name="story_name" pattern="^[A-z0-9\s]{1,}$" maxlength="30" placeholder="Enter Story Name" required>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row form-group has-feedback">
      <label class="control-label" for="story_description">Story Description:</label>
      <textarea type="text" class="form-control" name="story_description" maxlength="100" placeholder="Enter Story Description" rows="3" required></textarea>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
    </div>
    <div class="row">
      <div class="col-lg-3">
        <label class="control-label" for="storyPriority">Story Priority</label>
        <select class="form-control" id="storyPriority">
          <option>Must</option>
          <option>Should</option>
          <option>Could</option>
          <option>Won't</option>
        </select>
      </div>
      <div class="col-lg-4 form-group has-feedback">
        <label class="control-label" for="storyEstimation">Story Estimation (hrs.)</label>
        <input type="text" class="form-control" name="storyEstimation" pattern="^[0-9]{1,2}$" maxlength="2" required>
        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      </div>
    </div>
    <div class="row form-group has-feedback">
      <button type="submit" class="btn btn-primary pull-right" id="submit_button">Create Story <span class="glyphicon glyphicon-plus"></button>
    </div>
  </form>
</div>

</body>
</html>
