<?php
include "./lib/load.php";

$data = (array)Weather::getDetails();
$key = sizeof($data) + 1;

if (isset($_POST['location'])) {
    print_r(Weather::setData($key, $_POST['location']));
}
