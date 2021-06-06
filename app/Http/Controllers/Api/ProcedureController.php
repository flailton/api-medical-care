<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IProcedureService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProcedureController extends Controller
{
    private IProcedureService $procedureService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IProcedureService $procedureService InterfaceProcedureService
     */
    public function __construct(IProcedureService $procedureService)
    {
        $this->procedureService = $procedureService;
    }
    
    public function index()
    {
        try {
            $response['body'] = $this->procedureService->all();
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

            $response['body'] = $this->procedureService->store($request->all());
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
            $response['body'] = $this->procedureService->show($id);
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

            $response['body'] = $this->procedureService->update($request->all(), $id);
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
            $response['body'] = $this->procedureService->destroy($id);
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
            'name' => 'required|min:2|max:80',
            'value' => 'required|numeric|min:0',
            'percent' => 'required|numeric|between:0,1'
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 80 caracteres!',

            'value.required' => 'O campo valor é obrigatório!',
            'value.numeric' => 'O campo valor é inválido!',
            'value.min' => 'O campo valor não pode ser menor do que R$ 0,00!',

            'percent.required' => 'O campo comissão percentual é obrigatório!',
            'percent.numeric' => 'O campo comissão percentual é inválido!',
            'percent.between' => 'O campo comissão percentual deve ser entre 0% e 100%!',
        ];
    }
}
