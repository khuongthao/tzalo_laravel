<?php
$arrayLink = [
    [
        "url" => "/admin",
        "title" => "Trang chủ"
    ],
    [
        "url" => route("admin.manager.list"),
        "title" => "Danh sách admin"
    ]
]
?>

@extends('layouts.app')

@section('title', 'Danh sách báo cáo')

@push('css')
    <style>
        .swal2-title {
            font-size: 18px !important;
        }

        .swal2-html-container {
            font-size: 14px !important;
        }
    </style>
@endpush

@section("breadcrumbs")
    @include("layouts.breadcrumbs", ["links" => $arrayLink])
@endsection

@section('main')
    <div class="card mb-2">
        <div class="card-body" style="padding: 30px 50px">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                            Email
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                            style="width: 150px">
                            Type
                        </th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                            style="width: 150px">
                            created at
                        </th>
                        <th class="text-secondary opacity-7" style="width: 150px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td class="align-middle text-sm">
                                <span class="text-secondary text-xs font-weight-bold">
                                    {{$admin["email"]}}
                                </span>
                            </td>
                            <td class="text-center align-middle text-sm">
                                <span class="text-secondary text-xs font-weight-bold">
                                    {{$admin["type"] === 1 ? "Super Admin" : "Admin"}}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">
                                    {{ $admin["created_at"] }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <a href="{{route("admin.manager.edit", ["id" => $admin["id"]])}}">
                                    <button class="btn btn-primary mb-0 btn-xs text-xs me-2">
                                        <i class="fa fa-pencil-square-o"></i>
                                    </button>
                                </a>
                                <button onclick="deleteAdmin({{$admin["id"]}})" class="btn btn-danger mb-0 btn-xs text-xs me-2">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <hr style="background: #c9c9c9"/>
        </div>
    </div>
    <form action="{{route("admin.manager.delete")}}" id="form-delete-admin" method="POST">
        @csrf
        <input name="id" type="hidden" id="input_admin_delete"/>
    </form>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset("js/plugins/sweetalert.min.js")}}" ></script>
    <script>
        const deleteAdmin = (id) => {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-xs btn-danger me-2',
                    cancelButton: 'btn btn-xs btn-primary me-2'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Xoá dữ liệu?',
                text: "Dữ liệu sẽ bị xoá và không thể khôi phục",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xác nhận xoá',
                cancelButtonText: 'Quay lại',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const input = document.getElementById("input_admin_delete");
                    const form = document.getElementById("form-delete-admin");
                    input.value = id;
                    form.submit();
                }
            })
        }
    </script>
@endpush
