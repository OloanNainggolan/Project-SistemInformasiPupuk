<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistem_informasi_pupukdanbibit";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check admin_activities table
    $result = $conn->query("SELECT COUNT(*) as count FROM admin_activities");
    $row = $result->fetch(PDO::FETCH_ASSOC);
    
    echo "Admin Activities Count: " . $row['count'] . "\n";
    
    // Get recent activities
    $result = $conn->query("SELECT * FROM admin_activities ORDER BY created_at DESC LIMIT 5");
    $activities = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\nRecent Activities:\n";
    foreach ($activities as $activity) {
        echo "- Action: " . $activity['action'] . " | Description: " . $activity['description'] . " | Status: " . $activity['status'] . "\n";
    }
    
} catch(PDOException $e) {
    echo "Connection Error: " . $e->getMessage() . "\n";
}
?>
