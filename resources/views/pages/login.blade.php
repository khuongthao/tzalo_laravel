<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="{{asset("css/nucleo-icons.css")}}" rel="stylesheet"/>
    <link href="{{asset("css/nucleo-svg.css") }}" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{asset("css/argon-dashboard.css?v=2.0.4")}}" rel="stylesheet"/>
</head>

<body class="">
<main class="main-content  mt-0">

    <section>
        <div class="position-absolute top-0 start-0 m-4">
            <a href="/">
                <img src="https://tdoctor.net/images/shop/logo_topbar4.webp" alt="Logo" style="height: 50px;">
            </a>
        </div>
        <div class="page-header min-vh-100">
            <div class="">
                <div class="text-center">
                    <h3 class="font-weight-bold">Phần mềm gửi tin nhắn bán hàng</h3>
                    <p class="text-muted">
                        Gửi tin nhắn tới 50.000 nhà thuốc và phòng khám theo khu vực tỉnh thành, quận huyện, giúp các nhãn hàng tăng trưởng doanh thu vượt bậc.
                    </p>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <!-- CỘT LOGO + HÌNH ẢNH MINH HỌA -->
                    <div class="col-lg-6 d-none d-lg-flex flex-column align-items-center justify-content-center">
{{--                        <img src="https://tdoctor.net/images/shop/logo_topbar4.webp" alt="Logo" style="width: 150px; margin-bottom: 20px;">--}}
                        <img src="https://tdoctor.net/images/shop/29_4.png" alt="Illustration" class="img-fluid rounded" style="max-width: 80%;">
                    </div>

                    <!-- CỘT ĐĂNG NHẬP -->
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="card-header pb-0 text-center">
                                <h4 class="font-weight-bolder">ĐĂNG NHẬP</h4>
                            </div>
                            <div class="card-body">
                                @if (isset($errors) && count($errors->all()) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <p class="text-white mb-0"><small>Đăng nhập không thành công</small></p>
                                    </div>
                                @endif
                                <form role="form" method="post" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <input
                                            type="email"
                                            name="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="Email"
                                            aria-label="Email">
                                        @error('email')
                                        <span class="invalid-feedback text-left" role="alert">
                                        <small>{{ Str::ucfirst($message) }}</small>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            placeholder="Password"
                                            aria-label="Password">
                                        @error('password')
                                        <span class="invalid-feedback text-left" role="alert">
                                        <small>{{ Str::ucfirst($message) }}</small>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end login form -->
                </div>
            </div>
        </div>
    </section>

</main>

<script src="{{asset("js/core/popper.min.js")}}"></script>
<script src="{{asset("js/core/bootstrap.min.js")}}"></script>
<script src="{{asset("js/plugins/perfect-scrollbar.min.js")}}"></script>
<script src="{{asset("js/plugins/smooth-scrollbar.min.js")}}"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="{{asset("js/argon-dashboard.min.js?v=2.0.4")}}"></script>
</body>

</html>
