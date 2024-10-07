<?php

namespace App\Http\Controllers;
use App\Models\Survey; 
use App\Models\Question; 
use App\Models\Credits; // Make sure to import the Credits model

use App\Models\Option; 
use Illuminate\Support\Facades\Schema;
use App\Models\Response; // Import the Survey model
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile; // Ensure this line exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NestedQuestion;

class SurveyController extends Controller
{

    public function showAddProfilePage()
    {
        // Return the view for adding a profile
        return view('user.addProfile'); // Ensure this is the correct path to your Blade view
    }
    
    public function saveProfile(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'age' => 'required|integer',
            'location' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female,other',
        ]);
    
        // Create or update the user profile
        $userId = auth()->id();
    
        UserProfile::updateOrCreate(
            ['userid' => $userId],  // Match the user ID
            [
                'age' => $validatedData['age'],
                'location' => $validatedData['location'],
                'gender' => $validatedData['gender'],
            ]
        );
    
        // Redirect the user to the dashboard after saving the profile
        return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
    }
    

    
//USERS

    // Retrieve the survey by ID or fail if not found
    public function show($id)
    {
        // Retrieve the survey by ID or fail if not found
        $survey = Survey::findOrFail($id); 
        
        // Assuming you store questions and options as JSON
        $questions = json_decode($survey->questions); // Decode questions from JSON
        $cleanedOptions = explode(',', $survey->options); // Split the options into an array
    
        // Pass the survey data to the view
        return view('user.survey_detail', [
            'survey' => $survey,
            'questions' => $questions, // Pass questions to the view
            'cleanedOptions' => $cleanedOptions, // Pass all options to the view
        ]);
    }

    // Pass the survey data to the view


public function submitAnswers(Request $request)
{
    $userId = $request->user()->id; // Get the user ID

    $surveyId = $request->input('survey_id'); // Get the survey ID
    // CREDITS
    $survey = Survey::findOrFail($surveyId);


    $credits = Credits::where('user_id', $userId)->first(); // Fetch the user's credits record

        if ($credits) {
            // Increase the amount (for example, adding 10 credits)
            $credits->amount += 10; // Adjust this value as needed
            $credits->save(); // Save the updated credits
        } else {
            // If no credits record exists for the user, you can create one
            Credits::create([
                'user_id' => $userId,
                'amount' => 10, // Initial amount if it didn't exist
            ]);
        }

    // Get the answers array from the request
    $answers = $request->input('answers'); // This will be an array of answers with question texts

    // Prepare an array to store the formatted answers
    $formattedAnswers = [];

    // Iterate through each answer
    foreach ($answers as $index => $data) {
        // Get the corresponding question text
        $questionText = $data['question_text'] ?? 'Unknown Question';

        // If the answer is an array (for checkboxes), convert it to a string
        $answer = $data['answer'];
        if (is_array($answer)) {
            $answer = implode(',', $answer); // Join checkbox answers with commas
        }

        // Store the question index, question text, and answer in the formatted answers array
        $formattedAnswers[] = [
            'question_index' => $index,
            'question_text' => $questionText,
            'answer' => $answer,
        ];
    }

    $formattedAnswersJson = json_encode($formattedAnswers); // Encode the formatted answers to JSON

    // Save the formatted answers to the survey_responses table
    $response = new Response();
    $response->survey_id = $surveyId;
    $response->user_id = $userId;
    $response->formatted_answers = $formattedAnswersJson; // Store JSON
    $response->save();

    // Flash a success message and redirect
    Session::flash('alert', 'Your action was successful! Please wait 1 hr while your credits are being verified.');
    return redirect()->route('dashboard'); // Assuming 'dashboard' is the name of the route for '/user'
}


public function userviewsurvey(){
    $userId = auth()->id(); // Get the logged-in user's ID
    $credits = Credits::where('user_id', $userId)->first(); // Fetch the user's credits record

    // Retrieve the user's profile
    $userProfile = UserProfile::where('userid', $userId)->first();
    
    // Check if the user profile exists
    if (!$userProfile) {
        // Redirect the user to the Add Profile page if no profile exists
        return redirect()->route('addProfilePage')->with('message', 'Please complete your profile before proceeding.');
    }
    
    // Extract demographic information
    $userAge = $userProfile->age;
    $userLocation = $userProfile->location;
    $userGender = $userProfile->gender;
    
    // Count the number of completed responses for the user
    $completedCount = DB::table('responses')
        ->where('user_id', $userId)
        ->count();
    
    // Get the IDs of surveys the user has completed
    $completedSurveyIds = Response::where('user_id', $userId)
        ->pluck('survey_id')
        ->toArray();
    
    // Fetch surveys that the user has not completed
    $surveysQuery = Survey::with('questions')->whereNotIn('id', $completedSurveyIds);
    if ($userAge !== null && $userGender !== null) {
        // Both age and gender are provided
        $surveysQuery->where('age', $userAge)->where('gender', $userGender);
    } elseif ($userAge !== null) {
        // Only age is provided
        $surveysQuery->whereNotNull('age')->where('age', $userAge);
    } elseif ($userGender !== null) {
        // Only gender is provided
        $surveysQuery->whereNotNull('gender')->where('gender', $userGender);
    }
    
    
    // Execute the query
    $surveys = $surveysQuery->get();
    // dd($surveys);
    
    // Pass the surveys and completed count to the dashboard view
    return view('user.dashboard', [
        'surveys' => $surveys,
        'completedCount' => $completedCount,
        'credits'=> $credits,
    ]);
    

}
//--------------------------------------------8-8-8-8-8--8-8-8----------------BUSINESS


