<?php

require_once "../src/AuthToken.php";

use src\AuthToken\AuthToken;

AuthToken::delete();
header('location: ../index.php');die();