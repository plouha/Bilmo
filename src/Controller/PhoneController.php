<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Hateoas\Configuration\Route as HatoasRoute;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @Security("is_granted('ROLE_USER')")
 */
class PhoneController extends AbstractFOSRestController {

    /**
     * @Route(path="/phones/{id}", name="phoneShow", methods={"GET"})
     * @View
     * @param Phone $phone
     * @return phone
     */

    public function phoneShow(Phone $phone): Phone
    {

        return $phone;

    }

    /**
     * @Route(path="/phones", name="phonelist", methods={"GET"})
     * @QueryParam(name="page", default="1")
     * @View
     */

    public function list(PhoneRepository $phoneRepository, $paramFetcher)
    {

        $pagerfantaFactory   = new PagerfantaFactory(); 
            
        $pager = $phoneRepository->getPaginatedPhones($paramFetcher->get("page", 1));
        
        $paginatedCollection = $pagerfantaFactory->createRepresentation(
              $pager,
              new HatoasRoute('phonelist', array())
          );
          
        return $paginatedCollection;

    }
}        

