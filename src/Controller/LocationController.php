<?php

namespace App\Controller;

use App\Entity\Departments;
use App\Entity\Regions;
use App\Repository\CitiesRepository;
use App\Repository\DepartmentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    /**
     * @Route("/location/department/{id}", name="location_department")
     */
    public function getDepartements(Regions $region,DepartmentsRepository $repoDepartment)
    {
       $departments=$repoDepartment->findBy(['region'=>$region]);
       return $this->json($departments,200,[],['groups'=>['department']]);
    }

    /**
     * @Route("/location/city/{id}", name="location_city")
     */
    public function getCities($id,CitiesRepository $repoCity)
    {
        $cities=$repoCity->findByDepartment($id);
        return $this->json($cities,200,[],['groups'=>['city']]);
    }
}
