<?php
session_start();

require_once "../app/Core/init.php";
require_once "../app/models/AttendeeModel.php";
require_once "../app/models/EventModel.php";

// Redirect if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    showErrorPage("Unauthorized Access", "You need to log in to access this page.");
    exit();
}

$attendeeModel = new AttendeeModel();
$eventModel = new EventModel();

// Validate and fetch event ID
$event_id = $_GET['event_id'] ?? null;
if (!$event_id || !filter_var($event_id, FILTER_VALIDATE_INT)) {
    showErrorPage("Invalid Event ID", "A valid event ID is required.");
    exit();
}

// Fetch event details
$event = $eventModel->getEventById($event_id);
if (!$event) {
    showErrorPage("Event Not Found", "The event you are looking for does not exist.");
    exit();
}

// Fetch attendees for the event
$attendees = $attendeeModel->getAttendeesByEventId($event_id);
if (empty($attendees)) {
    showErrorPage("No Attendees Found", "No one has registered for this event yet.");
    exit();
}

// Clean event name for file name safety
$event_name_sanitized = preg_replace('/[^A-Za-z0-9-_]/', '_', $event['name']);

// Set headers for CSV download
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $event_name_sanitized . '-attendees.csv"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Open output stream
$output = fopen('php://output', 'w');

// Add UTF-8 BOM for Excel compatibility
fwrite($output, "\xEF\xBB\xBF");

// Add CSV headers
fputcsv($output, ['ID', 'Event ID', 'Name', 'Email', 'Registered At', 'Age', 'Gender', 'Phone']);

// Add attendee data
foreach ($attendees as $attendee) {
    fputcsv($output, [
        $attendee['id'],
        $attendee['event_id'],
        htmlspecialchars($attendee['name']),
        htmlspecialchars($attendee['email']),
        $attendee['registered_at'],
        $attendee['age'],
        $attendee['gender'],
        htmlspecialchars($attendee['phone'])
    ]);
}

// Close output stream
fclose($output);
exit();

/**
 * Display an error page with a message.
 */
function showErrorPage($title, $message) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error - ' . htmlspecialchars($title) . '</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 shadow-md rounded-lg text-center max-w-md">
            <h1 class="text-3xl font-bold text-red-600 mb-4">' . htmlspecialchars($title) . '</h1>
            <p class="text-gray-600 mb-6">' . htmlspecialchars($message) . '</p>
            <a href="' . baseurl . '" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Go Back
            </a>
        </div>
    </body>
    </html>';
    exit();
}
?>
