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
    <style>
        @media print {
            #downloadPdfBtn,
            /* تحديد زر تنزيل ملخص الحجز */
            .btn-custom

            /* تحديد زر العودة إلى الصفحة السابقة */
                {
                display: none !important;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

</head>

<body>
    <div class="container  mb-4">
        <h2 class="text-center mb-4"> ملخص الحجز الخاص بك </h2>
        <div class="tab-content mt-3" id="clinicTabsContent">
            <div class="summary-section mt-4 row">
                <h4 class="text-center mb-4"> معرف الحجز : {{ $data->id }}</h4>
                <div class="col-6">
                    <div class="summary-item">
                        <strong>التاريخ:</strong> <span id="summaryDate"> {{ $data->summaryDate }} </span>
                        <input type="hidden" id="hiddenSummaryDate" name="hiddenSummaryDate">
                    </div>
                    <div class="summary-item">
                        <strong>اليوم:</strong> <span id="summaryDay"> {{ $data->summaryDay }} </span>
                        <input type="hidden" id="hiddenSummaryDay" name="hiddenSummaryDay">
                    </div>
                    <div class="summary-item">
                        <strong>القسم:</strong> <span id="summaryDepartment">{{ $data->summaryDepartment }}</span>
                        <input type="hidden" id="hiddenSummaryDepartment" name="hiddenSummaryDepartment">
                    </div>
                    <div class="summary-item">
                        <strong>الطبيب:</strong> <span id="summaryDoctor">{{ $data->summaryDoctor }}</span>
                        <input type="hidden" id="hiddenSummaryDoctor" name="hiddenSummaryDoctor">
                    </div>
                    <div class="summary-item">
                        <strong>الوقت:</strong> <span id="summaryTime">{{ $data->summaryTime }}</span>
                        <input type="hidden" id="hiddenSummaryTime" name="hiddenSummaryTime">
                    </div>
                </div>

                <div class="col-6">
                    <div class="summary-item">
                        <strong>اسم المريض:</strong> <span>
                            {{ $data->firstName . ' ' . $data->middleName . ' ' . $data->lastName }} </span>
                        <input type="hidden" id="hiddenSummaryDate" name="hiddenSummaryDate">
                    </div>
                    <div class="summary-item">
                        <strong>نوع البطاقة:</strong> <span> {{ $data->idType }} </span>
                        <input type="hidden" id="hiddenSummaryDay" name="hiddenSummaryDay">
                    </div>
                    <div class="summary-item">
                        <strong>رقم البطاقة:</strong> <span id="summaryDepartment">{{ $data->idNumber }}</span>
                        <input type="hidden" id="hiddenSummaryDepartment" name="hiddenSummaryDepartment">
                    </div>
                    <div class="summary-item">
                        <strong>تاريخ انشاء الحجز:</strong> <span id="summaryDoctor">{{ $data->created_at }}</span>
                        <input type="hidden" id="hiddenSummaryDoctor" name="hiddenSummaryDoctor">
                    </div>
                    <div class="summary-item">
                        <strong>رقم الهاتف:</strong> <span id="summaryTime">{{ $data->phoneNumber }}</span>
                        <input type="hidden" id="hiddenSummaryTime" name="hiddenSummaryTime">
                    </div>
                </div>
            </div>

        </div>
        <div class="text-center mt-4">
            <button id="downloadPdfBtn" class="btn btn-primary mb-2  w-100">تنزيل ملخص الحجز كملف PDF</button>
            <a href="{{ url('/') }}" class="btn btn-custom w-100"> العودة الى الصفحة السابقة </a>
        </div>
    </div>

    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            // احصل على العناصر التي تريد تحويلها إلى PDF (في هذه الحالة، الجزء الذي تريد تحويله هو العنصر الذي يحتوي على ملخص الحجز).
            const summarySection = document.querySelector('.summary-section');
            // استدعاء window.print() لبدء عملية الطباعة
            window.print();

            // استخدم مكتبة html2canvas لالتقاط صورة للعنصر.
            html2canvas(summarySection).then(canvas => {
                // إنشاء ملف PDF باستخدام مكتبة jsPDF.
                const pdf = new jsPDF('p', 'mm', 'a4');
                pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 210,
                    297); // أضف الصورة إلى الملف PDF.

                // قم بتنزيل الملف PDF.
                pdf.save('ملخص_الحجز.pdf');
            });
        });
    </script>

</body>

</html>
