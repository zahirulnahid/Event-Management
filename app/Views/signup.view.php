<?php
session_start();
require_once "../app/models/UserModel.php";


$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $userModel = new UserModel();

    if ($userModel->registerUser($username, $password)) {
        $successMessage = "Registration successful! <a href='login' class='text-blue-600 hover:underline'>Login here</a>.";
    } else {
        $errorMessage = "Username already exists. Please choose another one.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Eventify</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <!-- Registration Form -->
  <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
    <h2 class="text-2xl font-bold text-blue-600 mb-6 text-center">Create an Account</h2>
    
    <?php if (!empty($errorMessage)): ?>
      <p class="text-red-600 text-center mb-4"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <?php if (!empty($successMessage)): ?>
      <p class="text-green-600 text-center mb-4"><?php echo $successMessage; ?></p>
    <?php else: ?>
      <form action="" method="POST">
        <!-- Username Field -->
        <div class="mb-4">
          <label for="username" class="block text-gray-700 font-semibold mb-2">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Choose a username"
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
            placeholder="Choose a password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
        </div>
        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
        >
          Register
        </button>
      </form>
    <?php endif; ?>
    
    <!-- Login Link -->
    <p class="text-gray-600 mt-4 text-center">
      Already have an account? <a href="login" class="text-blue-600 hover:underline">Login here</a>.
    </p>
  </div>

</body>
</html>
