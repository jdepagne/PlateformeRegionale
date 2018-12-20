<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Categorie;

use App\Repository\PageRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choicesEP=['oui'=>1,'non'=>0];
        $builder
            ->add('titrePage')
            ->add('descriptionPage')
            ->add('etatPublicationPage', ChoiceType::class,[
                'choices'=>$choicesEP,
                'expanded'=>true,
                'label'=>'Activer la publication'
            ])

            ->add('categories', EntityType::class,array(
                'class' =>Categorie::class,
                'multiple' => true,
                'choice_label'=> 'nom',
                'choice_value'=> 'id',
                'required'=>false,
             ))
            ->add('parent', EntityType::class, array(
                'class'=>Page::class,
                'multiple'=>false,
                'choice_label'=>'titrePage',
                'required'=>false,
                'query_builder'=>function(PageRepository $pageRepository){
                    return $pageRepository->getfindAllQueryBuilder();
                }
            ))
         ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,

        ]);
    }
}
