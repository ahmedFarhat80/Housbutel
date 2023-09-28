<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Day;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctore = Doctor::with('Category')->get();
        $Category = Category::all();
        return response()->view('backend.doctor', ['doctore' => $doctore, 'Category' => $Category]);
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

        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'select' => 'required|numeric',
            "flexCheckDefault1" => 'nullable',
            "flexCheckDefault2" => 'nullable',
            "flexCheckDefault3" => 'nullable',
            "flexCheckDefault4" => 'nullable',
            "flexCheckDefault5" => 'nullable',
            "flexCheckDefault6" => 'nullable',
            "flexCheckDefault7" => 'nullable',
        ]);

        if (!$validator->fails()) {
            if (
                $request->get('flexCheckDefault1') === null &&
                $request->get('flexCheckDefault2') === null &&
                $request->get('flexCheckDefault3') === null &&
                $request->get('flexCheckDefault4') === null &&
                $request->get('flexCheckDefault5') === null &&
                $request->get('flexCheckDefault6') === null &&
                $request->get('flexCheckDefault7') === null
            ) {
                return response()->json([
                    'message' => "يجب اختيار على الأقل يوم دوام واحد"
                ], Response::HTTP_BAD_REQUEST);
            }

            $Doctor = new Doctor();
            $Doctor->name = $request->get('name');
            $Doctor->category_id = $request->get('select');
            $day = new Day();
            $isSavedDoctor =  $Doctor->save();

            if ($isSavedDoctor) {
                $day = new Day();
                $day->day1 = $request->get('flexCheckDefault1');
                $day->day2 = $request->get('flexCheckDefault2');
                $day->day3 = $request->get('flexCheckDefault3');
                $day->day4 = $request->get('flexCheckDefault4');
                $day->day5 = $request->get('flexCheckDefault5');
                $day->day6 = $request->get('flexCheckDefault6');
                $day->day7 = $request->get('flexCheckDefault7');
                $day->doctor_id = $Doctor->id; // تعيين doctor_id بعد حفظ الطبيب
                $isSavedDay = $day->save(); // حفظ الأيام والتحقق مما إذا تم بنجاح

                return response()->json([
                    'message' => $isSavedDay ? "تم اضافة الطبيب بنجاح" : "فشلت عملية اضافة الطبيب",
                ], $isSavedDay ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'message' => "فشلت عملية اضافة الطبيب"
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:30',
            'select' => 'required|numeric',
            "flexCheckDefault8" => 'nullable',
            "flexCheckDefault9" => 'nullable',
            "flexCheckDefault10" => 'nullable',
            "flexCheckDefault11" => 'nullable',
            "flexCheckDefault12" => 'nullable',
            "flexCheckDefault13" => 'nullable',
            "flexCheckDefault14" => 'nullable',
        ]);

        if (!$validator->fails()) {

            $doctor->name = $request->get('name');
            $doctor->category_id = $request->get('select');
            $isSaved =  $doctor->save();


            $day = Day::where('doctor_id', $doctor->id)->first();
            $day->day1 = $request->get('flexCheckDefault8');
            $day->day2 = $request->get('flexCheckDefault9');
            $day->day3 = $request->get('flexCheckDefault10');
            $day->day4 = $request->get('flexCheckDefault11');
            $day->day5 = $request->get('flexCheckDefault12');
            $day->day6 = $request->get('flexCheckDefault13');
            $day->day7 = $request->get('flexCheckDefault14');
            $isSavedDay = $day->save(); // حفظ الأيام والتحقق مما إذا تم بنجاح




            return response()->json([
                'message' => $isSaved ? "Saved Successfully" : "Failed to save"
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            //VALIDATION FAILED
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        // $category = Category::find($id);
        $isDeleted = $doctor->delete();
        if ($isDeleted) {
            DB::table('days')->where('doctor_id', $doctor->id)->delete();
            return response()->json(['icon' => 'success', 'title' => 'Success!', 'text' => 'Deleted successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'Failed!', 'text' => 'Delete failed'], Response::HTTP_BAD_REQUEST);
        }
    }
}
