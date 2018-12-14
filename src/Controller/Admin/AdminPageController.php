<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 29/11/2018
 * Time: 16:54
 */

namespace App\Controller\Admin;


use App\Entity\Page;
use App\Entity\PageModule;
use App\Form\PageModuleType;
use App\Form\PageType;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
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
        $page = new Page();

        $form= $this->createForm(PageType::class, $page);
        dump($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $om=$this->getDoctrine()->getManager();
            $om->persist($page);
            $this->em->flush();

            $this->addFlash('success', 'La page a été ajoutée');
            return $this->redirectToRoute('admin.page.index');
        };
        return $this->render('admin/pages/nouveau.html.twig',[
            'form'=> $form->createView(),
            'source'=>'page',
            'pages'=> $pages
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