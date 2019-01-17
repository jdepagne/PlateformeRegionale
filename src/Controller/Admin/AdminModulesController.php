<?php
/**
 * Created by PhpStorm.
 * User: jdepagne
 * Date: 29/11/2018
 * Time: 14:19
 */

namespace App\Controller\Admin;


use App\Entity\Categorie;
use App\Entity\Module;

use App\Entity\Page;
use App\Entity\PageModule;
use App\Form\CategorieType;
use App\Form\ModuleType;
use App\Form\PageType;
use App\Repository\CategorieRepository;
use App\Repository\ModuleRepository;

use App\Repository\PageModuleRepository;
use App\Repository\PageRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminModulesController
 * @package App\Controller\Admin
 */
class AdminModulesController extends AbstractController
{


    /**
     * @var moduleRepository
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
     * @Route("/admin/module", name="admin.module.index")
     * @return Response
     */
    public function index(PageRepository $pageRepository)
    {
        $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
        $modules= $this->moduleRepository->findBy([], ['dateInsertion'=>'DESC']);

        return $this->render('admin/modules/indexModule.html.twig', compact('modules','pages'));
//        return $this->render('admin/modules/indexModule.html.twig');
    }

    /**
     *@Route("/admin/module/nouveau", name="admin.module.nouveau")
     *@return Response
     */
    public function ajouter(Request $request, PageRepository $pageRepository) :Response
    {
        $pages = $pageRepository->findBy(['etatPublicationPage' => 1]);
        $modules = $this->moduleRepository->findAll();

        $form = $this->createFormBuilder()
            ->add('module', ModuleType::class)
            ->add('categorie_create', CategorieType::class, array(
                'required' => false,
                'label' => 'Créer une nouvelle categorie'
            ))
            ->add('page_ajout', EntityType::class, array(
                'class' => Page::class,
                'label' => 'Ajouter à une page existante',
                'multiple' => false,
                'choice_label' => 'titrePage',
                'required' => false,
//                'query_builder' => function (PageRepository $pageRepository) {
//                    return $pageRepository->getfindAllQueryBuilder();
//                }
            ))
            ->add('page_create', PageType::class, array(
                'required' => false,
                'label' => 'Créer une nouvelle page'
            ))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $module = $form->get('module')->getData();

            $categorieCreate = $form->get('categorie_create')->getData();
            $pageAjout = $form->get('page_ajout')->getData();
            $pageCreate = $form->get('page_create')->getData();

             if ($categorieCreate !== null ) {
                $module->addCategory($categorieCreate);
            }

            //on insere le module dans un objet pageModule puis on gere l'ajoute de page
            $pageModule = new PageModule();
            $pageModule->setModule($module);

            if ($pageAjout !== null && $pageCreate->getTitrePage() == null) {
                $pageModule->setPage($pageAjout);
            } elseif ($pageAjout == null && $pageCreate->getTitrePage() !== null) {
                $pageModule->setPage($pageCreate);
            } else {
                $info[] = 'Attention: Aucune page n`\'a été ajoutée';
            }
            //on définit l'objet a recuperer avant de la flusher()
            if($pageModule->getPage()==null){
                $data=$module;
            }else{
                $data=$pageModule;
            }

            $this->em->persist($data);
            $this->em->flush();

            $this->addFlash('success','L\'article a été créé');
            if (isset ($info) ){
                foreach ($info as $message )
                $this->addFlash('notice',$message );
            }
            return $this->redirectToRoute('admin.module.index');
        }
        return $this->render("admin/modules/nouveau.html.twig",[
            'form'=> $form->createView(),
            'pages'=>$pages,
            'modules'=>$modules
        ]);
    }

    /**
     * @Route("/admin/module/{id}/editer", name="admin.module.editer")
     * @return Response
     */
    public function edit(Module $module, Request $request,PageRepository $pageRepository, PageModuleRepository $pageModuleRepository) :Response
    {
       $pages = $pageRepository->findBy(['etatPublicationPage'=>1]);
       $modules = $this->moduleRepository->findAll();

       $listePage = array();

       $listePageModule = $pageModuleRepository->findBy(['module'=>$module]);

        foreach ($listePageModule as $pageliee){
            $listePage[]=$pageliee->getPage();
        }
        $form= $this->createFormBuilder()
            ->add('module', ModuleType::class, array(
                'data'=> $module
            ))
            ->add('categorie_create', CategorieType::class, array(
                'required' => false,
                'label' => 'Créer une nouvelle categorie'
                 ))
            ->add('page_ajout', EntityType::class, array(
                'class' => Page::class,
                'label' => 'Ajouter à une page existante',
                'multiple' => true,
                'expanded'=> true,
                'choice_label' => 'titrePage',
                'required' => false,
                'data'=> $listePage
            ))
            ->add ('page_create', PageType::class, array(
                'required'=> false,
                'label'=> 'Créer une nouvelle page'
            ))
        ->getForm();
        $form->handleRequest($request);
        if ($form ->isSubmitted() && $form->isValid())
        {
            dump($form->getData());
            $categorieCreate = $form->get('categorie_create')->getData();

           if ($categorieCreate !== null){
               $module->addCategory($categorieCreate);
           }
            $module->setDateModification( new \DateTime());

           // on prend compte des modifications du module  et on le flush
            $this->em->flush();

           $newListePage = $form->get('page_ajout')->getData();
           $pageCreate= $form->get('page_create')->getData();
           if($newListePage !==$listePage && $pageCreate !==null){
               $pageModule = new PageModule();
               $pageModule->setModule($module);

               foreach ($newListePage as $newPageliee){
                   if (in_array($newPageliee, $listePage)==false){
                       $pageModule->setPage($newPageliee);
                       $this->em->persist($pageModule);
                       $this->em->flush();
                   }
               }
               foreach ($listePage as $oldPageliee){
                   if(in_array($oldPageliee, $newListePage)==false){
                       $oldPageModule=$pageModuleRepository->findOneBy(['module'=>$module,'page'=>$oldPageliee]);
                       $this->em->remove($oldPageModule);
                       $this->em->flush();
                   }
               }

           }


//           $this->em->persist();
//           $this->em->flush();
//           $this->addFlash('success','L\'article a été modifié');
//            return $this->redirectToRoute('admin.module.index');
        };
        return $this->render("admin/modules/edit.html.twig", [
            'module'=>$module,
            'form'=>$form->createView(),
            'pages'=>$pages,
           'modules'=>$modules
        ]);
    }

    /**
     * @Route("/admin/module/publier/{id}", name="admin.module.publier", requirements={"id":"[0-9]*"})
     * @return Response
     */
    public function publish(Module $module) :Response
    {
        if($module->getEtatPublication()==1){
            $module->setEtatPublication(0);
        }else {
            $module->setEtatPublication(1);
        }
        $this->em->flush();
        $this->addFlash('success', 'L\'article a été modifié');
        return $this->redirectToRoute('admin.module.index');


    }
}