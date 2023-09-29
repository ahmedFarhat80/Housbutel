@extends('layout.layout')


@section('content')
    <div class="card mb-6">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap">

                <!-- مربع اختيار القسم -->
                <div class="mb-3 me-3 w-50">
                    <label for="sectionFilter" class="form-label">اختر القسم:</label>
                    <select class="form-select form-select-lg" id="sectionFilter">
                        <option value="all">الكل</option>
                        @foreach ($Category as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- مربع اختيار الحالة -->
                <div class="mb-3 me-3 w-50">
                    <label for="statusFilter" class="form-label">اختر الحالة:</label>
                    <select class="form-select form-select-lg" id="statusFilter">
                        <option value="all">الكل</option>
                        <option value="تم الدخول">تم الدخول </option>
                        <option value="جديد">جديد </option>
                    </select>
                </div>
                <!-- مربع اختيار تاريخ من -->
                <div class="mb-3 me-3 w-50">
                    <label for="startDateFilter" class="form-label">من تاريخ:</label>
                    <input type="date" class="form-control" id="startDateFilter">
                </div>

                <!-- مربع اختيار تاريخ إلى -->
                <div class="mb-3 me-3 w-50">
                    <label for="endDateFilter" class="form-label">إلى تاريخ:</label>
                    <input type="date" class="form-control" id="endDateFilter">
                </div>

                <!-- زر الفلترة -->
                <div class="mb-3 w-50">
                    <label for="statusFilter" class="form-label" style="visibility: hidden">s</label>
                    <button type="button" class="btn btn-primary btn-lg w-100" onclick="applyFilters()">
                        تنفيذ الفلترة
                    </button>
                </div>

            </div>
            <!--end::Details-->
        </div>
    </div>




    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">جدول الحجوزات</span>

                <span class="text-muted mt-1 fw-semibold fs-7">
                    هنا يتم عرض الحجوزات
                </span>
            </h3>

        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="mb-3">
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control"
                    placeholder="ابحث عن حجز باسم المريض...">
            </div>
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="dataTable" class="table align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-60px rounded-start">#</th>
                            <th class="min-w-60px">الاسم</th>
                            <th class="min-w-60px">تابع للقسم</th>
                            <th class="min-w-60px">تاريخ الحجز</th>
                            <th class="min-w-60px">ساعه الحجز</th>
                            <th class="min-w-60px">حالة ال PDF</th>
                            <th class="min-w-60px"> اجراءات اخرى</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($tables as $table)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                                {{ $table->id }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $table->firstName . ' ' . $table->middleName . ' ' . $table->lastName }}
                                    </a>
                                </td>


                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $table->summaryDepartment }}
                                    </a>
                                </td>


                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $table->summaryDate }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $table->summaryTime }}
                                    </a>
                                </td>

                                <td>
                                    @if ($table->readable == 0)
                                        <span class="badge text-bg-warning"> جديد </span>
                                    @else
                                        <span class="badge text-bg-info">تم الدخول </span>
                                    @endif


                                </td>

                                <td class="text-end">

                                    <a href="{{ url('/show', $table->id) }}" class="btn btn-info">
                                        عرض ال PDF
                                    </a>
                                </td>
                            </tr>

                    </tbody>

            </div>
            @endforeach


            </tbody>
            <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Table container-->
    </div>
    <!--begin::Body-->
    </div>
@endsection


@section('js')
    <script>
        // دالة للبحث داخل الجدول
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput"); // استدعاء عنصر الإدخال
            filter = input.value.toUpperCase(); // تحويل النص إلى أحرف كبيرة للمقارنة
            table = document.getElementById("dataTable"); // استدعاء الجدول
            tr = table.getElementsByTagName("tr"); // الحصول على صفوف الجدول

            // البحث في كل صف وإخفاء أولئك الذين لا تتطابق مع معايير البحث
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // العمود الذي تريد البحث فيه (اسم)
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <script>
        function applyFilters() {
            var sectionFilter = document.getElementById("sectionFilter").value;
            var statusFilter = document.getElementById("statusFilter").value;
            var startDateFilter = document.getElementById("startDateFilter").value;
            var endDateFilter = document.getElementById("endDateFilter").value;

            var table = document.getElementById("dataTable");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) { // بدء الحلقة من 1 لتجاوز الصف الرأسي
                var row = rows[i];
                var sectionCell = row.cells[2]; // الخلية التي تحتوي على اسم القسم
                var statusCell = row.cells[5]; // الخلية التي تحتوي على حالة الـ PDF
                var dateCell = row.cells[3]; // الخلية التي تحتوي على تاريخ الحجز

                var sectionValue = sectionCell.textContent.trim();
                var statusValue = statusCell.textContent.trim();
                var dateValue = dateCell.textContent.trim();

                // فحص مطابقة قيم القسم وحالة الـ PDF وتاريخ الحجز مع المرشحات المختارة
                var sectionMatch = (sectionFilter === "all" || sectionFilter === sectionValue);
                var statusMatch = (statusFilter === "all" || statusFilter === statusValue);
                var dateMatch = (startDateFilter === "" || endDateFilter === "" || (startDateFilter <= dateValue &&
                    dateValue <= endDateFilter));

                // إظهار أو إخفاء الصف بناءً على نتيجة المطابقة
                if (sectionMatch && statusMatch && dateMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }
    </script>
@endsection
