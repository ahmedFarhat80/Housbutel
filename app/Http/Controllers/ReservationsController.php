<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use ZipArchive;

use App\Models\Category;
use App\Models\Day;
use App\Models\Doctor;
use App\Models\Reservations;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::with('Category')->get();
        $Category = Category::all();
        return response()->view('frontend.index', ['Category' => $Category, 'doctors' => $doctors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function data(Request $request)
    {
        $validator = $request->validate([
            'idNumber' => 'required|numeric',
        ], [
            'name.required' => 'يجب ادخال الرقم المدني',
            'name.numeric' => 'ادخل الرقم المدني بشكل صحيح'
        ]);
        if ($validator) {
            $tables = Reservations::where('idNumber', $request->idNumber)->get();
            return response()->view('frontend.data', ['tables' => $tables]);
        } else {
            session()->flash('message', 'هناك أخطاء في البيانات المدخلة');
            return redirect()->back();
        }
    }

    public function create()
    {
        $tables = Reservations::orderBy('created_at', 'desc')->get();
        $Category = Category::all();
        return response()->view('backend.table', ['tables' => $tables, 'Category' => $Category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $language = session('lang');
        if ($language == "en") {
            $validator = Validator($request->all(), [
                'summaryDate' => 'required|date',
                'summaryDay' => 'required|string',
                'summaryDepartment' => 'required|string',
                'summaryDoctor' => 'required|string',
                'summaryTime' => 'required|string',
                'firstName' => 'required|string',
                'middleName' => 'string',
                'lastName' => 'required|string',
                'idNumber' => 'required|numeric',
                'idType' => 'required|string',
                'phoneNumber' => 'required', 'numeric', 'digits:8',
                "day" => 'nullable',
                "month" => 'nullable',
                "year" => 'nullable',
            ]);
        } else {
            $validator = Validator($request->all(), [
                'summaryDate' => 'required|date',
                'summaryDay' => 'required|string',
                'summaryDepartment' => 'required|string',
                'summaryDoctor' => 'required|string',
                'summaryTime' => 'required|string',
                'firstName' => 'required|string',
                'middleName' => 'string',
                'lastName' => 'required|string',
                'idNumber' => 'required|numeric',
                'idType' => 'required|string',
                'phoneNumber' => 'required', 'numeric', 'digits:8',
                "day" => 'nullable',
                "month" => 'nullable',
                "year" => 'nullable',

            ], [
                'required' => 'حقل :attribute مطلوب.',
                'date' => 'حقل :attribute يجب أن يكون تاريخًا صالحًا.',
                'string' => 'حقل :attribute يجب أن يكون نصًا.',
                'in' => 'حقل :attribute يجب أن يكون قيمة صحيحة.',
                'mimes' => 'نوع الملف في حقل :attribute غير مدعوم.',
                'numeric' => 'حقل :attribute يجب أن يكون رقمًا.',
                'digits' => 'حقل :attribute يجب أن يحتوي على :digits أرقام.',
            ], [
                'summaryDate' => 'تاريخ الملخص',
                'summaryDay' => 'يوم الملخص',
                'summaryDepartment' => 'قسم الملخص',
                'summaryDoctor' => 'دكتور الملخص',
                'summaryTime' => 'وقت الملخص',
                'firstName' => 'الاسم الأول',
                'middleName' => 'الاسم الأوسط',
                'lastName' => 'اسم العائلة',
                'idNumber' => 'رقم الهوية',
                'idType' => 'نوع الهوية',
                'phoneNumber' => 'رقم الهاتف',
            ]);
        }


        if (!$validator->fails()) {
            $doctor = $request->get('summaryDoctor');
            $time = $request->get('summaryTime');
            $date = $request->get('summaryDate');
            $tables = Reservations::all();

            foreach ($tables as $table) {
                if ($table->summaryDoctor == $doctor && $table->summaryDate == $date && $table->summaryTime == $time) {
                    return response()->json([
                        'message' => __("error_time"),
                    ], Response::HTTP_BAD_REQUEST);
                }
            }

            $reservations = new Reservations();
            $reservations->summaryDate = $request->get('summaryDate');
            $reservations->summaryDay = $request->get('summaryDay');
            $reservations->summaryDepartment = $request->get('summaryDepartment');
            $reservations->summaryDoctor = $request->get('summaryDoctor');
            $reservations->summaryTime = $request->get('summaryTime');
            $reservations->firstName = $request->get('firstName');
            $reservations->middleName = $request->get('middleName');
            $reservations->lastName = $request->get('lastName');
            $reservations->idNumber = $request->get('idNumber');
            $reservations->idType = $request->get('idType');
            $reservations->phoneNumber = $request->get('phoneNumber');
            if ($request->get('idType') == "بطاقة العائلة") {
                if (empty($request->get('day')) && empty($request->get('month')) && empty($request->get('year'))) {
                    return response()->json([
                        'message' => __("error_Family")
                    ], Response::HTTP_BAD_REQUEST);
                }
                if (empty($request->get('day')) || !is_numeric($request->get('day')) || $request->get('day') < 1 || $request->get('day') > 31) {
                    return response()->json([
                        'message' =>  __("error_day")
                    ], Response::HTTP_BAD_REQUEST);
                }

                if (empty($request->get('month')) || !is_numeric($request->get('month')) || $request->get('month') < 1 || $request->get('month') > 12) {
                    return response()->json([
                        'message' => __("error_month")
                    ], Response::HTTP_BAD_REQUEST);
                }

                if (empty($request->get('year')) || !is_numeric($request->get('year')) || $request->get('year') < 2023 || $request->get('year') > 2099) {
                    return response()->json([
                        'message' => __("error_year")
                    ], Response::HTTP_BAD_REQUEST);
                }
            }
            $reservations->day = $request->get('day');
            $reservations->date = $request->get('month');
            $reservations->year = $request->get('year');

            // $image = $request->file('idImage');
            // $imageName = time() . '_image.' . $image->getClientOriginalExtension();
            // $image->storeAs('images', $imageName, ['disk' => 'public']);
            // $reservations->image = $imageName;
            $doctorName = $request->get('summaryDoctor');
            $selectedDay  = $request->get('summaryDay');
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

            // التحقق من وجود الحجز بناءً على idNumber والتاريخ
            $idNumber = $request->input('idNumber');
            $summaryDate = $request->input('summaryDate');

            $existingAppointment = Reservations::where('idNumber', $idNumber)
                ->whereDate('summaryDate', $summaryDate)
                ->first();

            if ($existingAppointment) {
                // إذا تم العثور على حجز مسبق مع نفس idNumber ونفس التاريخ
                return response()->json([
                    'message' => __("not_possible")
                ], Response::HTTP_BAD_REQUEST, [], JSON_UNESCAPED_UNICODE); // أضف الخيار JSON_UNESCAPED_UNICODE هنا
            }



            if ($found) {
                $isSaved =  $reservations->save();
            } else {
                return response()->json([
                    'message' => __("not_available") . implode(', ', $days)
                ], Response::HTTP_BAD_REQUEST);
            }

            return response()->json([
                'message' => $isSaved ? __("Successfully") : __("Failed")
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            // VALIDATION FAILED
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservations = Reservations::find($id);
        $reservations->readable = 1;
        $reservations->save();
        $Category = Category::where('name', '=', "$reservations->summaryDepartment")->first();
        return response()->view('backend.pdf', ['reservations' => $reservations, 'Category' => $Category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservations $reservations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservations $reservations)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservations $reservations)
    {
        //
    }

    public function check_time()
    {
        //
    }

    public function generatePDF(Request $request)
    {
        $selectedIds = json_decode($request->input('selectedIds'));
        // تصفية المصفوفة لإزالة القيم التي تساوي null
        $filteredIds = array_filter($selectedIds, function ($id) {
            return $id !== null;
        });
        // إنشاء مصفوفة لتخزين ملفات PDF المختلفة
        $pdfFiles = [];

        foreach ($filteredIds as $id) {

            $reservations = Reservations::find($id); // استعلام قاعدة البيانات للحصول على البيانات المرتبطة بالـ ID

            $cssFilePath = public_path('pdf/css/style.css');

            $mpdf = new Mpdf([
                'tempDir' => public_path('temp'), // اختياري: مجلد مؤقت لتخزين الملفات المؤقتة
                'format' => 'A4',
                'mode' => 'utf-8',
                'default_font_size' => 0,
                'default_font' => '',
                'margin_left' => 15,
                'margin_right' => 15,
                'margin_top' => 16,
                'margin_bottom' => 16,
                'margin_header' => 9,
                'margin_footer' => 9,
                'css' => $cssFilePath, // تحديد مسار ملف الـ CSS هنا
            ]);


            // قم بتمرير الصفحة HTML التي تريد تحويلها إلى PDF إلى مثيل mpdf
            $html = view('pdf', ['reservations' => $reservations])->render();
            $mpdf->WriteHTML($html);

            // حفظ الملف PDF
            $pdfFilename = 'invoice_' . $id . '.pdf';
            $mpdf->Output($pdfFilename, 'F');

            // إضافة الملف الحالي إلى مصفوفة الملفات
            $pdfFiles[] = [
                'filename' => $pdfFilename,
                'path' => $pdfFilename,
            ];
        }

        // إنشاء ملف مضغوط في الذاكرة
        $zip = new ZipArchive();
        $zipFilename = 'invoices.zip';
        $zip->open($zipFilename, ZipArchive::CREATE);

        foreach ($pdfFiles as $file) {
            $zip->addFile($file['path'], $file['filename']);
        }

        $zip->close();

        // تعيين رؤوس الاستجابة الصحيحة للملف المضغوط
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
        header('Content-Length: ' . filesize($zipFilename));

        // إرسال الملف المضغوط إلى المتصفح
        readfile($zipFilename);

        // حذف الملف المضغوط بعد الانتهاء
        unlink($zipFilename);

        // حذف ملفات PDF بعد الانتهاء إذا كنت بحاجة
        foreach ($pdfFiles as $file) {
            unlink($file['path']);
        }
    }
}
