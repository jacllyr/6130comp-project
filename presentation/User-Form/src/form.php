<?php

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $client = new MongoDB\Client("mongodb://root:password@172.17.0.1:27017");
  $db = $client->selectDatabase("runnersCrispsDB");
  $collection = $db->selectCollection("contestants");

  $fullName = $_POST["fullName"];
  $email = $_POST["email"];
  $address = $_POST["address"];
  $voucherCode = $_POST["voucherCode"];
  $bestPlayer = $_POST["bestPlayer"];

  $insertOneResult = $collection->insertOne([
    "fullName" => $fullName,
    "email" => $email,
    "address" => $address,
    "voucherCode" => $voucherCode,
    "bestPlayer" => $bestPlayer
  ]);

  // redirect to another page
  header("Location: results.php");
  exit();
}
?>
