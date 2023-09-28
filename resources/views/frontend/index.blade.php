<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ __('Medical clinic reservation system') }}</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link to Datepicker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/style.css') }}">

    @if (session()->has('lang') == 'en')
        <style>
            *,
            .vertical-tabs .nav-link {
                direction: ltr !important;
                text-align: left !important;
            }
        </style>
    @endif
</head>

<body>
    <div class="container  mb-4">
        <img class="mb-4" src="{{ asset('2.png') }}" width="20%" style="display: block; margin: 0 auto;"
            alt="">
        <form action="{{ route('data') }}" method="post">

            <div class="search-box">
                @if (session('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @csrf
                <input type="text" class="form-control"
                    placeholder="{{ __('Enter your civil number to view all the reservations you have made') }} ..."
                    name="idNumber" required>
                <button class="btn btn-primary" type="submit">{{ __('search') }}</button>
            </div>
        </form>

        <div class="card">
            <div class="card-header">
                <h2 class="text-center">{{ __('Military Hospital appointments') }} </h2>
            </div>
            <div class="card-body">
                <div class="search-box">
                    <input type="text" class="form-control" id="searchInput" placeholder="{{ __('Find a section') }}"
                        oninput="searchDepartments()">
                    <button class="btn btn-primary" onclick="searchDepartments()">{{ __('search') }}</button>
                </div>
                <div class="vertical-tabs">
                    <ul class="nav flex-column" id="clinicTabs" role="tablist">
                        @foreach ($Category as $cat)
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="surgery-tab{{ $cat->id }}" data-bs-toggle="tab"
                                    href="#surgery{{ $cat->id }}" role="tab"
                                    aria-controls="surgery{{ $cat->id }}" aria-selected="true">
                                    {{ $cat->name }}
                                </a>
                            </li>
                            <!-- إضافة العنصر المخفي لتخزين القيمة المخصصة لفاصل الزمني -->
                            {{-- <input type="hidden" id="timeInterval{{ $cat->id }}" value="{{ $cat->timeInterval }}"> --}}
                        @endforeach

                    </ul>
                </div>

                <div class="tab-content mt-3" id="clinicTabsContent">
                    @foreach ($Category as $cat)
                        <div class="tab-pane fade" id="surgery{{ $cat->id }}" role="tabpanel"
                            aria-labelledby="surgery-tab{{ $cat->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="doctors-section">
                                        <h4 class="text-center mb-4">اختر طبيبًا</h4>
                                        <div class="search-box">
                                            <input type="text" class="form-control" id="searchDoctorsInput"
                                                placeholder="{{ __('Find a doctor') }}" oninput="searchDoctors()">
                                            <button class="btn btn-primary"
                                                onclick="searchDoctors()">{{ __('search') }}</button>
                                        </div>
                                        <ul class="doctors-list">
                                            @foreach ($doctors as $doc)
                                                @if ($doc->category_id == $cat->id)
                                                    <li>
                                                        <a href="#" onclick="selectDoctor('{{ $doc->name }}')"
                                                            class="doctor-option">
                                                            <span class="doctor-name">{{ $doc->name }}</span>
                                                            <span class="doctor-icon">&#10003;</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="date-time-section">
                                        <div class="form-group">
                                            <label for="datepicker" class="mb-2">
                                                {{ __('Choose the date') }}:</label>
                                            <input type="text" class="form-control"
                                                id="datepicker{{ $cat->id }}"
                                                placeholder="{{ __('Choose the date') }}">
                                        </div>
                                        <div class="pt-4">
                                            <p> {{ __('The session time will be') }} : {{ $cat->time }}
                                                {{ __('') }}</p>
                                        </div>
                                        <div class="time-slots mt-4" id="timeSlots{{ $cat->id }}">
                                            <!-- سيتم إنشاء الأوقات هنا باستخدام السكريبت -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <form action="">
                    <div class="patient-info-section mt-4">
                        <h4 class="text-center mb-4">{{ __('Patient data') }}</h4>
                        <div class="form-group mb-3">
                            <label for="firstName">{{ __('First Name') }}:</label>
                            <input type="text" class="form-control" id="firstName"
                                placeholder="{{ __('Please enter first name') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="middleName">{{ __('the second name') }}:</label>
                            <input type="text" class="form-control" id="middleName"
                                placeholder="{{ __('Please enter') }} {{ __('the second name') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="lastName">{{ __('family name') }}:</label>
                            <input type="text" class="form-control" id="lastName"
                                placeholder="{{ __('Please enter') }} {{ __('family name') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="phoneNumber">{{ __('phone number') }}:</label>
                            <input type="tel" pattern="[0-9]{8}" max="8" min="8" maxlength="8"
                                class="form-control" id="phoneNumber"
                                placeholder="{{ __('Please enter') }} {{ __('phone number') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="idNumber"> {{ __('File number/military ID number') }} :</label>
                            <input type="text" class="form-control" id="idNumber"
                                placeholder="{{ __('Please enter') }} {{ __('File number/military ID number') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="idType">{{ __('Card type') }}:</label>
                            <select class="form-control" id="idType">
                                <option value="هوية عسكرية"> {{ __('Military ID') }}</option>
                                <option value="بطاقة العائلة">{{ __('Family Card') }}</option>
                                <option value="موظف مدني">{{ __('Civil servant') }} </option>
                            </select>
                        </div>


                        <div class="form-group mb-3" id="dream" style="display: none;">
                            <label for="idNumber"> تاريخ انتهاء البطاقة </label>
                            <div class="expiry-date">
                                <label for="day" class="p-2">{{ __('day') }}: </label>
                                <input class="form-control" type="number" id="day" name="day"
                                    min="1" max="31">
                                <label for="month" class="p-2">{{ __('Month') }}: </label>
                                <input class="form-control" type="number" id="month" name="month"
                                    min="1" max="12">
                                <label for="year" class="p-2">{{ __('year') }}: </label>
                                <input class="form-control" type="number" id="year" name="year"
                                    min="2023" max="2099">
                            </div>
                        </div>

                    </div>
                    <!-- جزء ملخص الحجز -->
                    <div class="summary-section mt-4">
                        <h4 class="text-center mb-4">{{ __('Booking summary') }}</h4>
                        <div class="summary-item">
                            <strong>{{ __('date') }}:</strong> <span id="summaryDate">---</span>
                            <input type="hidden" id="hiddenSummaryDate" name="hiddenSummaryDate">
                        </div>
                        <div class="summary-item">
                            <strong>{{ __('today') }}:</strong> <span id="summaryDay">---</span>
                            <input type="hidden" id="hiddenSummaryDay" name="hiddenSummaryDay">
                        </div>
                        <div class="summary-item">
                            <strong>{{ __('Section') }}:</strong> <span id="summaryDepartment">---</span>
                            <input type="hidden" id="hiddenSummaryDepartment" name="hiddenSummaryDepartment">
                        </div>
                        <div class="summary-item">
                            <strong>{{ _('doctor') }}:</strong> <span id="summaryDoctor">---</span>
                            <input type="hidden" id="hiddenSummaryDoctor" name="hiddenSummaryDoctor">
                        </div>
                        <div class="summary-item">
                            <strong>{{ _('time') }}:</strong> <span id="summaryTime">---</span>
                            <input type="hidden" id="hiddenSummaryTime" name="hiddenSummaryTime">
                        </div>
                    </div>

                </form>
            </div>

            <!-- زر تأكيد الحجز -->
            <div class="text-center mt-4">
                <button class="btn btn-custom w-100" onclick="confirmReservation()">
                    {{ __('reservation confirmation') }}
                </button>
            </div>

        </div>
        <br>
        <h5 class="text-center m-4 pb-4">
            {{ __('Contact Captain / Mishaal Al-Hindi') }}
            <a href="https://wa.me/+96551197963" target="_target" class="btn btn-custom"> 51197963 </a>
        </h5>
    </div>

    <!-- Link to Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Link to Datepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>

    <script>
        var idType = document.getElementById("idType");
        var dreamDiv = document.getElementById("dream");

        idType.addEventListener("input", function() {
            if (idType.value === "بطاقة العائلة") {
                dreamDiv.style.display = "block"; // عرض العناصر عند اختيار "بطاقة العائلة"
            } else {
                dreamDiv.style.display = "none"; // إخفاء العناصر عند اختيار أي قيمة أخرى
            }
        });
    </script>

    <script>
        var selectedDoctor = null;
        var selectedDate = null;
        var selectedTimeSlot = null;

        function selectDoctor(doctorName) {
            var doctorsList = document.querySelectorAll(".doctors-list li");
            doctorsList.forEach(function(doctor) {
                doctor.classList.remove("selected-doctor");
            });

            selectedDoctor = doctorName;
            var selectedDoctorElement = document.querySelector(".doctors-list li a[onclick=\"selectDoctor('" + doctorName +
                "')\"]");
            if (selectedDoctorElement) {
                selectedDoctorElement.parentElement.classList.add("selected-doctor");
            }

            selectedDate = null;
            selectedTimeSlot = null;

            // إفراغ قيمة مربع اختيار التاريخ

            @foreach ($Category as $Categys)
                document.getElementById("datepicker{{ $Categys->id }}").value = "";
            @endforeach

            // إزالة التأشير عن الوقت المحدد
            document.querySelectorAll(".time-slot").forEach(function(slot) {
                slot.classList.remove("selected-time-slot");
            });

            updateSummary();
        }

        function searchDepartments() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var clinicTabs = document.querySelectorAll(".nav-link");
            clinicTabs.forEach(function(tab) {
                var tabName = tab.textContent.toLowerCase();
                if (tabName.includes(input)) {
                    tab.style.display = "block";
                } else {
                    tab.style.display = "none";
                }
            });
        }

        function searchDoctors() {
            var input = document.getElementById("searchDoctorsInput").value.toLowerCase();
            var doctorsList = document.querySelectorAll(".doctors-list li");
            doctorsList.forEach(function(doctor) {
                var doctorName = doctor.textContent.toLowerCase();
                if (doctorName.includes(input)) {
                    doctor.style.display = "block";
                } else {
                    doctor.style.display = "none";
                }
            });
        }
    </script>


    <script>
        function selectTimeSlot(timeSlot) {
            var allTimeSlots = document.querySelectorAll(".time-slot");
            allTimeSlots.forEach(function(slot) {
                slot.classList.remove("selected-time-slot");
            });

            timeSlot.classList.add("selected-time-slot");

            selectedTimeSlot = timeSlot.textContent;
            updateSummary();
        }
    </script>



    @if (session()->has('lang') == 'en')
        <script>
            function updateSummary() {
                var summaryDateElement = document.getElementById("summaryDate");
                var summaryDayElement = document.getElementById("summaryDay");
                var summaryDepartmentElement = document.getElementById("summaryDepartment");
                var summaryDoctorElement = document.getElementById("summaryDoctor");
                var summaryTimeElement = document.getElementById("summaryTime");

                var hiddenSummaryDateElement = document.getElementById("hiddenSummaryDate");
                var hiddenSummaryDayElement = document.getElementById("hiddenSummaryDay");
                var hiddenSummaryDepartmentElement = document.getElementById("hiddenSummaryDepartment");
                var hiddenSummaryDoctorElement = document.getElementById("hiddenSummaryDoctor");
                var hiddenSummaryTimeElement = document.getElementById("hiddenSummaryTime");

                if (selectedDoctor && selectedDate && selectedTimeSlot) {
                    var selectedDay = new Date(selectedDate).toLocaleDateString('en-EG', {
                        weekday: 'long'
                    });



                    summaryDateElement.textContent = selectedDate;
                    summaryDayElement.textContent = selectedDay;

                    // Get the selected department based on the active tab
                    var activeTab = document.querySelector(".nav-link.active");
                    var selectedDepartment = activeTab.textContent;

                    // Update the summary with the selected department and doctor
                    summaryDepartmentElement.textContent = selectedDepartment;
                    summaryDoctorElement.textContent = selectedDoctor;
                    summaryTimeElement.textContent = selectedTimeSlot;

                    // Set the hidden input values
                    hiddenSummaryDateElement.value = selectedDate;
                    hiddenSummaryDayElement.value = selectedDay;
                    hiddenSummaryDepartmentElement.value = selectedDepartment;
                    hiddenSummaryDoctorElement.value = selectedDoctor;
                    hiddenSummaryTimeElement.value = selectedTimeSlot;
                } else {
                    summaryDateElement.textContent = "---";
                    summaryDayElement.textContent = "---";
                    summaryDepartmentElement.textContent = "---";
                    summaryDoctorElement.textContent = "---";
                    summaryTimeElement.textContent = "---";

                    // Clear the hidden input values
                    hiddenSummaryDateElement.value = "";
                    hiddenSummaryDayElement.value = "";
                    hiddenSummaryDepartmentElement.value = "";
                    hiddenSummaryDoctorElement.value = "";
                    hiddenSummaryTimeElement.value = "";
                }
            }
        </script>
    @else
        <script>
            function updateSummary() {
                var summaryDateElement = document.getElementById("summaryDate");
                var summaryDayElement = document.getElementById("summaryDay");
                var summaryDepartmentElement = document.getElementById("summaryDepartment");
                var summaryDoctorElement = document.getElementById("summaryDoctor");
                var summaryTimeElement = document.getElementById("summaryTime");

                var hiddenSummaryDateElement = document.getElementById("hiddenSummaryDate");
                var hiddenSummaryDayElement = document.getElementById("hiddenSummaryDay");
                var hiddenSummaryDepartmentElement = document.getElementById("hiddenSummaryDepartment");
                var hiddenSummaryDoctorElement = document.getElementById("hiddenSummaryDoctor");
                var hiddenSummaryTimeElement = document.getElementById("hiddenSummaryTime");

                if (selectedDoctor && selectedDate && selectedTimeSlot) {
                    var selectedDay = new Date(selectedDate).toLocaleDateString('ar-EG', {
                        weekday: 'long'
                    });



                    summaryDateElement.textContent = selectedDate;
                    summaryDayElement.textContent = selectedDay;

                    // Get the selected department based on the active tab
                    var activeTab = document.querySelector(".nav-link.active");
                    var selectedDepartment = activeTab.textContent;

                    // Update the summary with the selected department and doctor
                    summaryDepartmentElement.textContent = selectedDepartment;
                    summaryDoctorElement.textContent = selectedDoctor;
                    summaryTimeElement.textContent = selectedTimeSlot;

                    // Set the hidden input values
                    hiddenSummaryDateElement.value = selectedDate;
                    hiddenSummaryDayElement.value = selectedDay;
                    hiddenSummaryDepartmentElement.value = selectedDepartment;
                    hiddenSummaryDoctorElement.value = selectedDoctor;
                    hiddenSummaryTimeElement.value = selectedTimeSlot;
                } else {
                    summaryDateElement.textContent = "---";
                    summaryDayElement.textContent = "---";
                    summaryDepartmentElement.textContent = "---";
                    summaryDoctorElement.textContent = "---";
                    summaryTimeElement.textContent = "---";

                    // Clear the hidden input values
                    hiddenSummaryDateElement.value = "";
                    hiddenSummaryDayElement.value = "";
                    hiddenSummaryDepartmentElement.value = "";
                    hiddenSummaryDoctorElement.value = "";
                    hiddenSummaryTimeElement.value = "";
                }
            }
        </script>
    @endif
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <!-- تضمين مكتبة Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        function confirmReservation() {
            var hiddenSummaryDateElement = document.getElementById("hiddenSummaryDate");
            var hiddenSummaryDayElement = document.getElementById("hiddenSummaryDay");
            var hiddenSummaryDepartmentElement = document.getElementById("hiddenSummaryDepartment");
            var hiddenSummaryDoctorElement = document.getElementById("hiddenSummaryDoctor");
            var hiddenSummaryTimeElement = document.getElementById("hiddenSummaryTime");

            var firstNameElement = document.getElementById("firstName");
            var middleNameElement = document.getElementById("middleName");
            var lastNameElement = document.getElementById("lastName");
            var idNumberElement = document.getElementById("idNumber");
            var idTypeElement = document.getElementById("idType");
            var phoneNumber = document.getElementById("phoneNumber");
            var idImageElement = document.getElementById("idImage");

            var formData = new FormData();
            formData.append('summaryDate', hiddenSummaryDateElement.value);
            formData.append('summaryDay', hiddenSummaryDayElement.value);
            formData.append('summaryDepartment', hiddenSummaryDepartmentElement.value);
            formData.append('summaryDoctor', hiddenSummaryDoctorElement.value);
            formData.append('summaryTime', hiddenSummaryTimeElement.value);
            formData.append('firstName', firstNameElement.value);
            formData.append('middleName', middleNameElement.value);
            formData.append('lastName', lastNameElement.value);
            formData.append('idNumber', idNumberElement.value);
            formData.append('idType', idTypeElement.value);
            formData.append('phoneNumber', phoneNumber.value);
            formData.append('day', day.value);
            formData.append('month', month.value);
            formData.append('year', year.value);

            axios.post('/', formData)
                .then(function(response) {
                    const idNumberValue = formData.get('idNumber');
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح!',
                        text: 'تم تأكيد الحجز بنجاح وتم تخزين البيانات في قاعدة البيانات.',
                        confirmButtonColor: '#54350a',
                        confirmButtonText: 'حسنًا'
                    }).then((result) => {
                        // استخراج قيمة idNumber من البيانات المُستجاب عليها
                        if (result.isConfirmed) {
                            window.location.href = '/info/' + idNumberValue;
                        };
                    })

                })

                .catch(function(error) {

                    // التعامل مع الأخطاء هنا
                    if (error.response) {
                        // إذا كان هناك استجابة من الخادم وتم تضمين استجابة الخطأ
                        console.log(error.response.data); // تفاصيل الخطأ
                        console.log(error.response.status); // رمز استجابة الخطأ

                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: JSON.stringify(error.response.data),
                            footer: 'حدث خطأ أثناء تأكيد الحجز. الرجاء المحاولة مرة أخرى.', // استخدام رسالة الخطأ المسترجعة من الباك إند
                            confirmButtonColor: '#54350a',
                            confirmButtonText: 'حسنًا'
                        });

                    } else {
                        // إذا لم يكن هناك استجابة من الخادم (مشكلة في الاتصال)
                        console.log(error.message); // تفاصيل الخطأ
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء التواصل مع الخادم. الرجاء المحاولة مرة أخرى.',
                            confirmButtonColor: '#54350a',
                            confirmButtonText: 'حسنًا'
                        });
                    }
                });
        }
    </script>

    @foreach ($Category as $Categy)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                flatpickr("#datepicker{{ $Categy->id }}", {
                    dateFormat: "Y-m-d",
                    disable: [
                        function(date) {
                            @if ($Categy->Close_date != null)
                                return date < new Date("{{ $Categy->Close_date }}");
                            @else
                                return date < new Date().fp_incr(0);
                            @endif
                        }
                    ],
                    onChange: function(selectedDates, dateStr, instance) {
                        selectedDate = dateStr;
                        updateSummary();
                    }
                });
            });
            // تحديد الوقت البداية والوقت النهاية
            var startTime = 8; // 8:00 AM
            var endTime = 11; // 1:00 PM
            var timeInterval = {{ $Categy->time }}; // استخدام قيمة الفاصل الزمني من القسم

            var timeSlots{{ $Categy->id }}Container = document.getElementById("timeSlots{{ $Categy->id }}");

            // إنشاء الساعات ديناميكيًا
            for (var hour = startTime; hour <= endTime; hour++) {
                for (var minute = 0; minute < 60; minute += timeInterval) {
                    var timeSlot = document.createElement("div");
                    var formattedHour = (hour < 10 ? "0" : "") + hour;
                    var formattedMinute = (minute < 10 ? "0" : "") + minute;
                    var timeText = formattedHour + ":" + formattedMinute + " " + (hour < 12 ? "AM" : "PM");
                    timeSlot.className = "time-slot";
                    timeSlot.textContent = timeText;

                    // إضافة الوقت كقيمة في العنصر الفرعي
                    timeSlot.setAttribute("data-time", formattedHour + ":" + formattedMinute);
                    timeSlot.setAttribute("onclick", "selectTimeSlot(this)"); // إضافة السلوك onclick

                    // إضافة الفاصل الزمني بين الاختيارات
                    timeSlots{{ $Categy->id }}Container.appendChild(timeSlot);
                }
            }
            // إضافة تكرار أخير بقيمة timeInterval إلى الوقت الأخير
            var lastTimeSlot = timeSlots{{ $Categy->id }}Container.lastChild;
            var lastTime = lastTimeSlot.getAttribute("data-time").split(":");
            var newHour = parseInt(lastTime[0]);
            var newMinute = parseInt(lastTime[1]) + timeInterval;
            if (newMinute >= 60) {
                newHour += 1;
                newMinute -= 60;
            }
            // var amPm = (hour < 12 ? "AM" : "PM"); // تحديد AM أو PM بناءً على قيمة الساعة

            // var formattedNewHour = (newHour < 10 ? "0" : "") + newHour;
            // var formattedNewMinute = (newMinute < 10 ? "0" : "") + newMinute;
            // var newTimeText = formattedNewHour + ":" + formattedNewMinute + " " + amPm;
            // var newTimeSlot = document.createElement("div");
            // newTimeSlot.className = "time-slot";
            // newTimeSlot.textContent = newTimeText;
            // newTimeSlot.setAttribute("data-time", formattedNewHour + ":" + formattedNewMinute);
            // newTimeSlot.setAttribute("onclick", "selectTimeSlot(this)");
            // timeSlots{{ $Categy->id }}Container.appendChild(newTimeSlot);
            // console.log(newTimeSlot)
        </script>
    @endforeach


</body>

</html>
