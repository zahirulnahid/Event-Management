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

// Initialize messages
$successMessage = "";
$errorMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);

    // Input validation
    if (strlen($name) < 3) {
        $errorMessage = "Name must be at least 3 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } elseif (!preg_match('/^\d{8,15}$/', $phone)) {
        $errorMessage = "Phone number must be 8-15 digits.";
    } elseif (!is_numeric($age) || $age < 10 || $age > 100) {
        $errorMessage = "Age must be a number between 10 and 100.";
    } elseif (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $errorMessage = "Please select a valid gender.";
    } else {
        // Check event capacity
        $attendeeCount = $attendeeModel->getAttendeeCount($event_id);
        if ($attendeeCount >= $event['max_capacity']) {
            $errorMessage = "Event has reached maximum capacity.";
        } else {
            // Register the attendee
            if ($attendeeModel->registerAttendee($event_id, $name, $email, $age, $gender, $phone)) {
                $successMessage = "Attendee registered successfully!";
            } else {
                $errorMessage = "Error: Failed to register attendee.";
            }
        }
    }
}

// Generate event URL
$eventURL = baseurl."/events/" . $event_id;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Details - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function validateForm() {
      let name = document.getElementById("name").value.trim();
      let email = document.getElementById("email").value.trim();
      let phone = document.getElementById("phone").value.trim();
      let age = document.getElementById("age").value.trim();
      let gender = document.getElementById("gender").value.trim();
      let errorDiv = document.getElementById("error-message");
      
      errorDiv.innerHTML = "";
      errorDiv.classList.add("hidden");

      if (name.length < 3) {
        errorDiv.innerHTML = "Name must be at least 3 characters long.";
      } else if (!email.match(/^[^@\s]+@[^@\s]+\.[^@\s]+$/)) {
        errorDiv.innerHTML = "Invalid email format.";
      } else if (!phone.match(/^\d{8,15}$/)) {
        errorDiv.innerHTML = "Phone number must be 8-15 digits.";
      } else if (isNaN(age) || age < 10 || age > 100) {
        errorDiv.innerHTML = "Age must be a number between 10 and 100.";
      } else if (!["Male", "Female", "Other"].includes(gender)) {
        errorDiv.innerHTML = "Please select a valid gender.";
      }

      if (errorDiv.innerHTML !== "") {
        errorDiv.classList.remove("hidden");
        return false;
      }
      return true;
    }
  </script>
</head>
<body class="bg-gray-50">

  <div class="max-w-4xl mx-auto px-6 py-12">
    <!-- Event Details -->
    <div class="bg-white shadow-lg rounded-lg p-8 mb-8">
      <h1 class="text-4xl font-semibold text-blue-600"><?php echo htmlspecialchars($event['name']); ?></h1>
      <span class="bg-blue-100 text-blue-600 text-xs py-1 px-3 rounded-full"><?php echo date("d M, Y", strtotime($event['date'])); ?></span>
      <p class="text-lg text-gray-700 mb-4"><?php echo htmlspecialchars($event['description']); ?></p>
    </div>

    <!-- Success & Error Messages -->
    <?php if ($successMessage): ?>
      <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
        <strong>Success!</strong> <?php echo $successMessage; ?>
      </div>
    <?php endif; ?>
    <?php if ($errorMessage): ?>
      <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6">
        <strong>Error!</strong> <?php echo $errorMessage; ?>
      </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <div class="bg-white shadow-lg rounded-lg p-8">
      <h2 class="text-2xl font-semibold text-blue-600 mb-6">Register Now</h2>
      <div id="error-message" class="hidden bg-red-100 text-red-800 p-4 rounded-lg mb-4"></div>
      <form action="" method="POST" onsubmit="return validateForm();">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-semibold">Full Name</label>
          <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold">Email Address</label>
          <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
          <label for="phone" class="block text-gray-700 font-semibold">Phone Number</label>
          <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
          <label for="age" class="block text-gray-700 font-semibold">Age</label>
          <input type="number" id="age" name="age" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
        </div>
        <div class="mb-6">
          <label for="gender" class="block text-gray-700 font-semibold">Gender</label>
          <select id="gender" name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-md" required>
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700">Register for Event</button>
      </form>
    </div>
  </div>

</body>
</html>
