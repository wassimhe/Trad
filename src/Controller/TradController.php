<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\ArticleType;



class TradController extends AbstractController
{
    /**
     * @Route("/trad", name="trad")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findAll();

        return $this->render('trad/index.html.twig', [
            'controller_name' => 'TradController',
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('trad/home.html.twig', [ 'title' => "Bienvenue !!",
        'age' => 31
        ]);
    }
     
    /**
     *  @Route("/trad/new" , name="trad_create")
     *  @Route("/trad/{id}/edit" , name="trad_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager)
    {

        if(!$article)
        {    
            $article = new Article();
        }

             
        $form = $this->createForm(ArticleType::class, $article);
                     
        $form->handleRequest($request);
      
        if($form -> isSubmitted() && $form -> isValid() )
        {
            if(!$article->getId())
            {           $article -> setCreatedAt(new \DateTime());
            }
            $manager -> persist($article);
            $manager -> flush();
          

            return $this->redirectToRoute('trad_show', ['id' => $article -> getId()
            ]);
        }

        return $this->render('trad/create.html.twig', ['form1' => $form->createView() ,
         'editMode' => $article->getId() !== null ]);
    }
    
    
    
    
    /**
     *  @Route("/trad/{id}", name="trad_show")
     */
    public function show(Article $article)
    {
        
        
        return $this->render('trad/show.html.twig', ['article' => $article]);
    }

   
}
