<?php
session_start();
require_once __DIR__ . "/../../app/Core/Database.php";
require_once __DIR__ . "/../../app/models/EventModel.php";

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name';

$limit = 10; // Number of events per page
$offset = ($page - 1) * $limit;

$events = new EventModel();
$events_result = $events->getEventsByUser($_SESSION['user_id'], $limit, $offset, $sort, $filter);

// Get total count of events for pagination
$total_events = $events->getEventCount($_SESSION['user_id'], $filter);
$total_pages = ceil($total_events / $limit);

echo json_encode([
    'events' => $events_result,
    'total_pages' => $total_pages
]);
?>
