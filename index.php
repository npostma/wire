<?php

include_once('Path.php');

if($_SERVER['HTTP_HOST'] == '127.0.0.1') {
    define("APP_PATH", "127.0.0.1/wire/");
    header("Location: http://127.0.0.1/wire/public");

} else {
    define("APP_PATH", "");
    header("Location: http://www.awareofart.nl/wire/public");

}



