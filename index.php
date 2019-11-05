<?php

use JsonApiParser\JsonApi;

require "vendor/autoload.php";

$json = new JsonApi(file_get_contents("./json-api.json"));

$data = $json->data();
foreach($data as $d)
print_r($d);
