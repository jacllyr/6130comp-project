<?php
require 'vendor/autoload.php';

// Setups the connection to the MongoDB server
try {
    $client = new MongoDB\Client(
        'mongodb://mongo1:27017,mongo2:27017,mongo3:27017/admin?replicaSet=rs0'
    );
} catch (MongoConnectionException $e) {
    die('Error connecting to MongoDB server');
} catch (MongoException $e) {
    die('Error: ' . $e->getMessage());
}

$users = $client->runnersCrispsDB->users;
$codes = $client->runnersCrispsDB->codes;

// Ensure the regex pattern of voucherCode is valid
$REGEX_CHECK = "/^[a-f0-9]{10}$/";

// Sanitizes the data to prevent XSS attacks
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Sanitizes the user's data
if (isset($_POST['submit'])) {
    $voucherCode = strtolower(sanitize($_POST['voucherCode']));
    $bestPlayer = sanitize($_POST['bestPlayer']);
    $fullName = sanitize($_POST['fullName']);
    $email = sanitize($_POST['email']);
    $address = sanitize($_POST['address']);

    // Check if the voucher code is valid  
    if (!preg_match($REGEX_CHECK, $voucherCode)) {
        echo "Invalid code, please try again.";
        exit();
    }

    // Check if the user's best player name is valid
    $nameLength = strlen($bestPlayer);
    if ($nameLength < 2 || $nameLength > 15) {
        echo "Not a valid player name.";
        exit();
    }

    // Check if the validation for voucherCode
      $result = $codes->findOne(['voucherCode' => $voucherCode]);

      if ($result->football) {
        // User won a free football ticket
        echo "VOUCHER";
    } else {
        // User won a 10% discount on next crisps purchase
        echo "DISCOUNT";
    }

    // Insert the user into the database
    $users->insertOne([
        'fullName' => $fullName,
        'email' => $email,
        'address' => $address,
        'bestPlayer' => $bestPlayer
    ]);
} else {
    echo "Incorrect details";
}
?>
