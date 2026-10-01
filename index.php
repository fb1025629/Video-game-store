<?php

$_inventory_code = "";
$video_game_name = "";
$_console = "";
$_price = "";
$image_name = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $_inventory_code = $_POST["_inventory_code"] ?? "";
    $video_game_name = $_POST["video_game_name"] ?? "";
    $_console = $_POST["_console"] ?? "";
    $_price = $_POST["_price"] ?? "";

    if ($_inventory_code == "") {
        $errors[] = "Inventory code is required.";
    } elseif (!preg_match('/^GAME-\d{4}$/', $_inventory_code)) {
        $errors[] = "a Inventory code must be in the format GAME-1234.";
    }

    if ($video_game_name == "") {
        $errors[] = "Your video game name is required.";
    }

    $valid_consoles = [
        "virtual-boy",
        "xbox_360",
        "game_cube",
        "wii_u",
        "xbox",
        "switch_2"
    ];

    if ($_console == "") {
        $errors[] = "Console is required.";
    } elseif (!in_array($_console, $valid_consoles)) {
        $errors[] = "Invalid console selected. (i dont know how you did that.)";
    }

    if ($_price == "") {
        $errors[] = "Price is required.";
    } elseif (!is_numeric($_price) || $_price <= 0) {
        $errors[] = "Price must be numeric and  greater than zero.";
    }

    $uploaded_image = $_FILES["_game_image"] ?? null;

    if ($uploaded_image === null || $uploaded_image["error"] != UPLOAD_ERR_OK) {
        $errors[] = "Please input an image";
    }

        if (empty($errors)) {

        $uploaded_image = $_FILES["_game_image"] ?? null;

        if (!isset($uploaded_image) || $uploaded_image["error"] != UPLOAD_ERR_OK) {
            $errors[] = "A game image must be selected and uploaded successfully.";
        }

        if (empty($errors)) {

            $image_name = round(microtime(true) * 1000) . "." .
                pathinfo($uploaded_image["name"], PATHINFO_EXTENSION);

            if (move_uploaded_file(
                $_FILES["_game_image"]["tmp_name"],
                "uploads/" . $image_name
            )) {

                // Open CSV file
                $file = fopen("Games/Games.csv", "a");

                // Write one CSV row
                fputcsv($file, [
                    $_inventory_code,
                    $video_game_name,
                    $_console,
                    $_price,
                    $image_name
                ]);

                // Close CSV file
                fclose($file);

            } else {
                $errors[] = "Image upload failed.";
            }
        }
    }
    
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>

</head>

<body>
    <div class= "jumbotron text-center "><H1>Video game Store</H1>  
    <div class="panel panel-default"> 
    <div class="nav">
        <?php include 'includes/navigation.php'; ?>
    </div>
    <p>This page alows you to insert a video games information into a CSV file.</p>
    </div>
</div>

    <?php
    if (!empty($errors)) {
        foreach ($errors as $error) {
        echo "<p>$error</p>";
        }
    }
    ?>
<div class="text-center panel panel-default container">
    <form method="post" class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"enctype="multipart/form-data">
        <div class="panel panel default">
    <p>please input "GAME-" and a unique number that isnt arleady used. Check the game tab if number is in use. <p>
        </div>
        <div class="well">


        Inventory Code: <input type="text" name="_inventory_code"value="<?php echo htmlspecialchars($_inventory_code); ?>">
        </div>
        <div class="panel panel default">
        <p>Please input your video game name.<p>
        </div>
        <div class="well">


        Video Game Name: <input type="text" name="video_game_name"value="<?php echo htmlspecialchars($video_game_name); ?>">
        </div>
        <div class="panel panel default">
        <p>Please select a console below.<p>
        </div>
        <div class="well">


        Console:<select name="_console">
        <option value="virtual-boy">Virtual Boy</option>
        <option value="xbox_360">Xbox 360</option>
        <option value="game_cube">Game Cube</option>
        <option value="wii_u">Wii U</option>
        <option value="xbox">Xbox</option>
        <option value="switch_2">Switch 2</option>
        </select>
        </div>
        <div class="panel panel default">
        <p>Please input a price using 0.00 format.<p>
        </div>
        <div class="well">
            
        
        Price: <input type="number" name="_price"value="<?php echo htmlspecialchars($_price); ?>"step="0.01">
        </div>
        <div class="panel panel default">
        <p>Please put in your games cover art using the file browser below. <p>
        </div>
        <div class="well">


        Game Image: <input style="display: inline" class="" type="file" name="_game_image">
        </div>
        <div class="panel panel default">
        <p>when done submit.<p>
        </div>  
        <div class="well">

        
        Submit <input type= "submit" input>
        </div>
    </form>
    <form action="uploads" method="">
</div>
</body>

</html>