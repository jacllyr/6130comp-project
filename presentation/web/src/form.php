<?php

// Send the data from the HTML form to our backend, the load balancer is running on port 3000
$url = 'http://172.17.0.1:3000/logic.php';

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

// The response returns "VOUCHER" is the user has won a voucher
if ($response === "VOUCHER") {
    $body = <<<HTML
<h1>YOU HAVE WON A FOOTBALL GAME VOUCHER!⚽ It will be emailed to you.</h1>
HTML;
} else if ($response === "DISCOUNT") {
    $body = <<<HTML
<h1>You won a 10% off discount code!🎟️ It will be emailed to you.</h1>
HTML;
} else {
    $body = <<<HTML
<h1>404 ERROR 🤖 $response<h1>
HTML;
}

// Load our template
$head = file_get_contents("head.html");
$footer = file_get_contents("footer.html");

echo $head . $body . $footer;
?>