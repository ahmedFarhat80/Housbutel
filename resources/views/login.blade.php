<!DOCTYPE html>

<html direction="rtl" dir="rtl" style="direction: rtl"><!--begin::Head-->

<head>
    <title>Kuwait - المستشفى العسكري</title>
    <meta charset="utf-8" />
    <meta name="description" content="المستشفى العسكري الكويتي لحجز المواعيد الطبية" />

    <meta property="og:locale" content="ar_KU" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="المستشفى العسكري الكويتي لحجز المواعيد الطبية" />
    <meta property="og:site_name" content="المستشفى العسكري | Kuwait" />

    <link rel="shortcut icon" href="{{ asset('Backend/assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('Backend/assets/plugins/global/plugins.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('Backend/assets/css/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url("{{ asset('Backend/assets/media/auth/bg4.jpg') }}");
                font-family: "cairo";
            }

            [data-bs-theme="dark"] body {
                background-image: url("{{ asset('Backend/assets/media/auth/bg4-dark.jpg') }}");
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Aside-->
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <!--begin::Logo-->
                    <a href="" class="mb-7">
                        <img alt="Logo" src="{{ asset('Backend/assets/media/logos/custom-3.svg') }}" />
                    </a>
                    <!--end::Logo-->
                    <!--begin::Title-->
                    <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2>
                    <!--end::Title-->
                </div>
                <!--begin::Aside-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div
                class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <!--begin::Card-->
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form"
                            action="{{ route('login') }}" method="post">
                            <!--begin::Heading-->
                            @if (session('message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @csrf
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">تسجيل الدخول </h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-gray-500 fw-semibold fs-6">لوحة تحكم المسؤول </div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                            <div class="row g-3 mb-9">
                                <!--begin::Col-->
                                <div style="width: 380px"></div>
                                <!--end::Col-->
                            </div>
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email" name="email" autocomplete="off"
                                    class="form-control bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" name="password" autocomplete="off"
                                    class="form-control bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->

                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">تسجيل الدخول </span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">الرجاء الانتظار...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->

                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('Backend/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('Backend/assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ asset('Backend/assets/js/custom/authentication/sign-in/general.js') }}"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>
