<?php

include "lib/load.php";

Session::destroy();

header("Location: /login.php");
die();
