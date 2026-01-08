<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route(['/', 'accueil'], name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    
    #[Route(['mentions-legales'], name: 'legal_mentions')]
    public function mentions(): Response
    {
        return $this->render('accueil/mentions-legales.html.twig', [
        ]);
    }
    
    #[Route(['cgu'], name: 'legal_cgu')]
    public function cgu(): Response
    {
        return $this->render('accueil/cgu.html.twig', [
        ]);
    }
    
    #[Route(['politique-confidentialite'], name: 'legal_privacy')]
    public function privacy(): Response
    {
        return $this->render('accueil/politique-confidentialite.html.twig', [
        ]);
    }
    
    #[Route(['qui-sommes-nous'], name: 'about')]
    public function about(): Response
    {
        return $this->render('accueil/qui-sommes-nous.html.twig', [
        ]);
    }
}
