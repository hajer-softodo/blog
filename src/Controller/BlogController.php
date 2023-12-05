<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
// use Doctrine\DBAL\Types\TextType;
// use Doctrine\Persistence\ObjectManager;
// use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\TextareaType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    public function home(TranslatorInterface $translator)
    {
        // $message = $translator->trans('Bienvenue dans ce blog !');
        // $this->addFlash('message', $message);
        return $this->render('blog/home.html.twig');
    }

    #[Route('/blog/new', name: 'blog_create')]
    #[Route('/blog/{id}/edit', name: 'blog_edit')]
    public function form(Article $article =null ,Request $request, EntityManagerInterface $manager)
    {
        if(!$article) {
            $article = new Article();
        }
            $form=$this->createForm(ArticleType::class, $article);
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                if(!$article->getId()){
                    $article->setCreatedAt(new \DateTimeImmutable());
                }
                
                $manager->persist($article);
                $manager->flush();
                return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
            }

        return $this->render('blog/create.html.twig',
                              ['formArticle' => $form->createView(),
                              'article' => $article,
                              'editMode' =>  $article->getId() !== null
                            ]);
      
    }

    #[Route('/blog/{id}/delete', name: 'delete')]
    public function delete(Article $article, EntityManagerInterface $manager): Response
    {
        
        $manager->remove($article);
        $manager->flush();
        return $this->render('blog/delete.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $article,
        ]);
    }


    #[Route('/blog/{id<\d+>}', name: 'blog_show')]
    public function show(ArticleRepository $articleRepo, $id, Request $request, EntityManagerInterface $manager)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $articles = $articleRepo->find($id);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \Datetime())
                    ->setArticle($articles);
            $manager->persist($comment);
                $manager->flush();
                return $this->redirectToRoute('blog_show', [
                    'id' => $articles->getId()
                ]);
        }

     
        return $this->render('blog/show.html.twig',
        ['article' => $articles,
        'commentForm' => $form->createView()] );
    }
        #[Route('/switch-locale/{locale}', name: 'switch_locale')]
        public function switchLocale(Request $request,string $locale)
        {
            // Set the new locale
            $request->setLocale($locale);
            // dd( $request->getLocale());
       
            return $this->redirectToRoute('home');
        }

}
