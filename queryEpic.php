<?php
  $conn = new mysqli('localhost', 'root', '', 'tempdb');
  if($conn->connect_errno > 0)
  {
    die('Unable to connect to database [' . $conn->connect_error . ']');
  }
  $sql = mysqli_query($conn, 'SELECT * FROM tablethree');
  while($row = mysqli_fetch_array($sql))          
  {
    ?>
      <tr>
          <td><?php echo $row['id']?></td>
          <td><?php echo $row['epicName']?></td>
          <td><?php echo $row['epicDescription']?></td>
          <td>1</td>
          <td>2</td>
          <td>3</td>
      </tr>
    <?php
  }
?>