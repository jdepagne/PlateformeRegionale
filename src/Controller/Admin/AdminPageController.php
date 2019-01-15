<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 29/11/2018
 * Time: 16:54
 */

namespace App\Controller\Admin;


use App\Entity\Module;
use App\Entity\Page;
use App\Entity\PageModule;

use App\Form\CategorieType;
use App\Form\PageType;
use App\Form\ModuleType;

use App\Repository\ModuleRepository;
use App\Repository\PageRepository;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController
{
    /**
     * @var PageRepository
     */
    private $pageRepository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function  __construct(PageRepository $pageRepository, ObjectManager $em)
    {
        $this->pageRepository = $pageRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/page", name="admin.page.index")
     * @return Response
     */
    public function index()
    {
        $pages=$this->pageRepository->findBy(['etatPublicationPage'=>1]);
        $listePages= $this->pageRepository->findBy([], ['dateInsertionPage'=>'DESC']);
        return $this->render('admin/pages/indexPage.html.twig', compact('pages','listePages'));
//        return $this->render('admin/modules/indexModule.html.twig');
    }

    /**
     * @Route("/admin/page/nouveau", name="admin.page.nouveau")
     * @param Request $request
     * @return Response
     *
     */
    public function ajouter(Request $request, PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $listePages = $pageRepository->findby([],['dateInsertionPage'=>'DESC'] );


        $form= $this->createFormBuilder()
            ->add('page', PageType::class)
            ->add('categorie_create', CategorieType::class, array(
                'required'=>false,
                'label'=> "Créer une nouvelle categorie"
            ))
            ->add('module_create', ModuleType::class, array(
                'required'=>false
            ))
            ->add('module', EntityType::class, array(
                        'class' =>Module::class,
                        'multiple' => false,
                        'choice_label'=> 'titre',
                        'required'=>false,
                        'query_builder' => function (ModuleRepository $moduleRepository){
                            return $moduleRepository->getfindAllQueryBuilder();
                        }
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
           $page= $form->get('page')->getData();
           $module = $form->get('module')->getData();
           $module_create = $form->get('module_create')->getData();
           $categorie_create = $form->get('categorie_create')->getData();
            $pageModule=new PageModule();


            if($module == null  && $module_create->getTitre() == null)
            {
                $this->em->persist($page);
                $this->em->flush();

            } elseif ($module_create->getTitre() !== null  && $module == null){

                $pageModule->setPage($page);
                $pageModule->setModule($module_create);

                $this->em->persist($pageModule);
                $this->em->flush();

            } elseif ($module_create->getTitre() == null && $module->getId() !== null){
                $pageModule->setPage($page);
                $pageModule->setModule($module);

                $this->em->persist($pageModule);
                $this->em->flush();
            }
            $this->addFlash('success', 'La page a été ajoutée');
            return $this->redirectToRoute('admin.page.index');
        };
        return $this->render('admin/pages/nouveau.html.twig',[
            'form'=> $form->createView(),
            'pages'=> $pages,
            'listePages'=>$listePages
        ]);
    }

    /**
     * @Route("admin/page/{id}/editer",name="admin.page.editer")
     * @param Page $page
     * @param Request $request
     * @param PageRepository $pageRepository
     * @return Response
     * @throws \Exception
     */
    public function editer(Page $page, Request $request, PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $form=$this->createForm(PageType::class,$page);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $page->setDateModificationPage(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'la page a été modifiée' );
            return $this->redirectToRoute('admin.page.index', compact('pages'));
        }
        return $this->render("admin/pages/edit.html.twig",[
            'page'=>$page,
            'form'=>$form->createView(),
            'pages'=>$pages
        ]);
    }

    /**
     * @Route("/admin/page/publier/{id}", name="admin.page.publier", requirements={"id":"[0-9]*"})
     * @return Response
     */
    public function publier(Page $page) :Response
    {
        if($page->getEtatPublicationPage()==1){
            $page->setEtatPublicationPage(0);
        }else{
            $page->setEtatPublicationPage(1);
        }
        $this->em->flush();
        dump($page);
        $this->addFlash('success', 'La page a été modifiée');
        return $this->redirectToRoute('admin.page.index');
    }
}