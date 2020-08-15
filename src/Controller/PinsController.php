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
     * @Route("/", name="app_home", methods="GET")
     */
    public function index(PinRepository $repo): Response
    {
        return $this->render('pins/index.html.twig', ['pins' => $repo->findAll()]);
    }


    /**
     * @Route("/pins/{id}")
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pins/show.html.twig', compact('pin'));
    }


    /**
     * @Route("/pins/create", priority=10, name="app_pins_create", methods="GET|POST"))
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;

        $form = $this->createFormBuilder($pin)
            ->add('title', null, ['attr' => ['class' => 'form-control', 'autofocus' => true]])
            ->add('description', null, ['attr' => ['class' => 'form-control']])
            ->getForm();
        ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_pins_show', ['id' => $pin->getId()]);
        }

        return $this->render('pins/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
