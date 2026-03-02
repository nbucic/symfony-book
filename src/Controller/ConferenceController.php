<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConferenceController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('conference/index.html.twig');
    }

    #[Route('/conference/{slug}', name: 'conference')]
    public function show(Request $request, #[MapEntity(mapping: ['slug' => 'slug'])] Conference $conference, CommentRepository $commentRepository): Response
    {
        dump($conference);
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $commentRepository->getCommentPaginator($conference, $offset);

        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::COMMENTS_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::COMMENTS_PER_PAGE),
        ]);
    }
}
