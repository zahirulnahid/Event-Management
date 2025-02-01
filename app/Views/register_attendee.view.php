<?php
session_start();
require_once "../app/models/EventModel.php";
require_once "../app/models/AttendeeModel.php";

$eventModel = new EventModel();
$attendeeModel = new AttendeeModel();

// Fetch event details using the event ID from the URL
$event_id = explode("/", $_GET["url"])[1];
$event = $eventModel->getEventById($event_id);

if (!$event) {
    echo "Event not found.";
    exit();
}

// Initialize a variable for success message
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Check if the event has reached maximum capacity
    $attendeeCount = $attendeeModel->getAttendeeCount($event_id);
    if ($attendeeCount >= $event['max_capacity']) {
        echo "Event has reached maximum capacity.";
        exit();
    }

    // Register the attendee
    if ($attendeeModel->registerAttendee($event_id, $name, $email)) {
        $successMessage = "Attendee registered successfully!";
    } else {
        echo "Error: Failed to register attendee.";
    }
}

// Generate the URL for the event registration page
$eventURL = baseurl."/events/" . $event_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Details - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

  <div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Event Header -->
    <div class="bg-white shadow-lg rounded-lg p-8 mb-8">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-4xl font-semibold text-blue-600"><?php echo htmlspecialchars($event['name']); ?></h1>
        <span class="bg-blue-100 text-blue-600 text-xs py-1 px-3 rounded-full"><?php echo date("d M, Y", strtotime($event['date'])); ?></span>
      </div>
      <p class="text-lg text-gray-700 mb-4"><?php echo htmlspecialchars($event['description']); ?></p>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="flex items-center text-gray-700">
          <span class="material-icons text-blue-600 mr-2">location_on</span>
          <span class="font-semibold"><?php echo htmlspecialchars($event['location']); ?></span>
        </div>
        <div class="flex items-center text-gray-700">
          <span class="material-icons text-blue-600 mr-2">people</span>
          <span class="font-semibold"><?php echo htmlspecialchars($event['max_capacity']); ?> Attendees Max</span>
        </div>
      </div>
    </div>

    <!-- Success Message -->
    <?php if ($successMessage): ?>
      <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
        <strong>Success!</strong> <?php echo $successMessage; ?>
      </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <div class="bg-white shadow-lg rounded-lg p-8">
      <h2 class="text-2xl font-semibold text-blue-600 mb-6">Register Now</h2>
      <form action="" method="POST">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-semibold">Full Name</label>
          <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600" placeholder="Enter your full name" required>
        </div>
        <div class="mb-6">
          <label for="email" class="block text-gray-700 font-semibold">Email Address</label>
          <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-600" placeholder="Enter your email" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-600">Register for Event</button>
      </form>
    </div>

    <!-- Social Share Section -->
    <div class="mt-12 text-center">
      <h3 class="text-xl font-semibold text-blue-600 mb-4">Share this event</h3>
      <div class="flex justify-center gap-4">
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $eventURL; ?>" target="_blank" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Facebook</a>
        <a href="https://wa.me/?text=<?php echo urlencode($eventURL); ?>" target="_blank" class="bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">WhatsApp</a>
        <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($eventURL); ?>" target="_blank" class="bg-blue-400 text-white py-2 px-4 rounded-lg hover:bg-blue-500">Twitter</a>
      </div>
    </div>

    <!-- QR Code Section -->
    <div class="mt-12 text-center">
      <h3 class="text-lg font-semibold text-blue-600 mb-4">Scan QR Code to Register</h3>
      <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode($eventURL); ?>" alt="QR Code" class="mx-auto">
    </div>

  </div>

</body>
</html>
