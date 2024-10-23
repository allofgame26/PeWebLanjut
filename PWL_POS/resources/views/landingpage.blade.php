<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Site</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div>
                    <a href="/" class="text-2xl font-bold text-gray-800">Your Logo</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="#features" class="text-gray-600 hover:text-gray-900">Features</a>
                    <a href="#about" class="text-gray-600 hover:text-gray-900">About</a>
                    <a href="#contact" class="text-gray-600 hover:text-gray-900">Contact</a>
                    <a href="{{ url('/login' )}}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-6xl mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Our Platform</h1>
                <p class="text-xl text-gray-600 mb-8">Discover amazing features and boost your productivity</p>
                <div class="space-x-4">
                    <a href="/login" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600">Get Started</a>
                    <a href="#features" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-md hover:bg-gray-300">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="bg-gray-100 py-16">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Our Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Feature 1</h3>
                    <p class="text-gray-600">Description of your amazing feature goes here.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Feature 2</h3>
                    <p class="text-gray-600">Description of your amazing feature goes here.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold mb-4">Feature 3</h3>
                    <p class="text-gray-600">Description of your amazing feature goes here.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-6 md:mb-0">
                    <h3 class="text-xl font-bold mb-4">Your Company</h3>
                    <p class="text-gray-400">Making the world a better place.</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-white">Home</a></li>
                            <li><a href="#about" class="text-gray-400 hover:text-white">About</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-white">Features</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Contact</h4>
                        <ul class="space-y-2">
                            <li class="text-gray-400">info@example.com</li>
                            <li class="text-gray-400">+1 234 567 890</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-gray-700 text-center">
                <p class="text-gray-400">&copy; 2024 Your Company. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>