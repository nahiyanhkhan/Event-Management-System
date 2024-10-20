<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    // List all events
    public function index()
    {
        return Event::all();
    }

    // Get a specific event
    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return $event;
    }

    // Create a new event
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        try {
            // Create the event using the validated data
            $event = Event::create($validatedData);
            return response()->json($event, 201); // Return created event with 201 status
        } catch (\Exception $e) {
            // Log the exception and return a 500 error response
            \Log::error('Event creation failed: ' . $e->getMessage());
            return response()->json(['message' => 'Event creation failed'], 500);
        }
    }


    // Update an existing event
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'date' => 'sometimes|required|date',
            'time' => 'sometimes|required|time',
            'location' => 'sometimes|required|string|max:255',
            'category' => 'sometimes|required|string|max:255',
        ]);

        $event->update($validatedData);
        return response()->json($event);
    }

    // Delete an event
    public function destroy($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully']);
    }
}

