<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Smooth scrolling for anchor links */
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <nav class="bg-white shadow-lg">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex justify-between items-center py-4">
        <div class="text-2xl font-bold text-blue-600">Eventify</div>
        <div class="flex space-x-4">
          <a href="#" class="text-gray-700 hover:text-blue-600">Home</a>
          <a href="#features" class="text-gray-700 hover:text-blue-600">Features</a>
          <a href="#pricing" class="text-gray-700 hover:text-blue-600">Pricing</a>
          <a href="#contact" class="text-gray-700 hover:text-blue-600">Contact</a>
          <a href="login" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Login</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-blue-600 text-white py-20">
    <div class="max-w-4xl mx-auto text-center">
      <h1 class="text-5xl font-bold mb-6">Manage Your Events with Ease</h1>
      <p class="text-xl mb-8">
        Eventify is a powerful event management system that helps you create, manage, and track events effortlessly.
      </p>
      <div class="space-x-4">
        <a href="signup" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100">Get Started</a>
        <a href="#features" class="border border-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600">Learn More</a>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-20">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Features</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <div class="text-blue-600 text-4xl mb-4">🎉</div>
          <h3 class="text-xl font-bold mb-2">Event Creation</h3>
          <p class="text-gray-600">Easily create and manage events with detailed descriptions, dates, and locations.</p>
        </div>
        <!-- Feature 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <div class="text-blue-600 text-4xl mb-4">📊</div>
          <h3 class="text-xl font-bold mb-2">Attendee Management</h3>
          <p class="text-gray-600">Register attendees and track event participation in real-time.</p>
        </div>
        <!-- Feature 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <div class="text-blue-600 text-4xl mb-4">📄</div>
          <h3 class="text-xl font-bold mb-2">Event Reports</h3>
          <p class="text-gray-600">Generate and download detailed event reports in CSV format.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Section -->
  <section id="pricing" class="bg-gray-50 py-20">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Pricing</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Plan 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h3 class="text-xl font-bold mb-4">Basic</h3>
          <p class="text-gray-600 mb-4">Perfect for small events and personal use.</p>
          <p class="text-4xl font-bold text-blue-600 mb-4">$10<span class="text-lg text-gray-600">/month</span></p>
          <ul class="text-left mb-6">
            <li class="mb-2">✅ Create up to 5 events</li>
            <li class="mb-2">✅ Register up to 100 attendees</li>
            <li class="mb-2">❌ Advanced reporting</li>
          </ul>
          <a href="signup" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">Get Started</a>
        </div>
        <!-- Plan 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h3 class="text-xl font-bold mb-4">Pro</h3>
          <p class="text-gray-600 mb-4">Ideal for growing businesses and larger events.</p>
          <p class="text-4xl font-bold text-blue-600 mb-4">$25<span class="text-lg text-gray-600">/month</span></p>
          <ul class="text-left mb-6">
            <li class="mb-2">✅ Create up to 20 events</li>
            <li class="mb-2">✅ Register up to 500 attendees</li>
            <li class="mb-2">✅ Advanced reporting</li>
          </ul>
          <a href="signup" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">Get Started</a>
        </div>
        <!-- Plan 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
          <h3 class="text-xl font-bold mb-4">Enterprise</h3>
          <p class="text-gray-600 mb-4">For large organizations with custom needs.</p>
          <p class="text-4xl font-bold text-blue-600 mb-4">$50<span class="text-lg text-gray-600">/month</span></p>
          <ul class="text-left mb-6">
            <li class="mb-2">✅ Unlimited events</li>
            <li class="mb-2">✅ Unlimited attendees</li>
            <li class="mb-2">✅ Custom reporting</li>
          </ul>
          <a href="signup" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="bg-white py-20">
    <div class="max-w-4xl mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12">Contact Us</h2>
      <form class="bg-gray-50 p-6 rounded-lg shadow-lg">
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
          <input
            type="text"
            id="name"
            name="name"
            placeholder="Enter your name"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Enter your email"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            required
          />
        </div>
        <div class="mb-6">
          <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
          <textarea
            id="message"
            name="message"
            placeholder="Enter your message"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            rows="4"
            required
          ></textarea>
        </div>
        <button
          type="submit"
          class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600"
        >
          Send Message
        </button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white py-8">
    <div class="max-w-6xl mx-auto px-4 text-center">
      <p class="text-gray-600">&copy; <?php echo date("Y"); ?> Eventify. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>