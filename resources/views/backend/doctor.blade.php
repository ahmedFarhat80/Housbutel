@extends('layout.layout')


@section('content')
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">جدول الاطباء</span>

                <span class="text-muted mt-1 fw-semibold fs-7">
                    هنا يتم عرض الاطباء
                </span>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="ki-duotone ki-plus fs-2"></i> اضافة طبيب
                </button>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">اضافة طبيب جديد</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="myForm" onSubmit="return false;">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        اسم الطبيب بالعربية
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder=" قم بادخال اسم الطبيب بالعربية">
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        اسم الطبيب بالانجليزية
                                    </label>
                                    <input type="text" class="form-control" id="name_en" name="name_en"
                                        placeholder="قم بادخال اسم الطبيب بالانجليزية ">
                                </div>

                                <div class="fv-row mb-8">
                                    <!--begin::Label-->
                                    <label class="required fs-6 fw-semibold mb-2">
                                        اختر القسم الذي يتبع له الطبيب
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select class="form-select form-select-solid" data-control="select2" id="select"
                                        data-hide-search="true" data-placeholder="Select..." name="settings_customer">

                                        @foreach ($Category as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-8">
                                    <label class="required fs-6 fw-semibold mb-2">
                                        حدد الايام التي سيداوم بها الطبيب
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="السبت"
                                            id="flexCheckDefault1">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault1">
                                            السبت
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="الأحد"
                                            id="flexCheckDefault2">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault2">
                                            الأحد
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="الاثنين"
                                            id="flexCheckDefault3">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault3">
                                            الاثنين
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="الثلاثاء"
                                            id="flexCheckDefault4">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault4">
                                            الثلاثاء
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="الأربعاء"
                                            id="flexCheckDefault5">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault5">
                                            الأربعاء
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="الخميس"
                                            id="flexCheckDefault6">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault6">
                                            الخميس
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input mt-2 mb-2" type="checkbox" value="الجمعة"
                                            id="flexCheckDefault7">

                                        <label class="form-check-label mt-2 mb-2" for="flexCheckDefault7">
                                            الجمعه
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">اغلاق</button>
                                <button type="button" onclick="store()" class="btn btn-primary">حفظ التغيرات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Header-->

        <!--begin::Body-->
        <div class="card-body py-3">
            <div class="mb-3">
                <input type="text" id="searchInput" onkeyup="searchTable()" class="form-control"
                    placeholder="ابحث عن طبيب...">
            </div>
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="dataTable" class="table align-middle gs-0 gy-4">
                    <!--begin::Table head-->
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-60px rounded-start">#</th>
                            <th class="min-w-60px">الاسم العربي </th>
                            <th class="min-w-60px">الاسم الانجليزي </th>
                            <th class="min-w-60px">القسم التابع</th>
                            <th class="min-w-60px"> اجراءات اخرى</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($doctore as $d)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                                {{ $d->id }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $d->name }}
                                    </a>
                                </td>

                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $d->name_en }}
                                    </a>
                                </td>

                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $d->category->name }}
                                    </a>
                                </td>
                                <td class="text-end">

                                    <button type="button"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $d->id }}">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <a href="#" onclick="confirmDestroy({{ $d->id }},this)"
                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                        <i class="ki-duotone ki-trash fs-2"><span class="path1">
                                            </span><span class="path2">
                                            </span><span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $d->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel{{ $d->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $d->id }}">
                                                تعديل قسم
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="myForm" onSubmit="return false;">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name{{ $d->id }}" class="form-label">
                                                        اسم الطبيب بالعربية
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        id="name{{ $d->id }}" name="name{{ $d->id }}"
                                                        placeholder="قم بادخال اسم الطبيب باللغه العربية "
                                                        value="{{ $d->name }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="name_en{{ $d->id }}" class="form-label">
                                                        اسم الطبيب بالانجليزية
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        id="name_en{{ $d->id }}"
                                                        name="name_en{{ $d->id }}"
                                                        placeholder="قم بادخال اسم الطبيب باللغه الانجليزية "
                                                        value="{{ $d->name_en }}">
                                                </div>

                                                <div class="fv-row mb-8">
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold mb-2">
                                                        اختر القسم الذي يتبع له الطبيب
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select class="form-select form-select-solid"
                                                        data-control="select{{ $d->id }}"
                                                        id="select{{ $d->id }}" data-hide-search="true"
                                                        data-placeholder="Select..." name="settings_customer">
                                                        @foreach ($Category as $Categorys)
                                                            @if ($d->category_id == $Categorys->id)
                                                                <option value="{{ $Categorys->id }}">
                                                                    {{ $Categorys->name }}
                                                                </option>
                                                            @break
                                                        @endif
                                                    @endforeach

                                                    @foreach ($Category as $Categorys)
                                                        @if ($d->category_id != $Categorys->id)
                                                            <option value="{{ $Categorys->id }}">
                                                                {{ $Categorys->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <div class="fv-row mb-8">
                                                <label class="required fs-6 fw-semibold mb-2">
                                                    حدد الايام التي سيداوم بها الطبيب
                                                </label>
                                                @php
                                                    $days = \App\Models\Day::where('doctor_id', $d->id)->first(); // استعلم عن أيام الدوام باستخدام Eloquent
                                                @endphp
                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="السبت" id="flexCheckDefault8{{ $d->id }}"
                                                        @if ($days->day1 == 'السبت') checked @endif>

                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault8{{ $d->id }}">
                                                        السبت </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="الأحد" id="flexCheckDefault9{{ $d->id }}"
                                                        @if ($days->day2 == 'الأحد') checked @endif>


                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault9{{ $d->id }}">
                                                        الأحد
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="الاثنين"
                                                        id="flexCheckDefault10{{ $d->id }}"@if ($days->day3 == 'الاثنين') checked @endif>

                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault10{{ $d->id }}">
                                                        الاثنين
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="الثلاثاء" id="flexCheckDefault11{{ $d->id }}"
                                                        @if ($days->day4 == 'الثلاثاء') checked @endif>

                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault11{{ $d->id }}">
                                                        الثلاثاء
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="الأربعاء" id="flexCheckDefault12{{ $d->id }}"
                                                        @if ($days->day5 == 'الأربعاء') checked @endif>

                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault12{{ $d->id }}">
                                                        الأربعاء
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="الخميس"
                                                        id="flexCheckDefault13{{ $d->id }}"@if ($days->day6 == 'الخميس') checked @endif>

                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault13{{ $d->id }}">
                                                        الخميس
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input mt-2 mb-2" type="checkbox"
                                                        value="الجمعة"
                                                        id="flexCheckDefault14{{ $d->id }}"@if ($days->day7 == 'الجمعة') checked @endif>

                                                    <label class="form-check-label mt-2 mb-2"
                                                        for="flexCheckDefault14{{ $d->id }}">
                                                        الجمعه
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">اغلاق</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="update{{ $d->id }}({{ $d->id }})">حفظ
                                                التغيرات
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
    function store() {
        let formData = new FormData();
        formData.append('name', document.getElementById('name').value);
        formData.append('name_en', document.getElementById('name_en').value);
        formData.append('select', document.getElementById('select').value);

        if (document.getElementById('flexCheckDefault1').checked) {
            formData.append('flexCheckDefault1', document.getElementById('flexCheckDefault1').value);
        }
        if (document.getElementById('flexCheckDefault2').checked) {
            formData.append('flexCheckDefault2', document.getElementById('flexCheckDefault2').value);
        }
        if (document.getElementById('flexCheckDefault3').checked) {
            formData.append('flexCheckDefault3', document.getElementById('flexCheckDefault3').value);
        }
        if (document.getElementById('flexCheckDefault4').checked) {
            formData.append('flexCheckDefault4', document.getElementById('flexCheckDefault4').value);
        }
        if (document.getElementById('flexCheckDefault5').checked) {
            formData.append('flexCheckDefault5', document.getElementById('flexCheckDefault5').value);
        }
        if (document.getElementById('flexCheckDefault6').checked) {
            formData.append('flexCheckDefault6', document.getElementById('flexCheckDefault6').value);
        }
        if (document.getElementById('flexCheckDefault7').checked) {
            formData.append('flexCheckDefault7', document.getElementById('flexCheckDefault7').value);
        }
        axios.post('/doctor', formData)
            .then(function(response) {
                // handle success
                console.log(response);
                toastr.success(response.data.message);
                document.getElementById('myForm').reset();
                setTimeout(function() {
                    window.location.href = "/doctor";
                }, 1000);
            })
            .catch(function(error) {
                // handle error
                console.log(error);
                toastr.error(error.response.data.message);
            })
            .then(function() {
                // always executed
            });
    }
</script>

@foreach ($doctore as $cat)
    <script>
        function update{{ $cat->id }}(id) {
            var data = {
                name: document.getElementById("name{{ $cat->id }}").value,
                name_en: document.getElementById("name_en{{ $cat->id }}").value,
                select: document.getElementById("select{{ $cat->id }}").value,
            };

            // إضافة القيم الخاصة بالـ checkboxes
            for (var i = 8; i <= 15; i++) {
                var checkboxElement = document.getElementById('flexCheckDefault' + i + {{ $cat->id }});
                if (checkboxElement && checkboxElement.checked) {
                    data['flexCheckDefault' + i] = checkboxElement.value;
                }
            }

            axios.put('/doctor/' + id, data)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    // document.getElementById('myForm').reset();
                    window.location.href = "/doctor";
                })
                .catch(function(error) {
                    // handle error
                    console.log(error);
                    toastr.error(error.response.data.message);
                })
                .then(function() {
                    // always executed
                });
        }
    </script>
