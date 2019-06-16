<?php

require_once 'config.php';
require_once 'DatabaseConnection.php';

function errorResponse($errors) {
    $response['errors'] = $errors;
    $response['code'] = 422;
    echo json_encode($response);
    die();
}

$errors = array();

/**
 * =============================================================================
 * Form validation
 * =============================================================================
 */
if ( !isset($_POST['first-name']) || $_POST['first-name'] == '') {
    $errors[] = 'First name is a required field.';
}

if ( !isset($_POST['last-name']) || $_POST['last-name'] == '') {
    $errors[] = 'Last name is a required field.';
}

$firstName = $_POST['first-name'];
$lastName = $_POST['last-name'];
$filePath = '';

/**
 * =============================================================================
 * File handling
 * =============================================================================
 */
if (isset($_FILES['image'])) {
    if ( $_FILES['image']['error'] == 0 && $_FILES['image']['size'] > 0) {
        $newFileLocation =  DS . 'images' . DS . uniqid() . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], ROOT . $newFileLocation);
        $filePath = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $newFileLocation;
    } else if ($_FILES['image']['error'] == 1) {
        $errors[] = 'Image too large. Maximum allowed file size is ' . str_replace('M', '', ini_get('upload_max_filesize')) . ' megabyte(s).';
    } 
}

if ( count($errors) > 0 ) {
    errorResponse($errors);
}

/**
 * =============================================================================
 * Insert user into database
 * =============================================================================
 */
$stmt = $pdo->prepare("INSERT INTO `users` (id, first_name, last_name, image_path) VALUES(null, :fname, :lname, :imagePath);");

$stmt->bindParam(':fname', $firstName, PDO::PARAM_STR, 32);
$stmt->bindParam(':lname', $lastName, PDO::PARAM_STR, 32);
$stmt->bindParam(':imagePath', $filePath, PDO::PARAM_STR, 256);

$stmt->execute();

require_once 'allUsers.php';
