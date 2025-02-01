<?php
session_start();
require_once "../app/models/EventModel.php";

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$eventModel = new EventModel();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form inputs
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $max_capacity = $_POST['max_capacity'];
    $user_id = $_SESSION['user_id'];

    // Create the event using the model
    if ($eventModel->createEvent($name, $description, $date, $location, $max_capacity, $user_id)) {
        header("Location: ".baseurl."/dashboard");
        exit();
    } else {
        echo "Error: Failed to create event.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Event - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->

  <?php include('../public/include/navbar.php');?>

  <!-- Create Event Form -->
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-600 mb-6 text-center md:text-left">Create a New Event</h1>
    <form action="" method="POST" class="bg-white rounded-lg shadow-lg p-6">
      <!-- Event Name -->
      <div class="mb-4">
        <label for="name" class="block text-gray-700 font-semibold mb-2">Event Name</label>
        <input
          type="text"
          id="name"
          name="name"
          placeholder="Enter event name"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          required
        />
      </div>
      <!-- Description -->
      <div class="mb-4">
        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
        <textarea
          id="description"
          name="description"
          placeholder="Enter event description"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          rows="4"
          required
        ></textarea>
      </div>
      <!-- Date and Time -->
      <div class="mb-4">
        <label for="date" class="block text-gray-700 font-semibold mb-2">Date and Time</label>
        <input
          type="datetime-local"
          id="date"
          name="date"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          required
        />
      </div>
      <!-- Location -->
      <div class="mb-4">
        <label for="location" class="block text-gray-700 font-semibold mb-2">Location</label>
        <input
          type="text"
          id="location"
          name="location"
          placeholder="Enter event location"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          required
        />
      </div>
      <!-- Maximum Capacity -->
      <div class="mb-6">
        <label for="max_capacity" class="block text-gray-700 font-semibold mb-2">Maximum Capacity</label>
        <input
          type="number"
          id="max_capacity"
          name="max_capacity"
          placeholder="Enter maximum capacity"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          min="1"
          required
        />
      </div>
      <!-- Action Buttons -->
      <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <button
          type="submit"
          class="w-full md:w-auto bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
        >
          Create Event
        </button>
        <a
          href="<?php echo baseurl?>/dashboard"
          class="w-full md:w-auto bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600"
        >
          Cancel
        </a>
      </div>
    </form>
  </div>

</body>
</html>