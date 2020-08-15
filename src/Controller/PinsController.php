<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class PinsController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $repo): Response
    {   
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }


    /**
     * @Route("/pins/create", name="app_pins_create", methods="GET|POST"))
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {   
        if($request->isMethod('POST')){
            $data = $request->request->all();

            if ($this->isCsrfTokenValid('pins_create', $data['_token'])) {
                $pins = new Pin;
                $pins->setTitle($data['title']);
                $pins->setDescription($data['description']);
                $em->persist($pins);
                $em->flush();
            }

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pins/create.html.twig');
    }
}
