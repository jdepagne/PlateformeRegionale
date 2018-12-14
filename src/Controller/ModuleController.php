<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 29/11/2018
 * Time: 14:11
 */

namespace App\Controller;


use App\Entity\Module;
use App\Repository\ModuleRepository;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{

    /**
     * @var ModuleRepository
     */
    private $moduleRepository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ModuleRepository $moduleRepository, ObjectManager $em)
    {

        $this->moduleRepository = $moduleRepository;
        $this->em = $em;
    }


    /**
     * @Route("/module/{slug}-{id}", name="module.show", requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Module $module, $slug, PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        if ($module->getSlug() !== $slug)
        {
            return $this->redirectToRoute('module.show',[
                'id'=>$module->getId(),
                'slug'=>$module->getSlug(),

            ],301);

        }
//         $module= $this->moduleRepository->find($id);

        return $this->render('pages/module.html.twig', array('module'=>$module,'current_menu'=>'', 'pages'=>$pages));
    }

}