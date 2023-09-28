<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Doctor;
use App\Models\Reservations;
use Illuminate\Http\Request;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $doctorName = $request->input('doctorName');
        $selectedDay  = $request->input('selectedDay');
        $doc_id = Doctor::where('name', '=', $doctorName)->first()->id;

        $day = Day::where('doctor_id', $doc_id)->first();
        $desiredDay = trim($selectedDay); // إزالة الفراغات من اليوم المطلوب

        $days = [
            trim($day->day1),
            trim($day->day2),
            trim($day->day3),
            trim($day->day4),
            trim($day->day5),
            trim($day->day6),
            trim($day->day7)
        ];

        $found = false;

        foreach ($days as $dayValue) {
            if ($dayValue == $desiredDay) {
                $found = true;
                print($dayValue);
                break;
            }
        }

        if ($found) {
            return response()->json(1);
        } else {
            return response()->json(0);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Day $day)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Day $day)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Day $day)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Day $day)
    {
        //
    }

    public function info($id)
    {
        $Reservation = Reservations::where('idNumber', $id)
            ->orderBy('created_at', 'desc')
            ->first();
        return response()->view('frontend.data2', ['data' => $Reservation]);
    }
}
