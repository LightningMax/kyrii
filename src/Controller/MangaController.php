<?php

namespace App\Controller;

use App\Entity\Manga;
use App\Form\MangaType;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/manga')]
final class MangaController extends AbstractController
{
    #[Route(name: 'app_manga_index', methods: ['GET'])]
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('manga/index.html.twig', [
            'mangas' => $mangaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_manga_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manga = new Manga();
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($manga);
            $entityManager->flush();

            return $this->redirectToRoute('app_manga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manga/new.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manga_show', methods: ['GET'])]
    public function show(Manga $manga): Response
    {
        return $this->render('manga/show.html.twig', [
            'manga' => $manga,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_manga_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manga $manga, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_manga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manga/edit.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manga_delete', methods: ['POST'])]
    public function delete(Request $request, Manga $manga, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manga->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($manga);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_manga_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/manga/add-standard', name: 'app_manga_add_standard')]
    public function addStandard(EntityManagerInterface $em, MangaRepository $repo): Response
    {
        $standardMangas = [
            ['title' => 'Blame!', 'author' => 'Tsutomu Nihei', 'price' => 8, 'image' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fd28hgpri8am2if.cloudfront.net%2Fbook_images%2Fonix%2Fcvr9781421586205%2Fgoodnight-punpun-vol-1-9781421586205_hr.jpg&f=1&nofb=1&ipt=475c9aab3d4f3fdbdbfeb11eaaf6594b604ea8ff67899bb40fcdd8db929a85ea'],
            ['title' => 'Goodnight Punpun', 'author' => 'Inio Asano', 'price' => 12, 'image' => 'https://upload.wikimedia.org/wikipedia/en/e/ef/Blame%21_manga_vol_1.jpg'],
            ['title' => 'Solanin', 'author' => 'Inio Asano', 'price' => 12, 'image' => 'https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.manga-news.com%2Fpublic%2Fimages%2Fseries%2FSolanin-1-kana.jpg&f=1&nofb=1&ipt=51d7adbcd16501dc68eac0a1becef4832a7f46e29ead4823e52bc5b7506eb690'],
        ];

        foreach ($standardMangas as $mangaData) {
            // check if it already exists
            $existing = $repo->findOneBy(['title' => $mangaData['title']]);
            if (!$existing) {
                $manga = new \App\Entity\Manga();
                $manga->setTitle($mangaData['title']);
                $manga->setAuthor($mangaData['author']);
                $manga->setPrice($mangaData['price']);
                $manga->setImage($mangaData['image']);
                $em->persist($manga);
            }
        }

        $em->flush();

        $this->addFlash('success', 'Les mangas standards ont été ajoutés !');

        return $this->redirectToRoute('app_manga_index'); // or homepage
    }

}
