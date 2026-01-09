<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;


final class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // Créer l'email
            $email = (new Email())
                ->from($data['email'])
                ->to('kyrii@contact.com')
                ->subject('Nouveau message du formulaire de contact')
                ->text(
                    "Nom: {$data['name']}\n".
                    "Email: {$data['email']}\n".
                    "Message:\n{$data['message']}"
                );

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé !');
            return $this->redirectToRoute('app_accueil');
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'contactForm' => $form->createView(),
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
