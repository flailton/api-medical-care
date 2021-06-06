<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\IAppointmentService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    private IAppointmentService $appointmentService;

    /**
     * Display a listing of the resource.
     *
     * @param \App\Interfaces\IAppointmentService $appointmentService InterfaceAppointmentService
     */
    public function __construct(IAppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }
    
    public function index()
    {
        try {
            $response['body'] = $this->appointmentService->all();
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

            $response['body'] = $this->appointmentService->store($request->all());
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
            $response['body'] = $this->appointmentService->show($id);
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

            $response['body'] = $this->appointmentService->update($request->all(), $id);
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
            $response['body'] = $this->appointmentService->destroy($id);
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
            'user_id' => 'required|exists:users,id',
            'professional_id' => 'required|exists:professionals,id',
            'appointment_at' => 'required|after_or_equal:'.date("Y-m-d H:i:s"),
            'procedures' => 'required'
        ];
    }

    private function messages()
    {
        return [
            'user_id.required' => 'O campo paciente é obrigatório!',
            'user_id.exists' => 'O paciente informado é inválido!',

            'professional_id.required' => 'O campo profissional é obrigatório!',
            'professional_id.exists' => 'O profissional informado é inválido!',

            'appointment_at.required' => 'O campo data de agendamento é obrigatória!',
            'appointment_at.after_or_equal' => 'A data de agendamento não pode ser menor do que a data atual!',
            
            'procedures.required' => 'É necessário informar ao menos um procedimento!'
        ];
    }
}
