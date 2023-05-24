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


// PRVA JEDALEN //
// Create a new cURL resource
$ch = curl_init();

// Set the URL to retrieve
curl_setopt($ch, CURLOPT_URL, "http://eatandmeet.sk/tyzdenne-menu");

// Return the response as a string instead of outputting it directly
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and get the response
$response = curl_exec($ch);
curl_close($ch);
$name = "eatandmeet";

// Prepare the SQL statement
$stmt = mysqli_prepare($conn, "INSERT INTO menus (created_at, name, html) VALUES (NOW(), ?, ?)");

// Bind the parameters to the statement
mysqli_stmt_bind_param($stmt, "ss", $name, $response);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo "Data inserted successfully";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}
// Close the statement
mysqli_stmt_close($stmt);


// DRUHA JEDALEN //
// Create a new cURL resource
$ch = curl_init();

// Set the URL to retrieve
curl_setopt($ch, CURLOPT_URL, "https://www.delikanti.sk/prevadzky/3-jedalen-prif-uk/");

// Return the response as a string instead of outputting it directly
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and get the response
$response = curl_exec($ch);
curl_close($ch);
$name = "prifuk";
// Prepare the SQL statement
$stmt = mysqli_prepare($conn, "INSERT INTO menus (created_at, name, html) VALUES (NOW(), ?, ?)");

// Bind the parameters to the statement
mysqli_stmt_bind_param($stmt, "ss", $name, $response);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo "Data inserted successfully";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}
// Close the statement
mysqli_stmt_close($stmt);


// TRETIA JEDALEN //
// Create a new cURL resource
$ch = curl_init();

// Set the URL to retrieve
curl_setopt($ch, CURLOPT_URL, "https://www.druzbacatering.sk/jedalny-listok/");

// Return the response as a string instead of outputting it directly
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and get the response
$response = curl_exec($ch);
curl_close($ch);
$name = "cantina";
// Prepare the SQL statement
$stmt = mysqli_prepare($conn, "INSERT INTO menus (created_at, name, html) VALUES (NOW(), ?, ?)");

// Bind the parameters to the statement
mysqli_stmt_bind_param($stmt, "ss", $name, $response);

// Execute the statement
if (mysqli_stmt_execute($stmt)) {
    echo "Data inserted successfully";
} else {
    echo "Error inserting data: " . mysqli_error($conn);
}
// Close the statement
mysqli_stmt_close($stmt);







// VYTVORENIE MENU

// EAT AND MEET
// Define the SQL query to retrieve the content from the specified column
$sql_query = "SELECT html FROM menus WHERE name='eatandmeet'";

// Execute the query and store the result set in a variable
$result_set = mysqli_query($conn, $sql_query);

// Fetch the row containing the column's value
$row = mysqli_fetch_assoc($result_set);

// Store the value of the column in the $url variable
$url = $row['html'];

$doc = new DOMDocument();
$doc->loadHTML($url);


// Loop through days 1-5
for ($i = 1; $i <= 7; $i++) {
    // Find the day div based on its id
    $dayDiv = $doc->getElementById("day-$i");

    // Find all the divs within the day div that have both "price" and "desc" classes
    $foodDivs = $dayDiv->getElementsByTagName('div');
    foreach ($foodDivs as $foodDiv) {
        $priceElement = $foodDiv->getElementsByTagName('span')->item(0);
        $descElement = $foodDiv->getElementsByTagName('p')->item(0);
        if ($priceElement && $priceElement->hasAttribute("class") && $priceElement->getAttribute("class") === "price"
            && $descElement && $descElement->hasAttribute("class") && $descElement->getAttribute("class") === "desc") {
            
            // Extract the price and description
            $price = $priceElement->nodeValue;
            $desc = $descElement->nodeValue;

            // Check if the food already exists in the database
            $query = "SELECT * FROM eatandmeet WHERE jedlo = '$desc'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) == 0) {
                // Convert the numeric day value to the corresponding name
                switch ($i) {
                    case 1:
                        $den = 'Pondelok';
                        break;
                    case 2:
                        $den = 'Utorok';
                        break;
                    case 3:
                        $den = 'Streda';
                        break;
                    case 4:
                        $den = 'Štvrtok';
                        break;
                    case 5:
                        $den = 'Piatok';
                        break;
                    case 6:
                        $den = 'Sobota';
                        break;
                    case 7:
                        $den = 'Nedeľa';
                        break;
                    default:
                        $den = '';
                        break;
                }

                // Insert the data into the database
                $query = "INSERT INTO eatandmeet (jedlo, cena, den) VALUES ('$desc', '$price', '$den')";
                mysqli_query($conn, $query);
            }
        }
    }
} 








