<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 13/12/2018
 * Time: 15:51
 */

namespace App\Controller\Admin;


use App\Entity\PageModule;
use App\Form\PageModuleType;
use App\Repository\PageModuleRepository;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageModuleController extends AbstractController
{

    /**
     * @var PageModuleRepository
     */
    private $pageModuleRepository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(PageModuleRepository $pageModuleRepository, ObjectManager $em)
    {
        $this->pageModuleRepository = $pageModuleRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/page/nouveau", name="admin.page.nouveau")
     * @param Request $request
     * @return Response
     *
     */
    public function ajouter(Request $request, PageRepository $pageRepository)  :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $pageModule= new PageModule();

        $form= $this->createForm(PageModuleType::class, $pageModule);
        dump($request);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($pageModule);
            $this->em->flush();

            $this->addFlash('success', 'La page a été ajoutée');
            return $this->redirectToRoute('admin.page.index');
        };
        return $this->render('admin/pages/nouveau.html.twig',[
            'form'=> $form->createView(),
            'pages'=> $pages
        ]);
    }
}