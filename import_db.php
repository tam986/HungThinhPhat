<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db = 'hungthinhfood';
$sqlFile = 'op6cjaieob0f_cms_admin.sql';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = file_get_contents($sqlFile);
    // Execute the SQL queries
    $pdo->exec($sql);
    echo "SQL imported successfully.\n";
} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
