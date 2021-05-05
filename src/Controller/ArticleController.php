<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Article;
use App\Entity\Fichier;
use App\Form\ArticleType;
use App\Services\UploadFile;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, UploadFile $uploadFile, EntityManagerInterface $em): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = new Article();
            $article = $form->getData();
            //dd($article);
            $tab_image = $form->get("imageFile")->getData();
            $tab_fichier = $form->get("fichierFile")->getData();
            $tab_video = $form->get("videoFile")->getData();
            if(count($tab_image) > 0){
                for($i=0; $i<count($tab_image); $i++){
                    $filename = $uploadFile->upload($tab_image[$i]);
                    $image = new Image();
                    $image->setUrl($filename);
                    $image->setArticle($article);
                    $em->persist($image);
                    
                }
            }
            if(count($tab_fichier) > 0){
                for($i=0; $i<count($tab_fichier); $i++){
                    $filename = $uploadFile->upload($tab_fichier[$i]);
                    $fichier = new Fichier();
                    $fichier->setUrl($filename);
                    
                    $em->persist($fichier);
                   
                   $article->addFichier($fichier);
                }
            }
            if(count($tab_video) > 0){
                for($i=0; $i<count($tab_video); $i++){
                    $filename = $uploadFile->upload($tab_video[$i]);
                    $video = new Video();
                    $video->setUrl($filename);
                    $em->persist($video);
                    
                    $article->addVideo($video);
                }
            }
            
            $em->persist($article);
           // dd($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
