<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $stmt = $pdo->query("SELECT * FROM test");

    echo "<h2>Data from 'test' table:</h2>";
    echo "<table border='1'><tr><th>ID</th><th>Name</th></tr>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td></tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>