// PRIFUK

// Define the SQL query to retrieve the content from the specified column
$sql_query = "SELECT html FROM menus WHERE name='prifuk'";

// Execute the query and store the result set in a variable
$result_set = mysqli_query($conn, $sql_query);

// Fetch the row containing the column's value
$row = mysqli_fetch_assoc($result_set);

// Store the value of the column in the $url variable
$url = $row['html'];

$doc = new DOMDocument();
$doc->loadHTML($url);

// Create a new DOMXPath object to query the document
$xpath = new DOMXPath($doc);

// Get all the rows in the table
$rows = $xpath->query('//tr');

// Define an array to hold the day names
$day_names = array();

// Loop through each row and extract the relevant data
foreach ($rows as $row) {
    // Get the day name from the first cell if it has a rowspan of 6
    $day_cell = $xpath->query('./th[@rowspan="6"]/strong', $row);
    if ($day_cell->length > 0) {
        $day_name = $day_cell[0]->nodeValue;
        // Add the day name to the array
        $day_names[] = $day_name;
    }

    // Get all the food names from the second cell
    $food_cells = $xpath->query('./td[@class=""]/text()', $row);
    foreach ($food_cells as $food_cell) {
        // Get the food name from the current cell
        $food_name = trim($food_cell->textContent);

        // Insert the data into the database only if the food name is not empty
        if (!empty($food_name)) {
            $query = "INSERT INTO prifuk (jedlo, cena, den) VALUES ('$food_name', '4.20€', '$day_name')";
            mysqli_query($conn, $query);
            if (mysqli_error($conn)) {
                echo mysqli_error($conn);
            }
        }
    }

    // Check if the current row is the last-item row and add the special food to the database
    $special_food_cell = $xpath->query('./td[@class="last-item"]', $row);
    if ($special_food_cell->length > 0) {
        $special_food_name = trim($special_food_cell[1]->textContent);
        if (!empty($special_food_name)) {
            $query = "INSERT INTO prifuk (jedlo, cena, den) VALUES ('$special_food_name', '4.20€', '$day_name')";
            mysqli_query($conn, $query);
            if (mysqli_error($conn)) {
                echo mysqli_error($conn);
            }
        }
    }
}






// CANTINA

// Define the SQL query to retrieve the content from the specified column
$sql_query = "SELECT html FROM menus WHERE name='cantina'";

// Execute the query and store the result set in a variable
$result_set = mysqli_query($conn, $sql_query);

// Fetch the row containing the column's value
$row = mysqli_fetch_assoc($result_set);

// Store the value of the column in the $url variable
$url = $row['html'];

// create a new DOMDocument instance and load the HTML code
$dom = new DOMDocument();
$dom->loadHTML($url);

$foods = array();
$dates = array("Pondelok", "Utorok", "Streda", "Štvrtok", "Piatok");
$day_index = 0;
$food_count = 0;

foreach ($dom->getElementsByTagName('table') as $table) {
    $rows = $table->getElementsByTagName('tr');
    for ($i = 1; $i < $rows->length; $i++) {
        $cells = $rows->item($i)->getElementsByTagName('td');
        $food_name = "";
        $price = "";
        for ($j = 0; $j < $cells->length; $j++) {
            $cell_content = $cells->item($j)->nodeValue;
            if (!in_array($cell_content, array("0,33l", "I", "II", "III", "I.", "II.", "III.", "ll"))) {
                if (strpos($cell_content, 'v cene menu') !== false) {
                    $price = "v cene menu";
                } elseif (strpos($cell_content, '€') !== false) {
                    $price = $cell_content;
                } else {
                    $food_name .= $cell_content;
                }
            }
        }
        if ($food_name != "") {
            $food_name = trim($food_name);
            $food_name = preg_replace('/\s+/', ' ', $food_name);
            $food_name = str_replace(array("0,33l", "I", "II", "III", "ll", ".", "Polievka:"), "", $food_name);
            $foods[] = array("date" => $dates[$day_index], "food_name" => $food_name, "price" => trim($price));
            $query = "INSERT INTO cantina (jedlo, cena, den) VALUES ('$food_name', '$price', '{$dates[$day_index]}')";
            mysqli_query($conn, $query);
            $food_count++;
        }
        if ($food_count == 4) {
            $day_index++;
            $food_count = 0;
        }
    }
}
?>