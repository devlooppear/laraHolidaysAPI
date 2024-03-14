<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParticipantsGroup;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ParticipantsGroupController extends Controller
{
    public function index()
    {
        $participantsGroups = ParticipantsGroup::get();
        return response()->json($participantsGroups, 200);
    }

    public function show($id)
    {
        try {
            $participantsGroup = ParticipantsGroup::findOrFail($id);
            return response()->json(['data' => $participantsGroup], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Participant Group not found', 'error' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            // Define your validation rules as an array
            $rules = [
                'holiday_plan_id' => 'required',
                'participant_id' => 'required',
            ];

            // Use the validate method with the correct arguments
            $request->validate($rules);

            // Retrieve validated data from the request
            $data = $request->only(['holiday_plan_id', 'participant_id']);

            // Create a new ParticipantsGroup instance without setting the 'id'
            $participantsGroup = new ParticipantsGroup();
            $participantsGroup->fill($data);
            $participantsGroup->save();

            return response()->json(['message' => 'ParticipantsGroup updated successfully', 'data' => $participantsGroup], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the ParticipantsGroup instance by ID
            $participantsGroup = ParticipantsGroup::findOrFail($id);

            // Define your validation rules as an array
            $rules = [
                'holiday_plan_id' => 'required',
                'participant_id' => 'required',
            ];

            // Use the validate method with the correct arguments
            $request->validate($rules);

            // Retrieve validated data from the request
            $data = $request->only(['holiday_plan_id', 'participant_id']);

            // Update the ParticipantsGroup instance with the new data
            $participantsGroup->update($data);

            return response()->json(['message' => 'ParticipantsGroup updated successfully', 'data' => $participantsGroup], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Participant Group not found', 'error' => $e->getMessage()], 404);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $participantsGroup = ParticipantsGroup::findOrFail($id);
            $participantsGroup->delete();

            return response()->json(['message' => 'ParticipantsGroup deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }
}
