<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Surveys</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-100 flex flex-col h-screen">

    <!-- Header Section -->


    <!-- Main Container with Sidebar and Table -->
    <x-navbar />


<!-- Sidebar and Dashboard Content -->
<div class="flex h-screen">
    <!-- Sidebar -->
    <x-sidebar />
        <!-- Main Content -->
        <main class="flex-1 p-8 bg-gray-50">
            <div class="container mx-auto">
                <h1 class="text-3xl font-bold text-gray-700 mb-8">Your Surveys</h1>

                @if ($surveys->isEmpty())
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <p class="text-gray-600">You have no surveys created yet.</p>
                    </div>
                @else
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($surveys as $survey)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $survey->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $survey->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $survey->description }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('business.view-survey-detail', $survey->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <form action="{{ route('surveys.destroy', $survey->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this survey?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 ml-4">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-8 flex justify-center">
                    <a href="{{ route('dashboard') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700">Back to Dashboard</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
