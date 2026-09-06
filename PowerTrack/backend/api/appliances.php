<?php
header('Content-Type: application/json');
include '../db.php';

// Enable errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $action = $_GET['action'] ?? '';

    if($action == 'list'){
        $query = $conn->query("SELECT id, user_id, name, category, wattage, usage_schedule, room, created_at FROM appliances ORDER BY created_at DESC");
        $result = [];
        while($row = $query->fetch_assoc()){
            $result[] = $row;
        }
        echo json_encode($result);
        exit;
    }

    if($action == 'add'){
        $user_id = $_POST['user_id'] ?? 1; // default to 1
        $name = $_POST['name'] ?? '';
        $category = $_POST['category'] ?? '';
        $wattage = $_POST['wattage'] ?? 0;
        $usage_schedule = $_POST['usage_schedule'] ?? '';
        $room = $_POST['room'] ?? '';

        if(!$name || !$category || !$wattage || !$room) throw new Exception("Please fill all required fields");

        $stmt = $conn->prepare("INSERT INTO appliances (user_id, name, category, wattage, usage_schedule, room) VALUES (?, ?, ?, ?, ?, ?)");
        if(!$stmt) throw new Exception("Prepare failed: ".$conn->error);
        $stmt->bind_param("ississ", $user_id, $name, $category, $wattage, $usage_schedule, $room);
        if(!$stmt->execute()) throw new Exception("Execute failed: ".$stmt->error);

        echo json_encode(['status'=>'success','message'=>'Appliance added successfully']);
        exit;
    }

    if($action == 'remove'){
        $id = $_GET['id'] ?? 0;
        if(!$id) throw new Exception("Invalid appliance ID");

        $stmt = $conn->prepare("DELETE FROM appliances WHERE id=?");
        $stmt->bind_param("i", $id);
        if(!$stmt->execute()) throw new Exception("Database error: ".$stmt->error);

        echo json_encode(['status'=>'success','message'=>'Appliance removed successfully']);
        exit;
    }

    throw new Exception("Invalid action");

} catch(Exception $e){
    echo json_encode(['status'=>'error','message'=>$e->getMessage()]);
}
?>