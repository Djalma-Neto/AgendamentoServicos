<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        return response()->json(Appointment::with('service')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'service_id' => 'required|exists:services,id',
            'date_time' => 'required|date'
        ]);

        $service = Service::find($request->service_id);
        $start = Carbon::parse($request->date_time);
        $end = $start->copy()->addMinutes($service->duration);

        // Regra: horário comercial
        if (!Appointment::isWithinBusinessHours($start, $end)) {
            return response()->json([
                'error' => 'Fora do horário comercial (08:00 às 18:00)'
            ], 400);
        }

        // Regra: conflito de horário
        if (Appointment::hasConflict($start, $end)) {
            return response()->json([
                'error' => 'Horário já ocupado'
            ], 400);
        }

        $appointment = Appointment::create($request->all());

        return response()->json($appointment, 201);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'error' => 'Agendamento não encontrado'
            ], 404);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Agendamento removido'
        ]);
    }
}
