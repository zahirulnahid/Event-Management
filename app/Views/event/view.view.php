<?php
session_start();
require_once "../app/models/EventModel.php";

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

$eventModel = new EventModel();

// Fetch event details using the event ID from the URL
$event_id = $_GET['id'];
$event = $eventModel->getEventById($event_id);

if (!$event) {
    echo "Event not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Event - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">


<?php include('../public/include/navbar.php');?>
  <!-- Event Details -->
  <div class="max-w-4xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-blue-600 mb-6"><?php echo htmlspecialchars($event['name']); ?></h1>
    <div class="bg-white rounded-lg shadow-lg p-6">
      <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($event['description']); ?></p>
      <p class="text-gray-700 mb-4"><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
      <p class="text-gray-700 mb-4"><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
      <p class="text-gray-700 mb-4"><strong>Max Capacity:</strong> <?php echo htmlspecialchars($event['max_capacity']); ?></p>
      <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <a
          href="edit?id=<?php echo $event['id']; ?>"
          class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-blue-700"
        >
          Edit Event
        </a>
        <button
  id="deleteEventBtn"
  data-event-id="<?php echo $event['id']; ?>"
  class="bg-red-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-red-700"
>
  Delete Event
</button>
        <a
          href="<?php echo baseurl."//events/".$event['id']; ?>"
          class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-green-700"
        >
          Register Attendees
        </a>
        <a
          href="<?php echo baseurl?>/download_report.php?event_id=<?php echo $event['id']; ?>"
          class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-purple-700"
        >
          Generate Report
        </a>
      </div>
    </div>
  </div>
 <!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
  <div class="bg-white p-6 rounded-lg shadow-lg w-96">
    <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
    <p class="text-gray-700 mb-6">Are you sure you want to delete this event?</p>
    <div class="flex justify-end space-x-4">
      <button id="cancelDelete" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
      <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
    </div>
  </div>
</div>

<script>
document.getElementById("deleteEventBtn").addEventListener("click", function() {
    document.getElementById("deleteModal").classList.remove("hidden");
});

document.getElementById("cancelDelete").addEventListener("click", function() {
    document.getElementById("deleteModal").classList.add("hidden");
});

document.getElementById("confirmDelete").addEventListener("click", function() {
    let eventId = document.getElementById("deleteEventBtn").getAttribute("data-event-id");
    
    fetch('<?php echo baseurl?>/function/delete_event.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id=' + eventId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "<?php echo baseurl?>/dashboard"; 
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

</body>
</html>