<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
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
        $candidates = User::paginate(20);
        return view('home', compact('candidates'));
    }


    public function create()
    {
        return view('create');
    }

    public function edit($id)
    {
        $user = $this->model->find($id);
        return view('edit', compact('user'));
    }

    public function save(UserRequest $request)
    {
        $data = $request->all();
        try {
            $user = $this->model->create($data);

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

            if($data['professional_qualifications'] != null){
                foreach ($data['professional_qualifications'] as $value) {
                    $user->professional_qualitifications()->updateOrCreate([
                        'description' => $value['description'],
                        'type' => $value['type']
                    ]);
                }
            }
            if($data['academic_qualifications'] != null){
                foreach ($data['academic_qualifications'] as $value) {
                    $user->academic_qualitifications()->updateOrCreate([
                        'description' => $value['description'],
                        'type' => $value['type']
                    ]);
                }
            }

            $academic_qualifications = $user->with('professional_qualifications')->get();
            $professional_qualifications = $user->with('professional_qualifications')->get();
           
        }

            return response()->json(['success' => true, "academic_qualifications" => $academic_qualifications, "professional_qualifications" => $professional_qualifications]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao salvar usuário',
            ], 500);
        }

       
    }


    public function update(UserRequest $request, $id)
    {
        $data = $request->all();
        try {
            $user = $this->model->create($data);

            return response()->json(['success' => true, 'user' => $user]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao salvar usuário',
            ], 500);
        }
    }

    public function delete($id)
    {

        try {
            $this->model->find($id)->delete();


            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erro ao deletar usuário',
            ], 500);
        }
    }
}
