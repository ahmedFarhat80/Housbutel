<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الحجوزات السابقة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container  mb-4">
        <h2 class="text-center mb-4"> جميع الحجوزات التي قام بها المستخدم </h2>
        <div class="tab-content mt-3" id="clinicTabsContent">
            @foreach ($tables as $table)
                <div class="summary-section mt-4 row">
                    <h4 class="text-center mb-4"> معرف الحجز : {{ $table->id }}</h4>
                    <div class="col-6">
                        <div class="summary-item">
                            <strong>التاريخ:</strong> <span id="summaryDate"> {{ $table->summaryDate }} </span>
                            <input type="hidden" id="hiddenSummaryDate" name="hiddenSummaryDate">
                        </div>
                        <div class="summary-item">
                            <strong>اليوم:</strong> <span id="summaryDay"> {{ $table->summaryDay }} </span>
                            <input type="hidden" id="hiddenSummaryDay" name="hiddenSummaryDay">
                        </div>
                        <div class="summary-item">
                            <strong>القسم:</strong> <span id="summaryDepartment">{{ $table->summaryDepartment }}</span>
                            <input type="hidden" id="hiddenSummaryDepartment" name="hiddenSummaryDepartment">
                        </div>
                        <div class="summary-item">
                            <strong>الطبيب:</strong> <span id="summaryDoctor">{{ $table->summaryDoctor }}</span>
                            <input type="hidden" id="hiddenSummaryDoctor" name="hiddenSummaryDoctor">
                        </div>
                        <div class="summary-item">
                            <strong>الوقت:</strong> <span id="summaryTime">{{ $table->summaryTime }}</span>
                            <input type="hidden" id="hiddenSummaryTime" name="hiddenSummaryTime">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="summary-item">
                            <strong>اسم المريض:</strong> <span>
                                {{ $table->firstName . ' ' . $table->middleName . ' ' . $table->lastName }} </span>
                            <input type="hidden" id="hiddenSummaryDate" name="hiddenSummaryDate">
                        </div>
                        <div class="summary-item">
                            <strong>نوع البطاقة:</strong> <span> {{ $table->idType }} </span>
                            <input type="hidden" id="hiddenSummaryDay" name="hiddenSummaryDay">
                        </div>
                        <div class="summary-item">
                            <strong>رقم البطاقة:</strong> <span id="summaryDepartment">{{ $table->idNumber }}</span>
                            <input type="hidden" id="hiddenSummaryDepartment" name="hiddenSummaryDepartment">
                        </div>
                        <div class="summary-item">
                            <strong>تاريخ انشاء الحجز:</strong> <span
                                id="summaryDoctor">{{ $table->created_at }}</span>
                            <input type="hidden" id="hiddenSummaryDoctor" name="hiddenSummaryDoctor">
                        </div>
                        <div class="summary-item">
                            <strong>رقم الهاتف:</strong> <span id="summaryTime">{{ $table->phoneNumber }}</span>
                            <input type="hidden" id="hiddenSummaryTime" name="hiddenSummaryTime">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-custom w-100"> العودة الى الصفحة السابقة </a>
        </div>
    </div>
</body>

</html>
