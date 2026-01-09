<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
             'user' => $this->getUser(),
        ]);
    }

    #[Route('/edit', name: 'app_dashboard_edit')]
    public function edit(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Profil mis à jour');
            return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('dashboard/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/delete', name: 'app_dashboard_delete', methods: ['POST'])]
    public function delete(Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-user', $request->request->get('_token'))) {
            $user = $this->getUser();

            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->redirectToRoute('app_dashboard');
    }
}
