<?php

// Send the data from the php form to our backend container node, the load balancer is running on port 4000.
$url = 'http://backend_loadbalancer:4000/logic.php'; // Docker-compose node URL for backend
// $url = 'http://172.17.0.1:4000/logic.php'; // Docker container URL for backend



$options = array(
  'http' => array(
    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
    'method' => 'POST',
    'content' => http_build_query($_POST)
  )
);
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);
$body = "";

$header = file_get_contents("header.html");
$footer = file_get_contents("footer.html");


// The response returns "VOUCHER" is the user has won a voucher
if ($response === "VOUCHER") {
  $body = <<<HTML
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
    <h1><b>CONGRATULATIONS YOU HAVE WON!</b></h1>
    <br>
    <h3>A Voucher For The European Cup Final Football Game!</h3>
    <br>
    <p style="margin-bottom: 10px;"><b>Your details are:</b></p>
    <table style="margin: 0 auto;">
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Full Name:</b></td>
        <td style="text-align: left;">{$_POST['fullName']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Email:</b></td>
        <td style="text-align: left;">{$_POST['email']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Address:</b></td>
        <td style="text-align: left;">{$_POST['address']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Best player:</b></td>
        <td style="text-align: left;">{$_POST['bestPlayer']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Voucher code:</b></td>
        <td style="text-align: left;">{$_POST['voucherCode']}</td>
      </tr>
    </table>
    <br>
    <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px; width: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Enter another voucher</button>

  </div>
</div>


HTML;
} else if ($response === "DISCOUNT") {
  $body = <<<HTML

<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
    <h1><b>CONGRATULATIONS YOU HAVE WON!</b></h1>
    <br>
    <h3>10% discount on your next Runners Crisps purchase!</h3>
    <br>
    <p style="margin-bottom: 10px;"><b>Your details are:</b></p>
    <table style="margin: 0 auto;">
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Full Name:</b></td>
        <td style="text-align: left;">{$_POST['fullName']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Email:</b></td>
        <td style="text-align: left;">{$_POST['email']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Address:</b></td>
        <td style="text-align: left;">{$_POST['address']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Best player:</b></td>
        <td style="text-align: left;">{$_POST['bestPlayer']}</td>
      </tr>
      <tr>
        <td style="text-align: left; padding-right: 10px;"><b>Voucher code:</b></td>
        <td style="text-align: left;">{$_POST['voucherCode']}</td>
      </tr>
    </table>
    <br>
    <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px; width: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Enter another voucher</button>

  </div>
</div>


HTML;
} else {
  $body = <<<HTML
<div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
  <div style="background-color: rgba(255, 255, 255, 0.8); border-radius: 43px; padding: 30px; margin: 0 auto; text-align: center;">
  <h1>Code has already been used </h1>
  <br>
  <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px; width: 250px; white-space: normal; word-wrap: break-word;" onclick="window.location.href='index.php';">Enter another voucher</button>
</div>
</div>
HTML;
}


echo $header . $body . $footer;

?>