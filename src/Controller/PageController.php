<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 10/12/2018
 * Time: 11:40
 */

namespace App\Controller;


use App\Repository\ModuleRepository;
use App\Repository\PageModuleRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * @var PageRepository
     */
    private $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @Route("/{titre}", name="page.show")
     * @param PageRepository $pageRepository
     *
     * @return Response
     */
    public function voir( PageRepository $pageRepository, $titre) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $page= $pageRepository->findOneBy(['titrePage'=>$titre]);
        $liste= $page->getPageModules();

        $modules=array();
        foreach ($liste as $pm){
            $module=$pm->getModule();
            dump($module);
            $modules[]=$module;
        }
        dump($modules);


        return $this->render('pages/page.html.twig',array(
            'page'=>$page,
            'current_menu'=>$page->getTitrePage() ,
            'pages'=>$pages,
            'modules'=>$modules
           ));
    }
}