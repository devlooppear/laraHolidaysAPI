<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlan;
use App\Mail\HolidayPlanCreated;
use App\Models\HolidayPlanLog;
use App\Models\ParticipantsGroup;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;

class HolidayPlanController extends Controller
{
    /**
     * Display a listing of the holiday plans.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $holidayPlans = HolidayPlan::with(['user', 'logs', 'participantsGroups.participant:id,name'])->get();

            return response()->json($holidayPlans);
        } catch (Exception $e) {
            Log::error('Error fetching holiday plans: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created holiday plan in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'date' => 'required|date',
                'location' => 'required|string|max:255',
                'user_id' => 'nullable|exists:users,id',
                'participants' => 'nullable|array', 
                'participants.*' => 'exists:users,id', 
            ]);

            // Set the authenticated user as the creator of the holiday plan
            $validatedData['user_id'] = auth()->user()->id;

            // Create the holiday plan
            $holidayPlan = HolidayPlan::create($validatedData);

            // Associate participants with the holiday plan
            if (isset($validatedData['participants'])) {
                foreach ($validatedData['participants'] as $participantId) {
                    // Create participants group with the holiday plan's ID and participant's ID
                    ParticipantsGroup::create([
                        'holiday_plan_id' => $holidayPlan->id,
                        'participant_id' => $participantId,
                    ]);
                }
            }

            // Send the holiday email
            Mail::to(auth()->user()->email)->send(new HolidayPlanCreated($holidayPlan));

            try {
                // Log the action if the creation was successful
                if ($holidayPlan) {
                    HolidayPlanLog::create([
                        'holiday_plan_id' => $holidayPlan->id,
                        'action' => 'store',
                        'user_id' => auth()->user()->id,
                    ]);
                }
            } catch (Exception $e) {
                Log::error("Can't log data: " . $e->getMessage());
            }

            // Generate and save the PDF
            $pdf = app('dompdf.wrapper')->loadView('pdf.holiday_plan', compact('holidayPlan'));
            $pdf->save(storage_path('app/holiday_plan_' . $holidayPlan->id . '.pdf'));

            // Return the response with the created holiday plan
            return response()->json($holidayPlan, 201);
        } catch (ValidationException $validationException) {
            // Handle validation errors
            $errors = $validationException->errors();

            // Log validation errors if needed
            Log::error('Validation errors: ' . json_encode($errors));

            return response()->json(['error' => 'Validation Failed', 'errors' => $errors], 422);
        } catch (Exception $e) {
            // Handle other exceptions
            Log::error('Error creating holiday plan: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error' . $e->getMessage()], 500);
        }
    }

    public function generatePDF($id)
    {
        try {
            $holidayPlan = HolidayPlan::with('participantsGroups')->findOrFail($id);

            $pdf = PDF::loadView('pdf.holiday_plan', compact('holidayPlan'));

            return $pdf->stream('holiday_plan.pdf');
        } catch (Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());

            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified holiday plan.
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $holidayPlan = HolidayPlan::with(['user', 'logs', 'participantsGroups'])->findOrFail($id);
            return response()->json($holidayPlan);
        } catch (Exception $e) {
            Log::error('Error fetching holiday plan: ' . $e->getMessage());
            return response()->json(['error' => 'Holiday plan not found'], 404);
        }
    }

    /**
     * Update the specified holiday plan in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            // Find the holiday plan by ID
            $holidayPlan = HolidayPlan::findOrFail($id);

            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'date' => 'nullable|date',
                'location' => 'nullable|string|max:255',
                'user_id' => 'nullable|exists:users,id',
            ]);

            // Automatically set the user_id based on the authenticated user
            $validatedData['user_id'] = auth()->user()->id;

            // Update the holiday plan with the validated data
            $holidayPlan->update($validatedData);

            try {
                // Log the action if the update was successful
                HolidayPlanLog::create([
                    'holiday_plan_id' => $id,
                    'action' => 'update',
                    'user_id' => auth()->user()->id,
                ]);
            } catch (Exception $e) {
                Log::error("Can't log data: " . $e->getMessage());
            }

            // Return the response with the updated holiday plan
            return response()->json($holidayPlan);
        } catch (ValidationException $validationException) {
            // Handle validation errors
            $errors = $validationException->errors();

            // Log validation errors if needed
            Log::error('Validation errors: ' . json_encode($errors));

            return response()->json(['error' => 'Validation Failed', 'errors' => $errors], 422);
        } catch (Exception $e) {
            // Handle other exceptions
            Log::error('Error updating holiday plan: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified holiday plan from storage.
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $holidayPlan = HolidayPlan::findOrFail($id);

            // Check if holiday plan exists before trying to delete
            if ($holidayPlan) {
                HolidayPlanLog::create([
                    'holiday_plan_id' => $id,
                    'action' => 'delete',
                    'user_id' => auth()->user()->id,
                ]);

                $holidayPlan->delete();
                return response()->json(['message' => 'Holiday plan deleted successfully']);
            } else {
                return response()->json(['error' => 'Holiday plan not found'], 404);
            }
        } catch (Exception $e) {
            Log::error('Error deleting holiday plan: ' . $e->getMessage());
            return response()->json(['Error deleting holiday plan: ' . $e->getMessage()], 500);
        }
    }
}
