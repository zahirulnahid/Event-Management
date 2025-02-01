<?php
require_once "../app/models/UserModel.php";
session_start();

$errorMessage = ""; // Variable to store login error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $userModel = new UserModel();
    
    if ($userModel->loginUser($username, $password)) {
        header("Location: dashboard"); // Redirect to dashboard if login successful
        exit();
    } else {
        $errorMessage = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Login Form -->
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Login to Eventify</h2>
    
    <?php if (!empty($errorMessage)): ?>
      <p class="text-red-600 text-center mb-4"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
      <!-- Username Field -->
      <div class="mb-4">
        <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
        <input
          type="text"
          id="username"
          name="username"
          placeholder="Enter your username"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          required
        />
      </div>
      <!-- Password Field -->
      <div class="mb-6">
        <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Enter your password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
          required
        />
      </div>
      <!-- Submit Button -->
      <button
        type="submit"
        class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
      >
        Login
      </button>
    </form>
    <!-- Register Link -->
    <p class="text-gray-600 mt-4 text-center">
      Don't have an account? <a href="signup" class="text-blue-600 hover:underline">Register here</a>.
    </p>
  </div>

</body>
</html>
