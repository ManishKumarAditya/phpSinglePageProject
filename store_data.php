<?php

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['image']))
{
	$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	
    $targetDir = 'public/uploads/images/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    //set image to unique name
    $new_name = $targetDir . time() . '.' . $extension;

	move_uploaded_file($_FILES['image']['tmp_name'],  $new_name);
    $jsonFile = 'stored_data.json';

    $jsonData = [
        'name' => $_POST['name'],
        'gender' => $_POST['gender'],
        'address' => $_POST['address'],
        'image' => $new_name,
    ];

    // Read existing data, append new data, and save to file
    $existingData = json_decode(file_get_contents($jsonFile), true) ?? [];
    $existingData[] = $jsonData;

    //write in existing file in preety way
    file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

	echo json_encode($jsonData);
}
?>
