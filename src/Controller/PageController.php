<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 10/12/2018
 * Time: 11:40
 */

namespace App\Controller;


use App\Repository\ModuleRepository;
use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/page/{id}", name="page.show")
     * @param PageRepository $pageRepository
     * @param $id
     * @return Response
     */
    public function voir( PageRepository $pageRepository, $id) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $page= $pageRepository->find($id);

        return $this->render('pages/categorie.html.twig',array('page'=>$page, 'current_menu'=>$page->getTitrePage() ,'pages'=>$pages));
    }
}