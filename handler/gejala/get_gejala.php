<?php
// Fetch symptoms from the database
$query = "SELECT kodegejala, namagejala FROM gejala ORDER BY kodegejala ASC";
$result = mysqli_query($conn, $query);
$symptoms = []; // Initialize an array to hold symptoms

while ($row = mysqli_fetch_assoc($result)) {
    $symptoms[] = $row; // Populate the symptoms array
}
?>