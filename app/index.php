<?php

$startTime = microtime(true);

// Track metrics
$metricsFile = '/tmp/app_metrics.prom';
$metrics = [
    'app_requests_total' => 0,
    'app_db_errors_total' => 0,
    'app_up' => 1,
];

// Load previous counters
if (file_exists($metricsFile)) {
    $lines = file($metricsFile);
    foreach ($lines as $line) {
        if (preg_match('/^(app_.*) (\d+)/', $line, $matches)) {
            $metrics[$matches[1]] = (int) $matches[2];
        }
    }
}

// Increment request count
$metrics['app_requests_total']++;

// Handle /metrics endpoint
if ($_SERVER['REQUEST_URI'] === '/metrics') {
    header('Content-Type: text/plain');
    echo "app_up {$metrics['app_up']}\n";
    echo "app_requests_total {$metrics['app_requests_total']}\n";
    echo "app_db_errors_total {$metrics['app_db_errors_total']}\n";
    exit;
}

// DB connection
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
} catch (PDOException $e) {
    $metrics['app_db_errors_total']++;
    $metrics['app_up'] = 0;
    echo "❌ Database connection failed: " . $e->getMessage();
}

// Save updated counters
file_put_contents($metricsFile,
    "app_up {$metrics['app_up']}\n" .
    "app_requests_total {$metrics['app_requests_total']}\n" .
    "app_db_errors_total {$metrics['app_db_errors_total']}\n"
);
