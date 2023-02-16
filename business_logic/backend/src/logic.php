<?php

require_once __DIR__ . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $client = new MongoDB\Client("mongodb://root:password@172.17.0.1:27017");
    $db = $client->selectDatabase("runnersCrispsDB");
    $collection = $db->selectCollection("contestants");

    // Validates if the voucher code is following the REGEX manner. 
    $CODE_REGEX = "/^[a-f0-9]{10}$/";

    // Sanitize the data removing the following preg replace. 
    function sanitize($data)
    {
        $data = preg_replace('/[^A-Za-z0-9\-]/', '', $data);
        $data = trim($data);
        return $data;
    }

    // Validates if the submit POST request has been sent from presentation.
    if (isset($_POST['submit'])) {
        $fullName = sanitize($_POST["fullName"]);
        $email = sanitize($_POST["email"]);
        $address = sanitize($_POST["address"]);
        $voucherCode = strtolower(sanitize($_POST['voucherCode']));
        $bestPlayer = sanitize($_POST['bestPlayer']);

        // Voucher code is checked through the REGEX.
        if (!preg_match($CODE_REGEX, $voucherCode)) {
            echo "Invalid code";
            exit();
        }

        // Validation for bestPlayer must contain the name length.
        $nameLength = strlen($bestPlayer);
        if ($nameLength < 3 || $nameLength > 35) {
            echo "Invalid player name";
            exit();
        }

        // Once validation is correct, submits the data to mongoDB.
        $insertOneResult = $collection->insertOne([
            "fullName" => $fullName,
            "email" => $email,
            "address" => $address,
            "voucherCode" => $voucherCode,
            "bestPlayer" => $bestPlayer
        ]);

        echo "VOUCHER";
    } else {
        echo "Invalid form";
    }

    // // redirect to another page
    // header("Location: results.php");
    // exit();
}
