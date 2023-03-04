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
$REGEX_CHECK = "[a-f0-9]{10}";


// Sanatizes the data to prevent XSS attacks
function sanatize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Santizes the users data 
if (isset($_POST['submit'])) {
    $voucherCode = strtolower(sanatize($_POST['voucherCode']));
    $playerName = sanatize($_POST['bestPlayer']);

    $fullName = sanatize($_POST['fullName']);
    $email = sanatize($_POST['email']);
    $address = sanatize($_POST['address']);

    // Check if the voucher code is valid  
    if (!preg_match($REGEX_CHECK, $voucherCode)) {
        echo "Invalid code, please try again.";
        exit();
    }

    // Check if the users best player name is valid
    $nameLength = strlen($bestPlayer);
    if ($nameLength < 2 || $nameLength > 15) {
        echo "Not a valid player name.";
        exit();
    }

        if ($result->football === TRUE) {
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
        echo "Unfortunately you did not win anything, this code has already been used.";
    }
else {
    echo "Incorrect details";
}

?>