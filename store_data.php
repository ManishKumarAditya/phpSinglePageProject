<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $jsonFile = 'stored_data.json';

    if (isset($data['image'])) {
        $image = $data['image'];

       //image path
        $imagePath = 'public/uploads/' .basename($image);

        // Save the image to file
        if (file_put_contents($imagePath, base64_decode($image))) {
            $data['image'] = $imagePath;

            // Read existing data, append new data, and save to file
            $existingData = json_decode(file_get_contents($jsonFile), true) ?? [];
            $existingData[] = $data;
            file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

            // Return the updated data including the image path
            echo json_encode(['success' => true, 'data' => $existingData, 'imagePath' => $imagePath]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to save the image']);
        }
      
    } else {
        $data['image'] = null;
    }
   
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>
