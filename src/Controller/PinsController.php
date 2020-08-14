<?php

namespace App\Controller;

use App\Entity\Pin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{

    /**
     * @Route("/", name="pins")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $pin = new Pin;
        $pin->setTitle('Title 4');
        $pin->setDescription('Description 4');

        $em->persist($pin);
        $em->flush();

        // dd($pin); pareil que dump($pin) suivi de die;
        
        return $this->render('pins/index.html.twig');
    }

}
