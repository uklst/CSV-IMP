<?php

// Connect to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Open the CSV file
$file = fopen("your_file.csv", "r");
$headers = fgetcsv($file); // to get headers
$number_of_fields = count($headers);

// create columns if not exist
for($i=0;$i<$number_of_fields;$i++){
    $colname = '`'.$headers[$i].'`';
    $sql = "ALTER TABLE your_table ADD COLUMN IF NOT EXISTS $colname VARCHAR(255) NULL;";
    mysqli_query($conn, $sql);
}

// Read the data from the CSV file
while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
    // Insert the data into the database
    $values = implode("','", $data);
    $sql = "INSERT INTO your_table (".implode(",",$headers).") VALUES ('$values')";
    mysqli_query($conn, $sql);
}

// Close the CSV file and the database connection
fclose($file);
mysqli_close($conn);

?>
