<?php

require_once "../src/AuthToken.php";

use src\AuthToken\AuthToken;

if(!AuthToken::check()) {
    header('location: ../index.php');
}else{
    echo "login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard panel </title>
</head>
<body>
    <h1> Welcome <?= $_SESSION['username'] ?> </h1>
    <hr>
        <a href="logout.php">
        <button>logout</button>
        </a>
</body>
</html>