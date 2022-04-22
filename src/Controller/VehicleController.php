<?php

namespace App\Controller;

use App\Services\VehicleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
{
    private VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * @Route("/vehicles", name="get_all_vehicles", methods={"GET"})
     */
    public function getAllVehicles(Request $request): JsonResponse
    {
        $params = $request->query->all();
        $data = $this->vehicleService->getVehiclesList($params);

        return new JsonResponse(['success' => true, 'data' => $data]);
    }

    /**
     * @return JsonResponse|void
     *
     * @Route("/vehicle/{id}", name="get_vehicle", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getVehicleById(int $id)
    {
        $vehicle = $this->vehicleService->getVehicleById($id);
        if (!$vehicle) {
            throw $this->createNotFoundException(
                'No vehicle found for id ' . $id
            );
        }

        return new JsonResponse(['success' => true, 'data' => $vehicle]);
    }
}
