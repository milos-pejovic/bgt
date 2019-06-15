<?php

require_once 'config.php';

$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$filePath = '';

/**
 * =============================================================================
 * Files
 * =============================================================================
 */
if (isset($_FILES['image'])) {
    if ( $_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
        $newFileLocation =  DS . 'images' . DS . uniqid() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], ROOT . $newFileLocation);
        $filePath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $newFileLocation;
    } else if ($_FILES['image']['error'] == 1) {
        // file too large
        error_log('File too large');
    } else {
        // TODO error
    }
    
}

require_once 'DatabaseConnection.php';

$stmt = $pdo->prepare("INSERT INTO `users` (id, first_name, last_name, image_path) VALUES(null, :fname, :lname, :imagePath);");

$stmt->bindParam(':fname', $firstName, PDO::PARAM_STR, 32);
$stmt->bindParam(':lname', $lastName, PDO::PARAM_STR, 32);
$stmt->bindParam(':imagePath', $filePath, PDO::PARAM_STR, 256);

$stmt->execute();


//error_log(print_r($_POST, 1));

error_log(print_r($_FILES, 1));
