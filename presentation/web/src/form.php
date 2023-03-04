<?php
// Send the data from the HTML form to our backend, the load balancer is running on port 3000
$url = 'http://172.17.0.1:4000/logic.php';

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
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background: url(&quot;assets/img/footballBG.jpg&quot;) center / contain; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
  <h1>CONGRATULATIONS YOU HAVE WON won a game for European Cup Final Competition!</h1>
</div>
HTML;
} else if ($response === "DISCOUNT") {
    $body = <<<HTML
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background: url(&quot;assets/img/footballBG.jpg&quot;) center / contain; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
  <h1>Well done, you won a 10% discount off on your next Runners Crisps purchase!</h1>
</div>
HTML;
} else {
    $body = <<<HTML
<div style="display: flex; justify-content: center; align-items: center; height: 100vh; background: url(&quot;assets/img/footballBG.jpg&quot;) center / contain; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
  <h1>Something is wrong with the form, try again... $response</h1>
</div>
HTML;
}


echo $body;
?>
