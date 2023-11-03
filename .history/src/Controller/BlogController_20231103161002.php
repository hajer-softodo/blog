<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $articleRepo): Response
    {
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $articleRepo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    #[Route('/', name: 'home')]
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    #[Route('/blog/{id?0}', name: 'blog_show')]
    public function show(ArticleRepository $articleRepo, $id)
    {
        $articles = $articleRepo->find($id);
        return $this->render('blog/show.html.twig',
        ['article' => $articles] );
    }

    #[Route('/blog/{id?0}', name: 'blog_show')]
    public function show(ArticleRepository $articleRepo, $id)
    {
        $articles = $articleRepo->find($id);
        return $this->render('blog/show.html.twig',
        ['article' => $articles] );
    }
}
