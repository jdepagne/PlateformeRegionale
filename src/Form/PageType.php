<?php

namespace App\Form;

use App\Entity\Page;
use App\Entity\Categorie;
use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
                'choice_value' =>'id',
                'required'=>false
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
