<?php
namespace App\Controller;

use App\Repository\ModuleRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(ModuleRepository $moduleRepository, PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
       $lastModules=  $moduleRepository->findBy(['etatPublication'=>1], ['dateInsertion'=>'DESC']);
       //$lastArticles=  $articleRepository->findAll();
        return $this->render('pages/home.html.twig', array('current_menu'=>'home', 'lastModules'=>$lastModules, 'pages'=>$pages));
       // return $this->render('pages/home.html.twig', array('current_menu'=>'home'));
    }

}