public function viewsurveydetail($id)
{
    $survey = Survey::with('questions.options')->findOrFail($id);
    return view('business.view-survey-detail', compact('survey'));
}

public function analytics()
{
    $userId = Auth::id();
    
    // Fetch surveys created by the user
    $surveys = Survey::where('user_id', $userId)->get();
    
    // Prepare an array to store analytics data
    $analytics = [];

    // Process each survey
    foreach ($surveys as $survey) {
        // Fetch responses for each survey
        $responses = Response::where('survey_id', $survey->id)->get();

        // Initialize analytics for each survey
        $analytics[$survey->id] = [
            'survey_name' => $survey->survey_name,
            'responses_count' => $responses->count(), // Directly count responses
            'questions' => [],
        ];

        // Assuming survey questions are stored as JSON in the database
        $surveyQuestions = json_decode($survey->questions, true); // Decode JSON questions

        // Process each response
        foreach ($responses as $response) {
            $formattedAnswers = json_decode($response->formatted_answers, true); // Decode JSON
            
            // Process each answer in the response
            foreach ($formattedAnswers as $answer) {
                $questionIndex = $answer['question_index'];
                $questionText = $answer['question_text'];
                $userAnswer = $answer['answer'];

                // Get the question type from the survey's question data
                $questionType = $surveyQuestions[$questionIndex]['question_type'] ?? 'unknown';

                // Initialize analytics for each question if not already set
                if (!isset($analytics[$survey->id]['questions'][$questionIndex])) {
                    $analytics[$survey->id]['questions'][$questionIndex] = [
                        'question_text' => $questionText,
                        'question_type' => $questionType, // Add the question type
                        'answers' => [],
                        'total_responses' => 0, // Initialize total_responses
                    ];
                }

                // Store the answer and increment the total responses count for the question
                $analytics[$survey->id]['questions'][$questionIndex]['answers'][] = $userAnswer;
                $analytics[$survey->id]['questions'][$questionIndex]['total_responses']++;
            }
        }
    }
// dd($analytics);
    // Pass the analytics data to the view
    return view('business.view-analytics', compact('surveys', 'analytics'));
}



public function showsingle($id)
{
    // Fetch the specific survey based on the survey ID
    $survey = Survey::findOrFail($id);

    // Fetch responses for the selected survey
    $responses = Response::where('survey_id', $id)->get();

    // Assuming survey questions are stored as JSON in the database
    $surveyQuestions = json_decode($survey->questions, true); // Decode JSON questions

    // Initialize an array to store answers grouped by question
    $questionAnswers = [];

    // Process each response
    foreach ($responses as $response) {
        $formattedAnswers = json_decode($response->formatted_answers, true); // Decode JSON
        
        // Associate answers with their respective questions
        foreach ($formattedAnswers as $answer) {
            $questionIndex = $answer['question_index'];
            $questionText = $surveyQuestions[$questionIndex]['question_text'] ?? 'Unknown Question';
            $questionType = $surveyQuestions[$questionIndex]['question_type'] ?? 'unknown'; // Get question type
            $userAnswer = $answer['answer'];

            // Initialize the question entry if it doesn't exist
            if (!isset($questionAnswers[$questionIndex])) {
                $questionAnswers[$questionIndex] = [
                    'question_text' => $questionText,
                    'question_type' => $questionType, // Add question type
                    'answers' => [],
                    'ratings' => [], // Add a new array to store ratings
                ];
            }

            // Add the user's answer to the corresponding question
            $questionAnswers[$questionIndex]['answers'][] = $userAnswer;

            // If the question type is "rating", store the rating for average calculation
            if ($questionType === 'rating') {
                $questionAnswers[$questionIndex]['ratings'][] = (float) $userAnswer; // Ensure it's a float
            }
        }
    }

    // Calculate average ratings for rating type questions
    foreach ($questionAnswers as $index => $question) {
        if ($question['question_type'] === 'rating' && !empty($question['ratings'])) {
            $averageRating = array_sum($question['ratings']) / count($question['ratings']);
            $questionAnswers[$index]['average_rating'] = round($averageRating, 2); // Store average rating
        }
    }

    // Return the view with the survey and grouped answers
    return view('business.survey-responses', compact('survey', 'questionAnswers', 'responses'));
}


