<style>
    .nav-link i {
        font-weight: bold;
        padding-left: 5px;
    }
</style>

<div class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
     id="sidenav-main">
    <div class="sidenav-header" style="border-bottom: 1px solid rgb(201, 201, 201);">
        <a class="navbar-brand m-0"
            href=""
            target="_blank">
            <img style="border-radius: 50%" src="https://t3.ftcdn.net/jpg/00/64/67/52/240_F_64675209_7ve2XQANuzuHjMZXP3aIYIpsDKEbF5dD.jpg" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">{{ 'Tzalo' }}</span>
        </a>
    </div>
    <div class="horizontal dark mt-0">
        <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                        QUẢN LÝ
                    </h6>
                </li>

            </ul>
        </div>
        <div class="sidenav-footer mx-3">
            <a class="btn btn-dark btn-sm mb-0 w-100" href="{{route("logout")}}">ĐĂNG XUÂT</a>
        </div>
    </div>
</div>
