<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VehicleService
{
    private EntityManagerInterface $entityManager;

    private VehicleRepository $vehicleRepository;

    public function __construct(EntityManagerInterface $entityManager, VehicleRepository $vehicleRepository)
    {
        $this->entityManager = $entityManager;
        $this->vehicleRepository = $vehicleRepository;
    }


    /**
     * @param mixed[] $params
     *
     * @return mixed[]
     */
    public function getVehiclesList(array $params): array
    {
        $qb = $this->vehicleRepository->getList($params);
        $paginator = new Paginator($qb, false);

        return [
            'count' => count($paginator),
            'list' => $qb->getQuery()->getArrayResult(),
        ];
    }

    /**
     *
     * @return Vehicle
     */
    public function getVehicleById(int $id)
    {
        $vehicle = $this->vehicleRepository->find($id);
        if (!$vehicle) {
            throw new NotFoundHttpException('No vehicle found for id ' . $id);
        }

        return $vehicle;
    }

    /**
     *
     * @return Vehicle
     */
    public function saveVehicle(string $type, float $msrp, int $year, string $make, string $model, int $miles, string $vin)
    {
        $newVehicle = new Vehicle();

        $newVehicle
            ->setDateAdded(new \DateTime())
            ->setType($type)
            ->setMsrp($msrp)
            ->setYear($year)
            ->setMake($make)
            ->setModel($model)
            ->setMiles($miles)
            ->setVin($vin)
            ->setDeleted(false);

        $this->vehicleRepository->add($newVehicle);
        return $newVehicle;
    }

    /**
     *
     * @return Vehicle
     */
    public function updateVehicle(int $id, string $type, float $msrp, int $year, string $make, string $model, int $miles, string $vin)
    {
        $vehicle = $this->vehicleRepository->find($id);
        if (!$vehicle) {
            throw new NotFoundHttpException('No vehicle found for id ' . $id);
        }

        $vehicle
            ->setType($type)
            ->setMsrp($msrp)
            ->setYear($year)
            ->setMake($make)
            ->setModel($model)
            ->setMiles($miles)
            ->setVin($vin);

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return $vehicle;
    }
}
