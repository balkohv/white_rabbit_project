<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class UserController extends AbstractController
{
     /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils,AuthorizationCheckerInterface $authChecker,SessionInterface $session)
    {
       
            if (true === $authChecker->isGranted('ROLE_USER')) {
                return $this->render('user/login.html.twig', [ 
                        'last_username' => $authenticationUtils->getLastUsername(),
                        'error' => $authenticationUtils->getLastAuthenticationError(),
                    ]);
            }
            else{
                
                $form = $this->createForm(UserType::class);
                return $this->render('user/login.html.twig', [ 
                        'controller_name' => 'UserController',
                        'log'=>true,
                        'form'=>$form->createView(),
                    ]);
            }
        
       
    }
}
