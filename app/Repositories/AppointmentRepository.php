<?php

namespace App\Repositories;

use App\Models\Appointment;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function all()
    {
        return Appointment::all();
    }

    public function find($id)
    {
        return Appointment::find($id);
    }

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(array $data, $id)
    {
        $appointment = Appointment::find($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete($id)
    {
        return Appointment::destroy($id);
    }
}