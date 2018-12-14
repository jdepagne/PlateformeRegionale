<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 22/11/2018
 * Time: 15:17
 */

namespace App\Controller\Admin;

use  App\Entity\Categorie;

use App\Form\CategorieType;

use App\Repository\CategorieRepository;

use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategorieController extends AbstractController
{
    /**
     * @var CategorieRepository
     */
    private $categorieRepository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(CategorieRepository $categorieRepository, ObjectManager $em)
    {

        $this->categorieRepository = $categorieRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/categorie", name="admin.categorie.index")
     * @return Response
     */

    public function index(PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $categories = $this->categorieRepository->findAll();
        return $this->render('admin/categorie/indexCategorie.html.twig', compact('categories','pages'));
    }

    /**
     * @Route("/admin/categorie/{id}/editer", name="admin.categorie.editer")
     * @return Response
     */
    public function edit(Categorie $categorie, Request $request, PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $categories = $this->categorieRepository->findAll();
        dump($categorie);
        $form=$this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form -> isSubmitted() && $form ->isValid())
        {

            if($categorie->getParent()==null){
                $categorie->setParent(0);
            }


            $categorie->setDateModification(new \DateTime());
           $this->em->flush();
           $this->addFlash('success','La catégorie a été modifiée');
            return $this->redirectToRoute('admin.categorie.index', compact('pages'));
//            return $this->render('admin/categorie/test.html.twig', compact($categorie));
        };

        return $this->render("admin/categorie/edit.html.twig", [
            'categorie'=>$categorie,
            'categories'=>$categories,
            'form'=>$form->createView(),
            'pages'=>$pages
        ]);
    }

    /**
     * @Route("/admin/categorie/nouveau",name="admin.categorie.nouveau")
     * @param Categorie $categorie
     * @param Request $request
     * @return Response
     */
    public function  nouveau( Request $request, PageRepository $pageRepository) : Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $categories = $this->categorieRepository->findAll();
        $categorie= new Categorie();
        $form=$this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form -> isSubmitted() && $form ->isValid())
        {

            dump($categorie);
           $this->em->persist($categorie);
           $this->em->flush();
           $this->addFlash('success','La catégorie a été créée');
           return $this->redirectToRoute('admin.categorie.index', compact('pages'));
        };

        return $this->render("admin/categorie/nouveau.html.twig",[
            'form'=>$form->createView(),
            'pages'=> $pages,
            'categories'=>$categories

        ]);

    }
}