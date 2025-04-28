<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Lấy list danh sách của user
     * @param Request $request
     */
    public function list(Request $request)
    {
        try {
            $key = $request->key ?? '';
            $id = $request->id ?? '';
            $questions = [];
            if ($key || $id) {
                $questions = AdminService::QuestionService()->searchQuestion($key, $id);
            }

            return view("pages.question.list", compact('questions'));
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Lấy thông tin cá nhân của user
     * @param [type] $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function detail($id)
    {
        $question = AdminService::QuestionService()->getQuestionById($id);

        return view("pages.question.detail", ["question" => $question]);
    }

    public function update(Request $request, $id)
    {
        try {
            $inputs = $request->all();

            AdminService::QuestionService()->updateQuestion($inputs, $id);

            return redirect()
                ->back()
                ->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('errors', $e->getMessage());
        }
    }
}
