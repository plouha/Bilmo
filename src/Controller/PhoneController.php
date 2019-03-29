<?php

namespace App\Controller;

use App\Entity\Phone;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Request\ParamFetcher;
use App\Repository\PhoneRepository;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;


class PhoneController extends AbstractFOSRestController {

    /**
     * @Route(path="phones/{id}", name="phone_Show", methods={"GET"})
     * @View
     * @param Phone $phone
     * @return phone
     */

    public function phone_Show(Phone $phone): Phone
    {

        return $phone;

    }

    /**
     * @Route(path="/phones", name="phone_list", methods={"GET"})
     * @QueryParam(name="page", default="1")
     * @View
     */

    public function list(ParamFetcher $paramFetcher, PhoneRepository $phoneRepository)
    {
        $paginatedPhones = $phoneRepository
            ->getPaginatedPhones($paramFetcher->get("page"));       
        
        $pagerfantaFactory = new PagerfantaFactory();
        /*$paginatedPhones = $this->getDoctrine()->getRepository('App:Phone')->findAll();*/        
        return $pagerfantaFactory->createReprésentation(
            $paginatedPhones,
            new \Hatoas\Configuration\Route('phone_list', [])
        );

    }

}