<?php

$metricsFile = '/tmp/app_metrics.prom';
$metrics = [
    'app_requests_total' => 0,
    'app_db_errors_total' => 0,
    'app_up' => 1,
];

if (file_exists($metricsFile)) {
    $lines = file($metricsFile);
    foreach ($lines as $line) {
        if (preg_match('/^(app_.*) (\d+)/', $line, $matches)) {
            $metrics[$matches[1]] = (int) $matches[2];
        }
    }
}

header('Content-Type: text/plain');

echo "# HELP app_up Whether the app is up (1) or down (0)\n";
echo "# TYPE app_up gauge\n";
echo "app_up {$metrics['app_up']}\n";

echo "# HELP app_requests_total Total number of requests\n";
echo "# TYPE app_requests_total counter\n";
echo "app_requests_total {$metrics['app_requests_total']}\n";

echo "# HELP app_db_errors_total Number of DB errors\n";
echo "# TYPE app_db_errors_total counter\n";
echo "app_db_errors_total {$metrics['app_db_errors_total']}\n";
