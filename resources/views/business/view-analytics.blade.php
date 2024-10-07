<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Header -->
<x-navbar />
<div class="flex h-screen">
<x-sidebar />

<!-- Main Content -->
<main class="flex-1 p-8 px-10 ">
    <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">Survey Analytics</h1>

    <!-- Surveys Analytics List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($surveys as $survey)
            <div class="bg-white rounded-lg shadow-md p-6">
                <a href="{{ route('survey.showsingle', ['id' => $survey->id]) }}" class="block">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $survey->title }}</h2>
                </a>

                <!-- Show total responses and respondent limit only once -->
                <p class="mt-4 text-gray-600">
                    Total Responses: <span class="font-bold">{{ $analytics[$survey->id]['responses_count'] ?? 0 }}</span> /
                    Respondent Limit: <span class="font-bold">{{ $survey->respondent_limit ?? 'N/A' }}</span>
                </p>

                <!-- List of questions -->

            </div>
        @endforeach
    </div>

    <!-- Back Button -->
    <div class="mt-6 text-center">
        <a href="{{ route('dashboard') }}" class="inline-block bg-gray-800 text-white rounded-md px-6 py-2 hover:bg-gray-700">Back to Dashboard</a>
    </div>
</main>
</div>

</body>
</html>
