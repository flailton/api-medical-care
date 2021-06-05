<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IUserService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * User Controller.
 */
class UserController extends Controller
{
    private IUserService $userService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IUserService $userService InterfaceUserService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index()
    {
        try {
            $response['body'] = $this->userService->all();
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

            $response['body'] = $this->userService->store($request->all());
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
            $response['body'] = $this->userService->show($id);
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
            $rules = [];
            if ($request->method() === 'PATCH') {
                foreach ($this->rules($id) as $input => $regra) {
                    if (array_key_exists($input, $request->all())) {
                        $rules[$input] = $regra;
                    }
                }
            } else {
                $rules = $this->rules();
            }
    
            $request->validate($rules, $this->messages());

            $response['body'] = $this->userService->update($request->all(), $id);
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
            $response['body'] = $this->userService->destroy($id);
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
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|min:4|max:32'
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório!',
            'name.min' => 'O nome deve ter, pelo menos, 2 caracteres!',
            'name.max' => 'O nome deve ter, no máximo, 80 caracteres!',

            'email.required' => 'O campo e-mail é obrigatório!',
            'email.email' => 'O campo e-mail está fora do formato esperado!',
            'email.unique' => 'O e-mail informado já está cadastrado!',

            'password.required' => 'O campo senha é obrigatório!',
            'password.min' => 'A senha deve ter, pelo menos, 4 caracteres!',
            'password.max' => 'A senha deve ter, no máximo, 32 caracteres!'
        ];
    }
}
