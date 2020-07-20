<?php
namespace App\Controller\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route ("/login", name="security.login", methods="GET|POST")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        return $this->render('pages/security/login.html.twig',
            [
            'dernier_utilisateur' => $lastUsername,
                'erreur' => $error
        ]);
    }

    /**
     * @Route("/logout", name="security.logout", methods="GET|POST")
     * @return Response
     */
    public function logout(): Response
    {
        return $this->render('pages/home.html.twig') ;
    }
}
