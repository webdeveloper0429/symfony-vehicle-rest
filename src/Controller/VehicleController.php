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

        return new JsonResponse(['success' => true, 'data' => $vehicle->toArray()]);
    }

    /**
     * @Route("/vehicle", name="save_vehicle", methods={"POST"})
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
}
