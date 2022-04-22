<?php

namespace App\Controller;

use App\Services\VehicleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Route("/vehicles/{id}", name="get_vehicle", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getVehicleById(int $id)
    {
        $vehicle = $this->vehicleService->getVehicleById($id);

        return new JsonResponse(['success' => true, 'data' => $vehicle->toArray()]);
    }

    /**
     * @Route("/vehicles", name="save_vehicle", methods={"POST"})
     */
    public function saveVehicle(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $type = $data['type'];
        $msrp = $data['msrp'];
        $year = $data['year'];
        $make = $data['make'];
        $model = $data['model'];
        $miles = $data['miles'];
        $vin = $data['vin'];

        if (empty($make) || empty($model) || empty($year)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $vehicle = $this->vehicleService->saveVehicle($type, $msrp, $year, $make, $model, $miles, $vin);

        return new JsonResponse(['success' => true, 'data' => $vehicle->toArray()]);
    }

    /**
     * @Route("/vehicles/{id}", name="update_vehicle", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateVehicle(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $type = $data['type'];
        $msrp = $data['msrp'];
        $year = $data['year'];
        $make = $data['make'];
        $model = $data['model'];
        $miles = $data['miles'];
        $vin = $data['vin'];

        if (empty($make) || empty($model) || empty($year)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $updatedVehicle = $this->vehicleService->updateVehicle($id, $type, $msrp, $year, $make, $model, $miles, $vin);

        return new JsonResponse(['success' => true, 'data' => $updatedVehicle->toArray()]);
    }

    /**
     * @Route("/vehicles/{id}", name="delete_vehicle", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(int $id): JsonResponse
    {
        $this->vehicleService->deleteVehicle($id);

        return new JsonResponse(['success' => true, 'data' => 'Vehicle Deleted!']);
    }
}
