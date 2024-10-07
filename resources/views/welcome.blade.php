
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SomSurvey - Online Survey Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation Bar -->
    <header class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <a href="/" class="text-2xl font-bold text-yellow-500">SomSurvey</a>
                </div>
                @if (Route::has('login'))
                <nav class="hidden md:flex space-x-10 py-2">
                    <a href="#" class="text-gray-500 hover:text-yellow-500">Home</a>
                    <a href="#" class="text-gray-500 hover:text-yellow-500">About Us</a>
                    <a href="#" class="text-gray-500 hover:text-yellow-500">FAQs</a>
                    <a href="#" class="text-gray-500 hover:text-yellow-500">Services</a>
                    <a href="#" class="text-gray-500 hover:text-yellow-500">Contact</a>
                    @auth
                    <a href="/login" class="text-gray-500 hover:text-yellow-500">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-yellow-500">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 px-4 bg-yellow-500 text-white rounded hover:bg-yellow-600">Join as Surveyor</a>
                    @endif
                </nav>
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-900 via-indigo-900 to-purple-900 text-white py-24">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl font-bold uppercase mb-6">Best Business Platform for <span class="text-yellow-500">Online Survey</span></h1>
            <p class="text-lg mb-8">Join with us and get paid to speak your mind. The more surveys you take, the more money you earn. Join today, hurry up!</p>
            <a href="#" class="px-8 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-100 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">Why Choose SomSurvey</h2>
            <p class="mt-4 text-lg text-gray-600">We offer a complete solution for creating surveys that deliver meaningful results with features that drive engagement.</p>
            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto bg-yellow-500 text-white rounded-full mb-6">
                        <!-- Icon -->
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m2 2h.01M9 16h6m-6-8h6m-6 4h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Customizable Templates</h3>
                    <p class="text-gray-600">Choose from a variety of survey templates tailored to your needs, ensuring the right format for every occasion.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto bg-yellow-500 text-white rounded-full mb-6">
                        <!-- Icon -->
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Real-Time Analytics</h3>
                    <p class="text-gray-600">Get insights as responses come in, enabling you to make data-driven decisions quickly and efficiently.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center justify-center h-16 w-16 mx-auto bg-yellow-500 text-white rounded-full mb-6">
                        <!-- Icon -->
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V7m0 10l-8-8-4 4-6-6"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Seamless Integration</h3>
                    <p class="text-gray-600">Integrate with your favorite tools like Slack, Mailchimp, and Google Sheets to streamline your workflow.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900">What Our Users Say</h2>
            <p class="mt-4 text-lg text-gray-600">Hear from businesses and individuals who have found success with SomSurvey.</p>
            <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <p class="text-gray-600">"SomSurvey helped us create engaging surveys that our customers actually enjoy answering. We've gathered so much valuable feedback!"</p>
                    <p class="mt-4 text-sm font-bold text-gray-900">- Sarah L., Marketing Director</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <p class="text-gray-600">"The real-time analytics feature is a game-changer. We can see responses coming in and adjust our strategy on the fly."</p>
                    <p class="mt-4 text-sm font-bold text-gray-900">- John D., Small Business Owner</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg shadow-md">
                    <p class="text-gray-600">"Creating surveys is so easy, and the integrations with our tools have saved us countless hours. Highly recommend!"</p>
                    <p class="mt-4 text-sm font-bold text-gray-900">- Emily R., Project Manager</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call-to-Action Section -->
    <section class="bg-gradient-to-r from-blue-900 via-indigo-900 to-purple-900 text-white py-16">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-4xl font-bold">Ready to Get Started?</h2>
            <p class="mt-4 text-lg">Join SomSurvey today and take your business or research to the next level. Create your first survey in minutes!</p>
            <div class="mt-6">
                <a href="#" class="px-8 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600">Start Now</a>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between">
            <p>&copy; 2024 SurvLab. All Rights Reserved.</p>
            <div class="flex space-x-4">
                <a href="#" class="hover:text-gray-400">Privacy Policy</a>
                <a href="#" class="hover:text-gray-400">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
