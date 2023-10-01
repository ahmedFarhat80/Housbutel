<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>فاتورة طبية</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        @charset "UTF-8";

        *,
        ::after,
        ::before {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%;
            font-family: 'Amiri', sans-serif;
        }

        body {
            margin: 0;
            font-family: 'Amiri', sans-serif;
            background-color: #f2f2f2;
            /* لون خلفية الصفحة */
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            /* لون خلفية الفاتورة */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            /* تأثير الظل */
            border: 2px solid #ccc;
            /* حدود الفاتورة */
            border-radius: 10px;
            /* تدوير حواف الفاتورة */
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 10px;
            text-align: right;
            border-bottom: 1px solid #ddd;
            /* خط الحدود بين الصفوف */
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            font-weight: normal;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 150px;
            /* حجم الشعار */
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>


<body>


    <div class="container">
        <table>
            <tr>
                <th>رقم الحجز</th>
                <td>{{ $reservations->id }}</td>
            </tr>
            <tr>
                <th>يجب قراءة:</th>
                <td>يرجى الوصول قبل الموعد في ربع ساعة من الموعد المحدد</td>
            </tr>
            <tr>
                <th>تاريخ طلب الخدمة</th>
                <td>{{ $reservations->created_at }}</td>
            </tr>
            <tr>
                <th>من خلال نظام الحجوزات</th>
                <td>المستشفى العسكري الكويتي</td>
            </tr>

            <tr>
                <th>اسم المريض</th>
                <td>{{ $reservations->firstName . ' ' . $reservations->middleName . ' ' . $reservations->lastName }}
                </td>
            </tr>
            <tr>
                <th>رقم هاتف المريض</th>
                <td>{{ $reservations->phoneNumber }}</td>
            </tr>
            <tr>
                <th>نوع البطاقة</th>
                <td>{{ $reservations->idType }}</td>
            </tr>
            <tr>
                <th>رقم الملف / رقم الهوية العسكرية</th>
                <td>{{ $reservations->idNumber }}</td>
            </tr>
            <tr>
                <th>القسم التابع</th>
                <td>{{ $reservations->summaryDepartment }}</td>
            </tr>
            <tr>
                <th>تاريخ الحجز</th>
                <td>{{ $reservations->summaryDate }}</td>
            </tr>
            <tr>
                <th>الطبيب المختص</th>
                <td>{{ $reservations->summaryDoctor }}</td>
            </tr>
            <tr>
                <th>مدة الجلسة</th>
                <td>{{ $Category->time ?? '' }} دقيقة</td>
            </tr>
            <tr>
                <th>الساعة</th>
                <td>{{ $reservations->summaryTime }}</td>
            </tr>
            <tr>
                <th>تاريخ انتهاء البطاقة</th>
                <td>{{ $reservations->day }} - {{ $reservations->date }} - {{ $reservations->year }}</td>
            </tr>
        </table>
        <div class="footer">
            المستشفى العسكري الكويتي &copy; {{ date('Y') }}
        </div>
    </div>
</body>

</html>
