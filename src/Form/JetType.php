<?php

namespace App\Form;

use App\Entity\Jet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class JetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('aeroportdepart')
            ->add('villeDepart')
            ->add('paysDepart')
            ->add('heureDepart')
            ->add('aeroportdestination', TextType::class)
            ->add('villeDestination')
            ->add('paysDestination')
            ->add('heureArrivee')
            ->add('date')
            ->add('posterFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jet::class,
        ]);
    }
}
