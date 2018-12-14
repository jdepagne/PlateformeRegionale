<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 15/11/2018
 * Time: 17:16
 */

namespace App\Controller\Admin;


use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.index")
     * @return Response
     */

    public function index(PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        return $this->render('admin/index.html.twig', array('pages'=>$pages));
    }
}