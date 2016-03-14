function addEpic() 
  {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() 
    {
      if (xhttp.readyState == 4 && xhttp.status == 200) 
      {
        document.getElementById("demo").innerHTML = xhttp.responseText;
      }
    };
    xhttp.open("POST", "php/epicCreate.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("epic_name=test&epic_description=ajax");
  }