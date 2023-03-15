<?php
require 'vendor/autoload.php';

// Setup database
try { 
    $client = new MongoDB\Client(
        'mongodb://mongo1:27017,mongo2:27017,mongo3:27017/admin?replicaSet=rs0'
    );
} catch (MongoConnectionException $e) {
    die('Error connecting to MongoDB server');
} catch (MongoException $e) {
    die('Error: ' . $e->getMessage());
}

// Get the collections
$users = $client->RunnersCrispsDB->users;
$codes = $client->RunnersCrispsDB->codes;

// Regex for the code, ensuring it follows the forma
$REGEX = "/^[a-f0-9]{10}$/";

// Sanitize the data remove spaces, slashes, and special characters
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

 // Check if the form has been submitted
if (isset($_POST['submit'])) {
    $voucherCode = strtolower(sanitize($_POST['voucherCode']));
    $bestPlayer = sanitize($_POST['bestPlayer']);
    $fullName = sanitize($_POST['fullName']);
    $email = sanitize($_POST['email']);
    $address = sanitize($_POST['address']);

    // Check if the code is valid
    if (!preg_match($REGEX, $voucherCode)) {
        echo "Invalid code";
        exit();
    }

    // Check if the player name is valid
    $nameLength = strlen($bestPlayer);
    if ($nameLength < 3 || $nameLength > 20) {
        echo "Invalid player name";
        exit();
    }

    // Result can be NULL but we can just fallback to else
    // $result = $codes->findOne(['_id' => $voucherCode]);
    $result = $codes->findOne(['voucherCode' => $voucherCode, 'used' => false]);


// Check if the code has been used
if ($result !== null && $result->used === false) {
    if ($result->football === true) {
        // User won a football voucher and receives an email with the voucher
        echo "VOUCHER";
    } else {
        // User won a discount 10% code and receives an email with the code
        echo "DISCOUNT";
    }
} else {
    // The code has already been used
    echo "USED";
}

        // Insert the user into the database
        $users->insertOne([
            'fullName' => $fullName,
            'email' => $email,
            'address' => $address,
            'bestPlayer' => $bestPlayer,
            'voucherCode' => $voucherCode
        ]);

        // Update the code to used
        $codes->updateOne(
            ['voucherCode' => $voucherCode],
            ['$set' => ['used' => true]]
        );
    }
else {
    echo "Invalid form";
}
?>
