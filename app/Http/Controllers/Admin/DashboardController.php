<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\District;
use App\Models\Province;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $provinceId = $request->province_id ?? '';
        $districtId = $request->district_id ?? '';

        $provinces = Province::all()->keyBy('id')->toArray();
        $districts = District::all()->keyBy('id')->toArray();
        $customers = Customers::whereIn('user_type_id', [4])
            ->whereNotNull('province_id')
            ->when($provinceId, function ($q) use ($provinceId) {
                $q->where('province_id', $provinceId);
            })
            ->when($districtId, function ($q) use ($districtId) {
                $q->where('district_id', $districtId);
            })
            ->paginate(10);

        return view('dashboard.index', compact('provinces', 'districts', 'customers'));
    }

    public function sendMessage(Request $request)
    {
        $userId = Auth::guard('admin')->user()->id;
        $provinceId = $request->province_id;
        $districtId = $request->district_id;
        $message = $request->message;

        $userMessage = UserMessage::create([
            'user_id' => $userId,
            'province_id' => $provinceId,
            'district_id' => $districtId,
            'message' => $message,
        ]);

        return redirect()->back()->with('success', 'Lưu thành công');
    }
}
