<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Categorie;
use App\Entity\PageModule;
use App\Repository\PageModuleRepository;
use App\Repository\PageRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choicesEP=['oui'=>1,'non'=>0];

        $builder
            ->add('titre')
            ->add('etatPublication', ChoiceType::class,[
                'choices'=>$choicesEP,
                'expanded'=>true,
                'label'=>'Activer la publication'
            ])
            ->add('categories', EntityType::class,array(
                'class'=> Categorie::class,
                'multiple'=>true,
                'expanded'=>true,
                'choice_label'=> 'nom',
                'choice_value'=>'id',
                'required'=> false
            ))
            ->add('contenu', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Module::class
        ]);
    }
}
