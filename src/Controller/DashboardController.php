<?php

namespace App\Controller;

use App\Form\LocationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard/index", name="dashboard_index")
     */
    public function dashboard_index(Request $request , AuthorizationCheckerInterface $authChecker,SessionInterface $session)
    {
        if(null !==($request->request->get("loc"))){
            $response = $this->forward('App\Controller\LocationController::new_location', array('request' => $request,));return $response;
        }
        $form = $this->createForm(LocationType::class);
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'form_location' => $form->createView(),
        ]);
    }
}
