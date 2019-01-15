<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\PageModule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('page', PageType::class, array(
//                'entry_type'=> PageType::class,
//                'allow_add'=>true
            ))
            ->add('module', ModuleType::class, array(
                'required'=>false
//                'data_class'=> Module::class,
//                'allow_add'=>true
            ))
//

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PageModule::class,
        ]);
    }
}
