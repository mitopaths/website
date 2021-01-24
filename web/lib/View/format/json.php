<?php
header('Content-Type: application/json');

$json_string = json_encode($data);
if ($json_string === false) {
    throw new \Exception("Error during JSON conversion: " . json_last_error());
}

echo $json_string;