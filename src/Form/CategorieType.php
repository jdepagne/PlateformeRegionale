<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('parent', EntityType::class,array(
                'class' =>Categorie::class,
                'multiple' => false,
                'choice_label'=> 'nom',
                'empty_data'=> 'Choississez une categorie parente',
                'required'=>false,
                'query_builder' => function (CategorieRepository $categorieRepository){
                    return $categorieRepository->getfindAllQueryBuilder();
                }
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class
        ]);
    }
}
