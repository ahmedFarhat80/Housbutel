@extends('layout.layout')


@section('content')
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
@endsection
