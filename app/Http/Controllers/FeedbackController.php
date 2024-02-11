<?php
// app/Http/Controllers/FeedbackController.php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbackItems = Feedback::with('user','category')->get();

        $formattedFeedback = $feedbackItems->map(function ($feedback) {
            return [
                'id' => $feedback->id,
                'title' => $feedback->title,
                'description' => $feedback->description,
                'category' => $feedback->category->title,
                'name' => $feedback->user->name, // Access the username through the relationship
                // Add other fields as needed
            ];
        });

        return response()->json($formattedFeedback);
    }

    public function show($id)
    {
        $feedbackItem = Feedback::with('user','category')->find($id);

        if (!$feedbackItem) {
            return response()->json(['message' => 'Feedback item not found'], 404);
        }

        return response()->json($feedbackItem);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        $feedbackItem = Feedback::create($request->all());

        return response()->json($feedbackItem, 201);
    }

    public function update(Request $request, $id)
    {
        $feedbackItem = Feedback::find($id);

        if (!$feedbackItem) {
            return response()->json(['message' => 'Feedback item not found'], 404);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $feedbackItem->update($request->all());

        return response()->json($feedbackItem);
    }

    public function destroy($id)
    {
        $feedbackItem = Feedback::find($id);

        if (!$feedbackItem) {
            return response()->json(['message' => 'Feedback item not found'], 404);
        }

        $feedbackItem->delete();

        return response()->json(['message' => 'Feedback item deleted']);
    }
}
