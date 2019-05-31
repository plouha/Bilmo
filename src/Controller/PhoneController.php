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
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


class PhoneController extends AbstractFOSRestController {

    /**
     * @SWG\Get(
     *     description="Show one phone.",
     *     tags = {"Phones"},
     *     @SWG\Response(
     *          response=200,
     *          @Model(type=Phone::class),
     *          description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad Request: Method Not Allowed",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: Expired JWT Token/JWT Token not found",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Phone object not found: Invalid ID supplied/Invalid Route",
     *     )
     * )
     * 
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
     * @SWG\Get(
     *     description="Get the list of phones.",
     *     tags = {"Phones"},
     *     @SWG\Response(
     *          response=200,
     *          @Model(type=Phone::class),
     *          description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Bad Request: Method Not Allowed",
     *     ),
     *     @SWG\Response(
     *         response="401",
     *         description="Unauthorized: Expired JWT Token/JWT Token not found",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not Found: Invalid Route",
     *     )
     * )
     * 
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

