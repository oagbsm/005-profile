<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Details - {{ $survey->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<header class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <div class="text-2xl font-bold">
        <span class="text-yellow-500">SomSurvey</span> Business Solutions
    </div>
    <div class="flex items-center space-x-4">
        <span class="material-icons text-white">notifications</span>
        <span class="material-icons text-white">help_outline</span>
        <img src="https://placehold.co/40x40" alt="User Avatar" class="w-10 h-10 rounded-full">
    </div>
</header>

<div class="container mx-auto p-6">
    <!-- Survey Header -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $survey->title }}</h1>
        <p class="text-lg text-gray-600">Survey ID: {{ $survey->id }}</p>
        <p class="text-lg text-gray-600">Created by User ID: {{ $survey->user_id }}</p>
        <p class="text-lg text-gray-600">Target Age: {{ $survey->age }}</p>
        <p class="text-lg text-gray-600">Target Location: {{ $survey->location }}</p>
        <p class="text-lg text-gray-600">Target Gender: {{ $survey->gender }}</p>
    </div>

    <!-- Survey Questions Section -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Survey Questions</h2>
        <div class="space-y-4">
            @if ($survey->questions->isEmpty())
                <p class="text-gray-600">No questions available for this survey.</p>
            @else
                @foreach ($survey->questions as $index => $question)
                    <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                        <span class="text-xl font-medium text-gray-700">Q{{ $index + 1 }}:</span>
                        <span class="text-lg text-gray-800">{{ htmlspecialchars($question->question_text) }}</span>

                        <div class="mt-2">
                            <span class="text-lg font-medium text-gray-700">Type:</span>
                            <span class="text-gray-800">{{ ucfirst($question->question_type) }}</span>
                        </div>

                        <div class="mt-2">
                            <span class="text-lg font-medium text-gray-700">Options:</span>
                            <ul class="list-disc ml-5 text-gray-800">
                                @if ($question->question_type === 'true-false')
                                    <li>True</li>
                                    <li>False</li>
                                @else
                                    @foreach ($question->options as $option)
                                        <li>{{ htmlspecialchars($option->option_text) }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex justify-start">
        <a href="{{ route('business.viewsurvey') }}" class="inline-block bg-gray-800 text-white rounded-md px-4 py-2 hover:bg-gray-700">Back to Surveys</a>
    </div>
</div>

</body>
</html>
