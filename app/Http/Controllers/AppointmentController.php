<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateAppointmentRequest;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\AppointmentBooked;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index(){
        $appointments = $this->appointmentService->getAllAppointments();
        return response()->json($appointments);
    }

    public function show($id){
        $appointment = $this->appointmentService->getAppointmentById($id);
        return response()->json($appointment);
    }

    public function create(CreateAppointmentRequest $request){
        DB::beginTransaction();
        try{
            $appointment = $this->appointmentService->createAppointment($request->all());
            
            Log::info('Dispatching AppointmentBooked event', [
                'appointment_id' => $appointment->id
            ]);
            
            //event(new AppointmentBooked($appointment));
            AppointmentBooked::dispatch($appointment);

            Log::info('AppointmentBooked event dispatched', [
                'appointment_id' => $appointment->id
            ]);
            
            DB::commit();
            return response()->json($appointment);

        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error creating appointment', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
