<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Survey</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .input-field {
            padding: 10px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            background-color: #FFFFFF;
        }

        .remove-option-btn,
        .remove-question-btn,
        .remove-nested-question-btn {
            color: #E11D48;
            cursor: pointer;
        }

        .add-option-btn,
        .add-question-btn,
        .submit-btn,
        .add-nested-question-btn {
            background-color: #4F46E5;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .add-option-btn:hover,
        .add-question-btn:hover,
        .submit-btn:hover,
        .add-nested-question-btn:hover {
            background-color: #4338CA;
        }

        .back-btn {
            background-color: #E11D48;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #BE123C;
        }

    </style>
</head>
<body class="bg-gray-100 flex flex-col h-screen">
    
    <!-- Navbar Component -->
    <x-navbar />

    <!-- Main Container with Sidebar and Form -->
    <div class="flex flex-1">
        
        <!-- Sidebar Component -->
        <x-sidebar />

        <!-- Main Content (Form) -->
        <div class="container max-w-5xl mx-auto p-6">
            <h2 class="text-3xl font-bold text-gray-700 mb-7">Create Your Survey</h2>

            <form id="survey-form" action="{{ route('survey.store') }}" method="POST" onsubmit="return validateSurvey()">
                @csrf
                
                <!-- Survey Name Input -->
                <div class="mb-6">
                    <label for="survey_name" class="block text-lg font-medium text-gray-700 mb-2">Survey Name</label>
                    <input type="text" name="title" required class="input-field w-full focus:outline-none" placeholder="Enter survey name">
                </div>

                <!-- Survey Description Input -->


                <!-- Grid Layout for Credits, Respondent Limit, and Demographics -->
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <!-- Credits and Respondent Limit Box -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Survey Details</h3>
                        
                        <!-- Credits for Completion Input -->
                        <div class="mb-6">
                            <label for="credits" class="block text-lg font-medium text-gray-700 mb-2">Credits for Completion</label>
                            <input type="number" name="credits" required class="input-field w-full focus:outline-none" min="0" placeholder="Enter credits for completing the survey">
                        </div>

                        <!-- Respondent Limit Input -->
                        <div class="mb-6">
                            <label for="respondent_limit" class="block text-lg font-medium text-gray-700 mb-2">Respondent Limit</label>
                            <input type="number" name="respondent_limit" required class="input-field w-full focus:outline-none" min="1" placeholder="Enter maximum number of respondents">
                        </div>
                    </div>

                    <!-- Demographics Box -->
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-bold text-gray-700 mb-4">Target Demographics</h3>
                        <div class="mb-4">
                            <label for="age" class="block text-md font-medium text-gray-700 mb-2">Target Age</label>
                            <input type="text" name="age" class="input-field w-full focus:outline-none" placeholder="e.g., 18-25">
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-md font-medium text-gray-700 mb-2">Target Location</label>
                            <input type="text" name="location" class="input-field w-full focus:outline-none" placeholder="e.g., New York, USA">
                        </div>
                        <div class="mb-4">
                            <label for="gender" class="block text-md font-medium text-gray-700 mb-2">Target Gender</label>
                            <select name="gender" class="input-field w-full focus:outline-none">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                                <option value="prefer_not_to_say">Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div id="question-container" class="space-y-8">
                    <div class="question p-4 bg-white rounded-lg shadow-lg relative">
                        <label class="block text-lg font-medium text-gray-700">Question 1</label>
                        <input type="text" name="questions[0][question_text]" required class="input-field w-full mt-2" placeholder="Enter your question">
                        
                        <select name="questions[0][question_type]" class="input-field w-full mt-4" onchange="toggleOptions(this)">
                            <option value="dropdown">Dropdown</option>
                            <option value="rating">Rating</option>
                            <option value="checkbox">Checkboxes</option>
                            <option value="true-false">True/False</option>
                        </select>

                        <div class="options mt-4">
                            <label class="block text-md font-medium text-gray-700 mb-2">Options</label>
                            <div class="options-container space-y-2">
                                <div class="option-item flex items-center">
                                    <input type="text" name="questions[0][options][]" class="input-field w-full mt-2" placeholder="Enter option 1">
                                    <span class="remove-option-btn ml-4" onclick="removeOption(this)">Remove</span>
                                </div>
                                <div class="option-item flex items-center">
                                    <input type="text" name="questions[0][options][]" class="input-field w-full mt-2" placeholder="Enter option 2">
                                    <span class="remove-option-btn ml-4" onclick="removeOption(this)">Remove</span>
                                </div>
                            </div>
                            <button type="button" class="add-option-btn mt-4" onclick="addOption(this, 0)">Add Option</button>
                        </div>
                    </div>
                </div>

                <!-- Add Question Button -->
                <div class="flex justify-between mt-8">
                    <button type="button" onclick="addQuestion()" class="add-question-btn">Add Another Question</button>
                    <button type="submit" class="submit-btn">Submit Survey</button>
                </div>
            </form>

            <!-- Back to Dashboard Button -->
            <div class="mt-8 flex justify-center">
                <a href="{{ route('dashboard') }}" class="back-btn">Back to Dashboard</a>
            </div>
        </div>
    </div>

    <script>
let questionCount = 1;

function addQuestion() {
    const container = document.getElementById('question-container');
    const newQuestion = document.createElement('div');
    newQuestion.classList.add('question', 'p-4', 'bg-white', 'rounded-lg', 'shadow-lg', 'relative');
    newQuestion.innerHTML = `
        <label class="block text-lg font-medium text-gray-700">Question ${questionCount + 1}</label>
        <input type="text" name="questions[${questionCount}][question_text]" required class="input-field w-full mt-2" placeholder="Enter your question">
        <select name="questions[${questionCount}][question_type]" class="input-field w-full mt-4" onchange="toggleOptions(this)">
            <option value="dropdown">Dropdown</option>
            <option value="rating">Rating</option>
            <option value="checkbox">Checkboxes</option>
            <option value="true-false">True/False</option>
        </select>
        <div class="options mt-4">
            <label class="block text-md font-medium text-gray-700 mb-2">Options</label>
            <div class="options-container space-y-2">
                <div class="option-item flex items-center">
                    <input type="text" name="questions[${questionCount}][options][]" class="input-field w-full mt-2" placeholder="Enter option 1">
                    <span class="remove-option-btn ml-4" onclick="removeOption(this)">Remove</span>
                </div>
                <div class="option-item flex items-center">
                    <input type="text" name="questions[${questionCount}][options][]" class="input-field w-full mt-2" placeholder="Enter option 2">
                    <span class="remove-option-btn ml-4" onclick="removeOption(this)">Remove</span>
                </div>
            </div>
            <button type="button" class="add-option-btn mt-4" onclick="addOption(this, ${questionCount})">Add Option</button>
        </div>
    `;
    container.appendChild(newQuestion);
    questionCount++;
}

function removeOption(element) {
    const optionItem = element.parentElement;
    optionItem.remove();
}

function addOption(button, questionIndex) {
    const optionsContainer = button.parentElement.querySelector('.options-container');
    const newOption = document.createElement('div');
    newOption.classList.add('option-item', 'flex', 'items-center');
    newOption.innerHTML = `
        <input type="text" name="questions[${questionIndex}][options][]" class="input-field w-full mt-2" placeholder="Enter option">
        <span class="remove-option-btn ml-4" onclick="removeOption(this)">Remove</span>
    `;
    optionsContainer.appendChild(newOption);
}

function toggleOptions(selectElement) {
    // Implement your logic to toggle options based on question type
}

function validateSurvey() {
    // Implement your validation logic if needed
    return true; // Allow form submission
}    </script>

</body>
