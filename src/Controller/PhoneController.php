<?php

namespace App\Controller;

use App\Entity\Phone;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Doctrine\ORM\EntityManagerInterface;


class PhoneController extends AbstractFOSRestController {

    /**
     * @Route(path="phones/{id}", name="phone_Show")
     * @View
     * @param Phone $phone
     * @return phone
     */

    public function phone_Show(Phone $phone): Phone
    {

        return $phone;

    }

    /**
     * @Route(path="phones", name="phone_Index")
     * @View
     */

    public function phone_Index()
    {
        $phone = $this->getDoctrine()->getRepository('App:Phone')->findAll();

        return $phone;

    }

}