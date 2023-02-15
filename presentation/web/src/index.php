<?php

// Load our template
$head = file_get_contents("head.html");
// form template
$form = file_get_contents("form.html");
$footer = file_get_contents("footer.html");

echo $head . $form . $footer;
?>