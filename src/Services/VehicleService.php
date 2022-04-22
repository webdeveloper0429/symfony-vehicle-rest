<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Vehicle;
use Doctrine\ORM\Tools\Pagination\Paginator;
use App\Repository\VehicleRepository;

class VehicleService
{
    private VehicleRepository $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
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
     * @return Vehicle|null
     */
    public function getVehicleById(int $id)
    {
        $qb = $this->vehicleRepository->findById($id);
        return $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
    }
}
