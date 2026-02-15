<?php
session_start();
require 'application/vendor/autoload.php';
use Gregwar\Captcha\CaptchaBuilder;

$phrase = (string) rand(1000, 9999);
$builder = new CaptchaBuilder($phrase);
$builder->build();
$_SESSION['captcha'] = $phrase;
header('Content-type: image/jpeg');
$builder->output();
?>