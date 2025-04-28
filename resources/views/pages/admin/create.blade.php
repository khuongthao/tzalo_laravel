<?php
$arrayLink = [
    [
        "url" => "/admin",
        "title" => "Trang chủ"
    ],
    [
        "url" => route("admin.data.email.list"),
        "title" => "Email"
    ],
]
?>

@extends('layouts.app')

@section('title', 'Danh sách email')

@push('css')

@endpush

@section("breadcrumbs")
    @include("layouts.breadcrumbs", ["links" => $arrayLink])
@endsection

@section('main')
    <div class="card mb-2" id="form-search-code">
        <div class="card-body" style="padding: 30px 50px">
            <form action="{{$router}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input
                                value="{{old("email") ? old("email") : ($admin["email"] ?? null)}}"
                                placeholder="example.com"
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                            />
                            @error('email')
                            <span class="invalid-feedback text-left" role="alert">
                                <small>{{$message}}</small>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                            />
                            @error('password')
                            <span class="invalid-feedback text-left" role="alert">
                                <small>{{$message}}</small>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nhắc lại mật khẩu</label>
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                            />
                        </div>
                    </div>

                    <div class="col-md-12 mb-2">
                        <label>Phân quyền</label>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        name="roles[]"
                                        type="checkbox"
                                        value="3"
                                        id="rule_marketing"
                                    >
                                    <label
                                        class="custom-control-label"
                                        for="rule_marketing">
                                        Maketing
                                    </label>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        name="roles[]"
                                        type="checkbox"
                                        value="4"
                                        id="rule_sale"
                                    >
                                    <label
                                        class="custom-control-label"
                                        for="rule_sale">
                                        Sale
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <button
                            type="submit"
                            class="btn btn-primary btn-xs mb-0 me-2">
                            {{$action === "create" ? "Thêm admin" : "Chỉnh sửa admin"}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')

@endpush
