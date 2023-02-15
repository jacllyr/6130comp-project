<!DOCTYPE html>
<html>
  <head>
    <title>Form Submission Results</title>
  </head>
  <body>
    <h1>Form Submission Results</h1>
    <table>
      <tr>
        <th>fullName</th>
        <th>email</th>
        <th>address</th>
        <th>voucherCode</th>
        <th>bestPlayer</th>
      </tr>
      <?php
        require 'vendor/autoload.php';

        $client = new MongoDB\Client("mongodb://root:password@172.17.0.1:27017");
        $db = $client->selectDatabase("runnersCrispsDB");
        $collection = $db->selectCollection("contestants");

        $cursor = $collection->find();

        foreach ($cursor as $document) {
          echo "<tr>";
          echo "<td>" . $document["fullName"] . "</td>";
          echo "<td>" . $document["email"] . "</td>";
          echo "<td>" . $document["address"] . "</td>";
          echo "<td>" . $document["voucherCode"] . "</td>";
          echo "<td>" . $document["bestPlayer"] . "</td>";
          echo "</tr>";
        }
      ?>
    </table>
  </body>
</html>
