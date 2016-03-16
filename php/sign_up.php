<?php
  #Gather variables from the form input.
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $user_name = $_POST['user_name'];
  $email = $_POST['email'];
  $password1 = $_POST["input_password"];
  $password2 = $_POST['input_password_confirmation'];

  $sql = "INSERT INTO user_table(user_first_name, user_last_name, user_name, user_email, user_password)
    VALUES ('$first_name', '$last_name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) 
    {
      echo "New record created successfully";
    } 
    else 
    {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();


?>