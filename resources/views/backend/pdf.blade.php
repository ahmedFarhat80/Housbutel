<!DOCTYPE html>
<html class="no-js" lang="ar" dir="rtl">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="author" content="ThemeMarch">
    <!-- Site Title -->
    <title>فاتورة طبية</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('pdf/css/style.css') }}">

</head>

<body>
    <div class="cs-container">
        <div class="cs-invoice cs-style1">
            <div class="cs-invoice_in" id="download_section">
                <div class="cs-invoice_head cs-type1 cs-mb25">
                    <div class="cs-invoice_left">
                        <p class="cs-invoice_number cs-primary_color cs-f16"><b class="cs-primary_color">رقم
                                الحجز:
                            </b>
                            {{ $reservations->id }}
                        </p>
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                        <div class="cs-logo cs-mb5">
                            <img src="{{ asset('2.png') }}" alt="الشعار" width="110px">
                        </div>

                    </div>
                    <p class="mt-5">هيئة الخدمات الطبية</p>

                </div>
                <div class="cs-invoice_head cs-mb10">
                    <div class="cs-invoice_left">
                        <b class="cs-primary_color">يجب قراءة:</b>
                        <p class="cs-mb8">
                            يرجى الوصول قبل الموعد في ربع ساعه من الموعد المحدد
                        </p>
                        <p><b class="cs-primary_color cs-semi_bold">تاريخ طلب الخدمه :</b> <br>
                            {{ $reservations->created_at }}
                        </p>
                    </div>
                    <div class="cs-invoice_right cs-text_right">
                        <b class="cs-primary_color">من خلال نظام الحجوزات</b>
                        <p>
                            المستشقى العسكري الكويتي
                        </p>
                    </div>
                </div>
                <div class="cs-heading cs-style1 cs-f18 cs-primary_color cs-mb25 cs-semi_bold">معلومات الحجز الخاصة
                    بالمريض </div>
                <ul class="cs-grid_row cs-col_3 cs-mb5">
                    <li>
                        <p class="cs-mb20"><b class="cs-primary_color">اسم المريض:</b> <br><span
                                class="cs-primary_color">
                                {{ $reservations->firstName . ' ' . $reservations->middleName . ' ' . $reservations->lastName }}
                            </span>
                        </p>
                        <p class="cs-mb20"><b class="cs-primary_color"> رقم هاتف المريض :</b> <br><span
                                class="cs-primary_color">
                                {{ $reservations->phoneNumber }}
                            </span></p>
                        <p class="cs-mb20"><b class="cs-primary_color">نوع البطاقة :</b> <br><span
                                class="cs-primary_color">
                                {{ $reservations->idType }}

                            </span></p>
                    </li>
                    <li>
                        <p class="cs-mb20"><b class="cs-primary_color"> رقم الملف / رقم الهوية العسكريه :</b> <br><span
                                class="cs-primary_color">{{ $reservations->idNumber }}</span></p>
                        <p class="cs-mb20"><b class="cs-primary_color">القسم التابع:</b> <br><span
                                class="cs-primary_color">{{ $reservations->summaryDepartment }}</span></p>
                        <p class="cs-mb20"><b class="cs-primary_color">تاريخ الحجز:</b> <br><span
                                class="cs-primary_color">
                                {{ $reservations->summaryDate }}
                            </span>
                        </p>
                    </li>
                    <li>
                        <p class="cs-mb20"><b class="cs-primary_color">الطبيب المختص:</b> <br><span
                                class="cs-primary_color">4
                                {{ $reservations->summaryDoctor }}
                            </span>
                        </p>

                        <p class="cs-mb20"><b class="cs-primary_color">مده الجلسة:</b> <br><span
                                class="cs-primary_color">
                                {{ $Category->time ?? '' }} دقيقة
                            </span>
                        </p>

                        <p class="cs-mb20"><b class="cs-primary_color">الساعه:</b> <br><span class="cs-primary_color">
                                {{ $reservations->summaryTime }}
                            </span>
                        </p>


                        <p class="cs-mb20"><b class="cs-primary_color">تاريخ انتهاء البطاقة :</b> <br><span
                                class="cs-primary_color">
                                {{ $reservations->day }} - {{ $reservations->date }} -
                                {{ $reservations->year }}
                            </span>
                        </p>
                    </li>

                </ul>


                <div class="cs-invoice_btns cs-hide_print">
                    <a href="javascript:window.print()" class="cs-invoice_btn cs-color1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <rect x="128" y="240" width="256" height="208" rx="24.32"
                                ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round"
                                stroke-width="32" />
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <circle cx="392" cy="184" r="24" />
                        </svg>
                        <span>طباعة</span>
                    </a>
                    <button id="download_btn" class="cs-invoice_btn cs-color2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <title>تحميل</title>
                            <path
                                d="M336 176h40a40 40 0 0140 40v208a40 40 0 01-40 40H136a40 40 0 01-40-40V216a40 40 0 0140-40h40"
                                fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="32" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="32" d="M176 272l80 80 80-80M256 48v288" />
                        </svg>
                        <span>تحميل</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('pdf/js/jquery.min.js') }}"></script>
    <script src="{{ asset('pdf/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('pdf/js/html2canvas.min.js') }}"></script>
    <script src="{{ asset('pdf/js/main.js') }}"></script>

</body>

</html>
