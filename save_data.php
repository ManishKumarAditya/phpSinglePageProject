<?php
    if(isset($_POST["submit"])){  
        $name = $_POST["name"];
        $gender = $_POST["gender"];
        $address = $_POST["address"];

        $errors=array();

        if (empty($name) OR empty($gender) OR empty($address)) {
            array_push($errors,"All fields are required");
        }
      
        if(count($errors)>0){
            foreach($errors as $error){
                echo "<div class='alert alert-danger'>$error</div>";
                '</br>';
            }
            exit;
        }

        // Handle image upload
        $imagePath = "public/uploads/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);

        // Retrieve existing data or initialize an empty array
        $existingData = json_decode(file_get_contents('userData.json'), true) ?: [];

        // Add new data to the array
        $existingData[] = [
            "name" => $name,
            "gender" => $gender,
            "address" => $address,
            "image" => $imagePath
        ];

        // Save the updated array back to the file
        file_put_contents('userData.json', json_encode($existingData));

        // Redirect to the index page to display the updated data
        header("Location: index.html");
        exit();
    }
?>
