<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Fetch Menus</title>
  <link rel="stylesheet" href="mojstyle.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="snackbar.css">
</head>
<header>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex align-items-center">
          <button class="button-54 mr-2" role="button" id="fetch-menus-btn" onclick="download()">Download</button>
          <button class="button-54 mr-2" role="button" onclick="parseData()">Parse Data</button>
          <button class="button-54" role="button" onclick="deleteDatas()">Delete Data</button>
        </div>
      </div>
    </div>
  </div>
</nav>
  <script>
    function download() {
    // Create a new XMLHttpRequest object
    var xhttp = new XMLHttpRequest();

    // Set the URL of the PHP file to call
    xhttp.open("POST", "insert_data.php", true);

    // Send the HTTP request
    xhttp.send();
    }

    function deleteDatas() {

    var div = document.getElementById("output");
    div.innerHTML = "";   
    var xhttp = new XMLHttpRequest();

    // Set the URL of the PHP file to call
    xhttp.open("DELETE", "delete_data.php", true);

    // Send the HTTP request
    xhttp.send();
    }


    function parseData() {
    // Create a new XMLHttpRequest object
    var xhttp = new XMLHttpRequest();

    // Set the URL of the PHP file to call
    xhttp.open("GET", "parse_data.php", true);

    // Set the callback function to execute when the response is received
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Update the contents of the HTML element with the response from the PHP file
        document.getElementById("output").innerHTML = this.responseText;
      }
    };

    // Send the HTTP request
    xhttp.send();
  }
</script>
</header>
<body>
<div id="output" class="output">
</div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
    <script src="skriptik.js"></script>
</body>
</html>