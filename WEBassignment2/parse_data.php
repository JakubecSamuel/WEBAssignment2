<style>
    table {
        border-collapse: collapse;
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.6);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        width: 50%;
        float: left;
    }
    table:nth-of-type(2) {
    margin-top: 0px;
    margin-left: 8px;
    }
    table:nth-of-type(3) {
    margin-top: 0px;
    margin-left: 8px;
    }
    table th,
    table td {
        padding: 8px 18px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    table th {
        background-color: rgba(255, 255, 255, 0.6);
        font-weight: bold;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        position: sticky;
        top: 0;
    }

    table th span {
        display: inline-block;
        margin: 10px 0;
    }

    table caption {
        margin: 20px 0;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
    }
</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the MySQL database
$servername = "localhost";
$username = "INSERT_NAME";
$password = "INSERT_PASSWORD";
$dbname = "jedalen";
$conn = mysqli_connect($servername, $username, $password, $dbname);


// Query the table and retrieve data
$sql = "SELECT jedlo, cena, den FROM eatandmeet";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row in an HTML table
    $current_day = '';
    echo "<table style='width: 640px;'>";
    echo "<tr><th colspan='3'><h4><strong>Eat and Meet</strong></h4></th></tr>";
    echo "<tr><th><h5><strong>Meno jedla</strong></h5></th><th><h5><strong>Cena</strong></h5></th><th></th></tr>";
    while($row = $result->fetch_assoc()) {
        // If the current row's day is different from the previous row's day, print the day in a separate row
        if ($row['den'] != $current_day) {
            $current_day = $row['den'];
            echo "<tr><td colspan='2' style='padding-top:10px;'><h4><strong>{$current_day}</strong></h4></td></tr>";
        }
        // Print the row's data
        echo "<tr><td style='font-weight:medium;'>" . $row["jedlo"]. "</td><td style='font-weight:medium;'>" . $row["cena"]. "</td></tr>";
    }
    echo "</table>";
}





// Query the table and retrieve data
$sql = "SELECT jedlo, cena, den FROM prifuk";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row in an HTML table
    $current_day = '';
    echo "<table style='width: 640px; vertical-align: top;'>";
    echo "<tr><th colspan='3'><h4><strong>PRIF UK</strong></h4></th></tr>";
    echo "<tr><th><h5><strong>Meno jedla</strong></h5></th><th><h5><strong>Cena</strong></h5></th><th></th></tr>";
    while($row = $result->fetch_assoc()) {
        // If the current row's day is different from the previous row's day, print the day in a separate row
        if ($row['den'] != $current_day) {
            $current_day = $row['den'];
            echo "<tr><td colspan='2' style='padding-top:10px;'><h4><strong>{$current_day}</strong></h4></td></tr>";
        }
        // Print the row's data
        echo "<tr><td style='font-weight:medium;'>" . $row["jedlo"]. "</td><td style='font-weight:medium;'>" . $row["cena"]. "</td></tr>";
    }
    echo "</table>";
}






// Query the table and retrieve data
$sql = "SELECT jedlo, cena, den FROM cantina";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row in an HTML table
    $current_day = '';
    echo "<table style='width: 600px; vertical-align: baseline;'>";
    echo "<tr><th colspan='3'><h4><strong>Cantina</strong></h4></th></tr>";
    echo "<tr><th><h5><strong>Meno jedla</strong></h5></th><th><h5><strong>Cena</strong></h5></th><th></th></tr>";
    while($row = $result->fetch_assoc()) {
        // If the current row's day is different from the previous row's day, print the day in a separate row
        if ($row['den'] != $current_day) {
            $current_day = $row['den'];
            echo "<tr><td colspan='2' style='padding-top:10px;'><h4><strong>{$current_day}</strong></h4></td></tr>";
        }
        // Print the row's data
        echo "<tr><td style='font-weight:medium;'>" . $row["jedlo"]. "</td><td style='font-weight:medium;'>" . $row["cena"]. "</td></tr>";
    }
    echo "</table>";
}
?>