public function destroy($id)
{
    // Retrieve the survey by its ID
    $survey = Survey::findOrFail($id);

    // Delete the survey
    $survey->delete();

    // Redirect back to the surveys list with a success message
    return redirect()->back()->with('success', 'Survey deleted successfully.');
}

    public function create()
    {
                // Get the currently authenticated user
        return view('business.create-survey');
    }
    public function viewsurvey()
    {
                // Get the currently authenticated user
                {
                    // Retrieve the specific survey with its questions and options
                    $surveys = Survey::where('user_id', Auth::id())->get();
                

                
                    return view('business.view-survey', compact('surveys'));
                }
        // Return the view with survey data
    }
  
    public function store(Request $request)
    {
        $userId = Auth::id();
    
        // Validate request data
        $request->validate([
            'title' => 'required|string|max:255',
            'age' => 'nullable|string|max:50',
            'location' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.question_type' => 'required|string',
            'questions.*.options' => 'required|array',
            'questions.*.options.*' => 'required|string|max:255',
        ]);
            // $credits = (int) $request->credits;  // Casting credits to integer

        // dd($request->all());
        // Start a transaction
        DB::transaction(function () use ($request, $userId) {
            // Create a new survey entry in the database
            $survey = Survey::create([
                'user_id' => $userId,
                'title' => $request->input('title'),
                'age' => $request->input('age'),
                'location' => $request->input('location'),
                'gender' => $request->input('gender'),
                'credits' => (int) $request->credits, // Include credits here
                'respondent_limit' => (int) $request->respondent_limit, // Include credits here

                'created_at' => now(),
            ]);
    
            // Process each question
            foreach ($request->input('questions') as $questionData) {
                // Create the main question
                $question = Question::create([
                    'question_text' => $questionData['question_text'],
                    'question_type' => $questionData['question_type'],
                    'survey_id' => $survey->id,
                    'parent_question_id' => null, // Adjust if needed for nested questions
                ]);
    
                // Create options for the main question
                foreach ($questionData['options'] as $optionText) {
                    Option::create([
                        'option_text' => $optionText,
                        'question_id' => $question->id,
                    ]);
                }
    
                // Process nested questions if they exist
                if (isset($questionData['nested_questions'])) {
                    foreach ($questionData['nested_questions'] as $nestedQuestionData) {
                        $nestedQuestion = Question::create([
                            'question_text' => $nestedQuestionData['question_text'],
                            'question_type' => $nestedQuestionData['question_type'],
                            'survey_id' => $survey->id,
                            'parent_question_id' => $question->id, // Reference to the parent question
                        ]);
    
                        // Create options for the nested question
                        foreach ($nestedQuestionData['options'] as $optionText) {
                            Option::create([
                                'option_text' => $optionText,
                                'question_id' => $nestedQuestion->id,
                            ]);
                        }
                    }
                }
            }
        });
    
        // Redirect with success message
        return redirect()->route('business')->with('success', 'Survey created successfully.');
    }
    
    

    public function storeSurveyWithQuestions(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'age' => 'nullable|string|max:50', // Validate age
            'location' => 'nullable|string|max:255', // Validate location
            'gender' => 'nullable|string|max:50', // Validate gender
            'questions' => 'required|array', // Ensure questions are provided
            'questions.*.question_text' => 'required|string|max:255', // Validate each question text
            'questions.*.question_type' => 'required|string|in:dropdown,rating,checkbox,true-false', // Validate question type
            'questions.*.options' => 'nullable|array', // Validate options (if applicable)
        ]);

        // Create a new survey
        $survey = Survey::create([ // Ensure Survey model is used
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'age' => $request->input('age'), // Capture demographic info
            'location' => $request->input('location'), // Capture demographic info
            'gender' => $request->input('gender'), // Capture demographic info
            'created_at' => now(), // Set created_at to the current timestamp
        ]);

        // Loop through each question and save it to the database
        foreach ($request->input('questions') as $questionData) {
            $question = new Question([
                'question_text' => $questionData['question_text'],
                'question_type' => $questionData['question_type'],
                'options' => isset($questionData['options']) ? json_encode($questionData['options']) : null, // Convert options to JSON if necessary
                'survey_id' => $survey->id, // Associate the question with the newly created survey
            ]);
            
            $question->save(); // Save the question to the database
        }

        // Return a success response
        return redirect()->route('business')->with('success', 'Survey created successfully.');
    }
    protected function awardCredits($userId, $amount)
    {
        Credit::create([
            'user_id' => $userId,
            'amount' => $amount,
        ]);

}
public function showCredits()
{
    $credits = Credits::all(); // Fetch all records from the credits table
    dd($credits); // Dump and die to display the records
}

}