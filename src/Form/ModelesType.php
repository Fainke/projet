<?php
/**
 * Created by PhpStorm.
 * User: stagiaire
 * Date: 29/06/2018
 * Time: 09:42
 */

namespace App\Form;


use App\Entity\Modeles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModelesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class)
            ->add('name', null, [
                "label" => 'Nom du produit'
            ])
            ->add('description')
            ->add('ajoutAt', null, [
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modeles::class,
        ]);
    }

}