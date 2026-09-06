<?php
header('Content-Type: application/json');
include '../db.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $action = $_GET['action'] ?? '';

    if($action == 'list'){
        // Join appliances with usage logs
        $query = $conn->query("
            SELECT u.id as log_id, a.id as appliance_id, a.name as appliance_name, a.category, a.wattage, u.energy_consumed, u.log_date
            FROM usage_logs u
            JOIN appliances a ON u.appliance_id = a.id
            ORDER BY u.log_date DESC
        ");

        $result = [];
        while($row = $query->fetch_assoc()){
            $result[] = $row;
        }
        echo json_encode($result);
        exit;
    }

    throw new Exception("Invalid action");

} catch(Exception $e){
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
?>