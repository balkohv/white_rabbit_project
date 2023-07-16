<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LocationType;

class LocationController extends AbstractController
{
    /**
     * @Route("/location/new", name="new_location")
     */
    public function new_location(): Response
    {
        $form = $this->createForm(LocationType::class);
        return $this->render('location/new.html.twig', [
            'controller_name' => 'LocationController',
            'form'=>$form->createView(),
        ]);
    }
}
