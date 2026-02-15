<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Info</h1>";
echo "PHP Version: " . phpversion() . "<br>";

$extensions = ['mysql', 'mysqli', 'pdo', 'pdo_mysql', 'gd', 'gmp', 'soap', 'curl'];
echo "<h2>Extensions Check:</h2>";
foreach ($extensions as $ext) {
    echo "$ext: " . (extension_loaded($ext) ? "OK" : "MISSING") . "<br>";
}

echo "<h2>Database Connection Check:</h2>";
require_once 'application/config/config.php';

echo "Auth Host: " . $config['db_auth_host'] . "<br>";
echo "Auth User: " . $config['db_auth_user'] . "<br>";
// echo "Auth Pass: " . $config['db_auth_pass'] . "<br>"; // Hidden for security
echo "Auth DB: " . $config['db_auth_dbname'] . "<br>";

try {
    $dsn = "mysql:host={$config['db_auth_host']};port={$config['db_auth_port']};dbname={$config['db_auth_dbname']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $pdo = new PDO($dsn, $config['db_auth_user'], $config['db_auth_pass'], $options);
    echo "Auth DB Connected Successfully!<br>";
} catch (PDOException $e) {
    echo "Auth DB Connection Failed: " . $e->getMessage() . "<br>";
}


foreach ($config['realmlists'] as $key => $realm) {
    echo "<h3>Check Realm " . $realm['realmname'] . " (ID: " . $realm['realmid'] . ")</h3>";
    echo "Char DB Host: " . $realm['db_host'] . "<br>";
    echo "Char DB Name: " . $realm['db_name'] . "<br>";
    try {
        $dsn = "mysql:host={$realm['db_host']};port={$realm['db_port']};dbname={$realm['db_name']}";
        $pdo_char = new PDO($dsn, $realm['db_user'], $realm['db_pass'], $options);
        echo "Char DB Connected Successfully!<br>";
    } catch (PDOException $e) {
        echo "Char DB Connection Failed: " . $e->getMessage() . "<br>";
    }
}
?>