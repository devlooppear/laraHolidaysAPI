<?php

namespace App\Http\Controllers;

use App\Models\HolidayPlanLog;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class HolidayPlanLogController extends Controller
{
    /**
     * Display a listing of the holiday plan logs.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $holidayPlanLogs = HolidayPlanLog::all();
            return response()->json($holidayPlanLogs);
        } catch (Exception $e) {
            Log::error('Error fetching holiday plan logs: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified holiday plan log.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $holidayPlanLog = HolidayPlanLog::findOrFail($id);
            return response()->json($holidayPlanLog);
        } catch (Exception $e) {
            Log::error('Error fetching holiday plan log: ' . $e->getMessage());
            return response()->json(['error' => 'Holiday plan log not found'], 404);
        }
    }

    /**
     * Remove the specified holiday plan log from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $holidayPlanLog = HolidayPlanLog::findOrFail($id);
            $holidayPlanLog->delete();
            return response()->json(['message' => 'Holiday plan log deleted successfully']);
        } catch (Exception $e) {
            Log::error('Error deleting holiday plan log: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
