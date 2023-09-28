@extends('layout.layout')


@section('content')
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bold fs-3 mb-1">جدول الاقسام</span>

                <span class="text-muted mt-1 fw-semibold fs-7">
                    هنا يتم عرض الاقسام
                </span>
            </h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="ki-duotone ki-plus fs-2"></i> اضافة قسم
                </button>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">اضافة قسم جديد</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="myForm" onSubmit="return false;">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        الاسم
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="قم بادخال اسم القسم ">
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        مدة جلسة الطبيب في هذا القسم
                                    </label>
                                    <input type="number" class="form-control" id="time" name="time"
                                        placeholder="قم بادخال مدة جلسة الطبيب في هذا القسم ">
                                </div>


                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        تاريخ بداية الحجز
                                    </label>
                                    <input type="date" class="form-control" id="date" name="date">
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
                    placeholder="ابحث عن قسم...">
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
                            <th class="min-w-60px">مده الجلسة</th>
                            <th class="min-w-60px"> تبداء الحجوزات بتاريخ</th>
                            <th class="min-w-60px"> اجراءات اخرى</th>
                        </tr>
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody>
                        @foreach ($categories as $c)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex justify-content-start flex-column">
                                            <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">
                                                {{ $c->id }}
                                            </a>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $c->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $c->time }}
                                    </a>
                                </td>

                                <td>
                                    <a href="#" class="text-dark fw-bold text-hover-primary d-block mb-1 fs-6">
                                        {{ $c->Close_date ?? ' ليس هناك قيود' }}
                                    </a>
                                </td>
                                <td class="text-end">

                                    <button type="button" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal{{ $c->id }}">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <a href="#" onclick="confirmDestroy({{ $c->id }},this)"
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

                            <div class="modal fade" id="exampleModal{{ $c->id }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel{{ $c->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel{{ $c->id }}">
                                                تعديل قسم
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="myForm" onSubmit="return false;">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name{{ $c->id }}" class="form-label">
                                                        الاسم
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        id="name{{ $c->id }}" name="name{{ $c->id }}"
                                                        placeholder="قم بادخال اسم القسم " value="{{ $c->name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="time{{ $c->id }}" class="form-label">
                                                        مدة جلسة الطبيب في هذا القسم
                                                    </label>
                                                    <input type="number" class="form-control"
                                                        id="time{{ $c->id }}" name="time{{ $c->id }}"
                                                        placeholder="قم بادخال مدة جلسة الطبيب في هذا القسم "
                                                        value="{{ $c->time }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date{{ $c->id }}" class="form-label">
                                                        تاريخ بداية الحجز
                                                    </label>
                                                    <input type="date" class="form-control"
                                                        id="date{{ $c->id }}" name="date{{ $c->id }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">اغلاق</button>
                                                <button type="button" class="btn btn-primary"
                                                    onclick="update{{ $c->id }}({{ $c->id }})">حفظ
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
            formData.append('time', document.getElementById('time').value);
            formData.append('date', document.getElementById('date').value);

            axios.post('/category', formData)
                .then(function(response) {
                    // handle success
                    console.log(response);
                    toastr.success(response.data.message);
                    document.getElementById('myForm').reset();
                    setTimeout(function() {
                        window.location.href = "/category";
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

    @foreach ($categories as $cat)
        <script>
            function update{{ $cat->id }}(id) {
                axios.put('/category/' + id, {
                        name: document.getElementById("name{{ $cat->id }}").value,
                        time: document.getElementById("time{{ $cat->id }}").value,
                        date: document.getElementById("date{{ $cat->id }}").value,
                    })
                    .then(function(response) {
                        // handle success
                        console.log(response);
                        toastr.success(response.data.message);
                        // document.getElementById('myForm').reset();
                        window.location.href = "/category";
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
            axios.delete('/category/' + id)
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
