<?php
namespace App\Services;

use App\Repositories\AppointmentRepositoryInterface;

class AppointmentService
{
    protected $appointmentRepository;

    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function getAllAppointments()
    {
        return $this->appointmentRepository->all();
    }

    public function getAppointmentById($id)
    {
        return $this->appointmentRepository->find($id);
    }

    public function createAppointment(array $data)
    {
        return $this->appointmentRepository->create($data);
    }
}