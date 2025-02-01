<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 - Page Not Found</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
    .float {
      animation: float 3s ease-in-out infinite;
    }
  </style>
</head>
<body class="bg-[url('/path/to/image.jpg')] bg-cover bg-center flex items-center justify-center min-h-screen">

  <!-- 404 Content -->
  <div class="text-center bg-white bg-opacity-90 p-8 rounded-lg shadow-lg">
    <!-- Animated 404 Text -->
    <h1 class="text-9xl font-bold text-gray-800 float">404</h1>
    <!-- Message -->
    <p class="text-2xl text-gray-600 mt-4">Oops! The page you're looking for doesn't exist.</p>
    <!-- Back to Home Button -->
    <div class="mt-8">
      <a
        href="dashboard"
        class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
      >
        Go Back Home
      </a>
    </div>

  </div>

</body>
</html>