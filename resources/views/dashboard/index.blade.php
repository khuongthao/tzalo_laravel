@extends('layouts.app')

@section('title', 'Dashboard')

@section('breadcrumb')
    <li class="active">Dashboard</li>
@endsection

@section('main')

    <!-- Small boxes (Stat box) -->
    <div class="card mb-2 row" id="form-search-code">
        <div class="card-body col-7" style="padding: 30px 50px">
            <form action="{{ route('dashboard.index') }}" method="GET" class="flex items-center gap-4 mb-4">
                <select name="province_id" class="border rounded px-4 py-2">
                    <option value="">-- Chọn Tỉnh/Thành --</option>
                    @foreach ($provinces as $province)
                        <option
                            value="{{ $province['id'] }}" {{ request('province_id') == $province['id'] ? 'selected' : '' }}>
                            {{ $province['name'] }}
                        </option>
                    @endforeach
                </select>

                <select name="district_id" class="border rounded px-4 py-2">
                    <option value="">-- Chọn Quận/Huyện --</option>
                    @foreach ($districts as $district)
                        <option
                            value="{{ $district['id'] }}" {{ request('district_id') == $district['id'] ? 'selected' : '' }}>
                            {{ $district['name'] }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary text-white px-4 py-2 rounded">Lọc kết quả</button>
            </form>

            <table class="w-full border mt-6">
                <thead>
                <tr class="bg-gray-200">
                    <th class="p-4 border">Hình ảnh nhà thuốc</th>
                    <th class="p-4 border">Thông tin nhà thuốc</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $pharmacy)
                    <tr>
                        <td class="p-4 border w-1/3">
                            <img src="{{ $pharmacy->avatar && $pharmacy->avatar != '' ? $pharmacy->avatar : 'https://tdoctor.net/laravel-filemanager/fileUpload/nhathuoc/nhathuocmau10.jpg' }}"
                                 alt="Ảnh nhà thuốc" class="w-full h-auto" style="width: 200px">
                        </td>
                        <td class="p-4 border align-top">
                            <h3 class="text-red-600 font-bold">{{ $pharmacy->fullname }}</h3>
                            <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: {{ @$provinces[$pharmacy->province_id]['name'] }}</p>
                            <p><i class="fas fa-phone"></i> Số điện thoại: {{ $pharmacy->phone }}</p>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div>
                {{ $customers->links('pages.pagination') }}
            </div>
        </div>

        <!-- Form gửi message -->
        <div class="chat-box col-3 text-center">
            <form action="{{ route('dashboard.sendMessage') }}" method="POST">
                @csrf
                <input type="hidden" name="province_id" id="province_id_hidden">
                <input type="hidden" name="district_id" id="district_id_hidden">
                <textarea placeholder="Nhập tin nhắn..." class="chat-input" name="message"></textarea>
                <br/>
                <button type="submit" class="chat-send-btn">Gửi</button>
            </form>
        </div>
    </div>

    <script>
        // Tự động lấy province_id và district_id khi gửi
        document.querySelector('.chat-send-btn').addEventListener('click', function() {
            document.getElementById('province_id_hidden').value = document.querySelector('select[name="province_id"]').value;
            document.getElementById('district_id_hidden').value = document.querySelector('select[name="district_id"]').value;
        });
    </script>


    <div class="clearfix"></div>

    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    .card {
        display: flex !important;
    }
    .chat-box {
        position: fixed; /* hoặc absolute nếu nằm trong container cha */
        top: 120px; /* tuỳ vị trí muốn đặt */
        right: 50px; /* điều chỉnh để nằm gọn trong khung đỏ */
        width: 300px;
        height: 500px;
        border: 1px solid #ccc;
        padding: 16px;
        background-color: #f9f9f9;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    .chat-input {
        resize: none;
        height: 350px;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
    }

    .chat-send-btn {
        margin-top: 10px;
        padding: 10px;
        background-color: #4f46e5;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .chat-send-btn:hover {
        background-color: #3730a3;
    }

</style>
@stop
