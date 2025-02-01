<?php
session_start();
require_once "../app/models/EventModel.php";
// Redirect to login if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'event_management');
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$user_query = $conn->prepare("SELECT username FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

// Check if the user exists to prevent null access
if (!$user) {
    header("Location: login");
    exit();
}
$events = new EventModel();

$event_result = $events->getEventsByUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    /* Collapsible Card Styling */
    .event-card {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 1rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      width: 100%;
      box-sizing: border-box;
    }

    .event-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }

    .card-content {
      display: none;
    }

    .card-content.active {
      display: block;
    }

    .container {
      max-width: 100%;
      padding: 0 1rem;
      overflow-x: hidden;
    }

    .action-buttons a {
      margin-top: 0.5rem;
      display: inline-block;
    }

    .chevron {
      transition: transform 0.3s ease;
    }

    .chevron.rotate {
      transform: rotate(180deg);
    }

    @media (max-width: 600px) {
      .event-card {
        margin-left: 0;
        margin-right: 0;
      }

      .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .card-header .event-name {
        font-size: 1.25rem;
      }

      .card-header .flex.items-center {
        display: flex;
        align-items: center;
        justify-content: flex-end;
      }

      . card-header .event-date {
        margin-right: 8px;
      }

      .action-buttons {
        flex-direction: column;
        align-items: flex-start;
      }

      .action-buttons a {
        width: 100%;
        margin: 0.25rem 0;
      }
    }
  </style>
</head>
<body class="bg-gray-50">

  <!-- Navbar -->
  <?php include('../public/include/navbar.php');?>

  <!-- Dashboard Content -->
  <div class="container max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-blue-600 mb-6">Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

    <!-- Create Event Button -->
    <a href="event/create" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 mb-6 inline-block">
      Create New Event
    </a>

    <!-- Event List as Cards -->
    <div class="space-y-6" id="event-list">
<?php 
if (count($event_result) > 0) {
    foreach ($event_result as $event) {
        echo '
        <div class="event-card">
            <div class="px-6 py-4 flex justify-between items-center cursor-pointer card-header" onclick="toggleCard(' . $event['id'] . ')">
                <div class="text-xl font-semibold text-gray-800 event-name">' . htmlspecialchars($event['name']) . '</div>
                <div class="text-sm text-gray-600 event-date" id="event-date-' . $event['id'] . '">
                    ' . date("d M, Y g:i A", strtotime($event['date'])) . '
                </div>
                <i id="chevron-' . $event['id'] . '" class="fas fa-chevron-down chevron"></i>
            </div>
            <div id="card-content-' . $event['id'] . '" class="card-content px-6 py-4">
                <p><strong>Location:</strong> ' . htmlspecialchars($event['location']) . '</p>
                <p><strong>Max Capacity:</strong> ' . htmlspecialchars($event['max_capacity']) . '</p>
                <div class="mt-4 space-x-2 flex items-center justify-start action-buttons">
                    <a href="event/view?id=' . $event['id'] . '" class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg">View</a>
                    <a href="event/edit?id=' . $event['id'] . '" class="bg-green-600 text-white hover:bg-green-700 px-4 py-2 rounded-lg">Edit</a>
                    <a href="javascript:void(0);" onclick="confirmDelete(' . $event['id'] . ')" class="bg-red-600 text-white hover:bg-red-700 px-4 py-2 rounded-lg">Delete</a>
                    <a href="register_attendee.php?event_id=' . $event['id'] . '" class="bg-purple-600 text-white hover:bg-purple-700 px-4 py-2 rounded-lg">Register</a>
                    <a href="download_report.php?event_id=' . $event['id'] . '" class="bg-orange-600 text-white hover:bg-orange-700 px-4 py-2 rounded-lg">Report</a>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">No Events Found</p>
            <p>Create an event first to get started!</p>
        </div>';
}
?>
    </div>

  </div>

  <script>
    function toggleCard(eventId) {
      const cardContent = document.getElementById(`card-content-${eventId}`);
      const chevron = document.getElementById(`chevron-${eventId}`);
      cardContent.classList.toggle('active');
      chevron.classList.toggle('rotate');
    }

    let deleteEventId = null;

    function confirmDelete(eventId) {
      deleteEventId = eventId;
      showModal('Are you sure you want to delete this event?', true);
    }

    function deleteEvent() {
      if (!deleteEventId) return;

      fetch('<?php echo baseurl?>/function/delete_event.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: `id=${deleteEventId}`
})
.then(response => response.json())
.then(data => {
    console.log(data); // Debugging
    if (data.success) {
        showModal('Event deleted successfully!');
        refreshEventList();
    } else {
        showModal('Failed to delete event: ' + data.message);
    }
})
.catch(error => {
    console.error('Error:', error);
    showModal('An error occurred. Please try again.');
});

      deleteEventId = null;
    }

    function showModal(message, isConfirm = false) {
      document.getElementById('modal-message').innerText = message;
      document.getElementById('modal').classList.remove('hidden');

      if (isConfirm) {
        document.getElementById('modal-confirm').classList.remove('hidden');
        document.getElementById('modal-confirm').onclick = deleteEvent;
      } else {
        document.getElementById('modal-confirm').classList.add('hidden');
      }
    }

    function closeModal() {
      document.getElementById('modal').classList.add('hidden');
    }

    function refreshEventList() {
      fetch('<?php echo baseurl?>/function/fetch_events.php')
        .then(response => response.text())
        .then(data => {
          document.getElementById('event-list').innerHTML = data;
        })
        .catch(error => console.error('Error fetching event list:', error));
    }
  </script>

  <!-- Modal Structure -->
  <div id="modal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center">
      <p id="modal-message" class="text-lg font-semibold"></p>
      <div class="mt-4 flex justify-center space-x-4">
        <button id="modal-confirm" class="bg-red-600 text-white px-4 py-2 rounded-lg hidden">Yes</button>
        <button onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg">Cancel</button>
      </div>
    </div>
  </div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?> 