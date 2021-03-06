<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IProfessionalService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProfessionalController extends Controller
{
    private IProfessionalService $professionalService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IProfessionalService $professionalService InterfaceProcedureService
     */
    public function __construct(IProfessionalService $professionalService)
    {
        $this->professionalService = $professionalService;
    }
    
    public function index()
    {
        try {
            $response['body'] = $this->professionalService->all();
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }


        return response()->json($response['body'], $response['status']);
    }
    
    public function store(Request $request)
    {
        try {
            $request->validate($this->rules(), $this->messages());

            $response['body'] = $this->professionalService->store($request->all());
            $response['status'] = (!empty($response['status']) ? $response['status'] : 201);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            if($ex instanceof ValidationException){
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }
    
    public function show($id)
    {
        try {
            $response['body'] = $this->professionalService->show($id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }
    
    public function update(Request $request, $id)
    {
        try {
            $rules = $this->rules($id);
            if ($request->method() === 'PATCH') {
                $customRules = [];
                foreach ($rules as $input => $regra) {
                    if (array_key_exists($input, $request->all())) {
                        $customRules[$input] = $regra;
                    }
                }
                $rules = $customRules;
            }

            $request->validate($rules, $this->messages());

            $response['body'] = $this->professionalService->update($request->all(), $id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            if($ex instanceof ValidationException){
                $response['body']['errors'] = $ex->errors();
            }
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }
    
    public function destroy($id)
    {
        try {
            $response['body'] = $this->professionalService->destroy($id);
            $response['status'] = (!empty($response['status']) ? $response['status'] : 200);
        } catch (\Throwable $ex) {
            $response['body']['message'] = $ex->getMessage();
            $response['status'] = 404;
        }

        return response()->json($response['body'], $response['status']);
    }

    private function rules($id = '')
    {
        return [
            'name' => 'required|min:2|max:80|unique:professionals,name,' . $id,
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'O campo nome ?? obrigat??rio!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no m??ximo, 80 caracteres!',
            'name.unique' => 'J?? existe um profissional cadastrado com o nome informado!'
        ];
    }
}
