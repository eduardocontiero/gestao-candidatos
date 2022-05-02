<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserQualification;
use Exception;

class HomeController extends Controller
{
    private $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $users = $this->model->paginate(20);
        return view('home', compact('users'));
    }


    public function create()
    {
        return view('create');
    }

    public function edit($id)
    {
        $user = $this->model->with('professional_qualifications', 'academic_qualifications')->find($id);

        $academic = $user->academic_qualifications;
        $professional = $user->professional_qualifications;

        return view('edit', compact('user', 'academic', 'professional'));
    }

    public function save(UserRequest $request)
    {
        $data = $request->all();
        try {
            if (isset($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            }
            if (isset($data['id'])) {
                $user = $this->model->find($data['id']);

                $user->update($data);
            } else {
                $user = $this->model->create($data);
            }


            return response()->json(['success' => true, 'user' => $user]);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'error' => 'Erro ao salvar usuário',
            ], 500);
        }
    }

    public function saveQualifications(Request $request, $id)
    {
        $data = $request->all();

        try {
            $user = $this->model->find($id);

            if ($user) {


                if ($data['professional_qualifications'] != null) {
                    foreach ($data['professional_qualifications'] as $value) {
                        $user->professional_qualifications()->updateOrCreate([
                            'description' => $value['description'],
                            'type' => $value['type']
                        ]);
                    }
                }
                if ($data['academic_qualifications'] != null) {
                    foreach ($data['academic_qualifications'] as $value) {

                        $user->academic_qualifications()->updateOrCreate([
                            'description' => $value['description'],
                            'type' => $value['type']
                        ]);
                    }
                }
            }

            return response()->json(['success' => true]);
        } catch (Exception $e) {

            return response()->json([
                'success' => false,
                'error' => 'Erro ao salvar qualificação',
            ], 500);
        }
    }

    public function delete($id)
    {
        $this->model->find($id)->delete();

        return redirect()->back();
    }
}