@endforeach


<script>
    function confirmDestroy(id, reference) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                destroy(id, reference);
            }
        });
    }

    function destroy(id, reference) {
        axios.delete('/doctor/' + id)
            .then(function(response) {
                // handle success 2xx
                console.log(response);
                reference.closest('tr').remove();
                showMessage(response.data);
            })
            .catch(function(error) {
                // handle error 4xx
                console.log(error);
                showMessage(error.response.data)
            })
            .then(function() {
                // always executed
            });
    }

    function showMessage(data) {
        Swal.fire({
            icon: data.icon,
            title: data.title,
            text: data.text,
            showConfirmButton: false,
            timer: 1500
        })
    }
</script>

<script>
    // دالة للبحث داخل الجدول بناءً على الاسم بالعربي والإنجليزي
    function searchTable() {
        var input, filter, table, tr, td, i, txtValueArabic, txtValueEnglish;
        input = document.getElementById("searchInput"); // استدعاء عنصر الإدخال
        filter = input.value.toUpperCase(); // تحويل النص إلى أحرف كبيرة للمقارنة
        table = document.getElementById("dataTable"); // استدعاء الجدول
        tr = table.getElementsByTagName("tr"); // الحصول على صفوف الجدول

        // البحث في كل صف وإخفاء أولئك الذين لا تتطابق مع معايير البحث
        for (i = 1; i < tr.length; i++) { // ابتداءً من 1 لتجنب عنوان الجدول
            td = tr[i].getElementsByTagName("td"); // الحصول على جميع الأعمدة في الصف

            // البحث في العمود الثاني (الاسم بالعربي) والعمود الثالث (الاسم بالإنجليزي)
            txtValueArabic = td[1].textContent || td[1].innerText;
            txtValueEnglish = td[2].textContent || td[2].innerText;

            if (txtValueArabic.toUpperCase().indexOf(filter) > -1 || txtValueEnglish.toUpperCase().indexOf(filter) > -
                1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
</script>
@endsection
