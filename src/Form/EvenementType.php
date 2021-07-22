<?php

namespace App\Form;

use App\Entity\Bar;
use App\Entity\Evenement;
use App\Entity\Hotel;
use App\Entity\Jet;
use App\Entity\Plage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('date', DateType::class)
            ->add('ville', TextType::class)
            ->add('pays')
            ->add('posterFile', VichFileType::class, [
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
            ->add('bars', EntityType::class, [
                'class' => Bar::class,
                'choice_label' => function (Bar $bar){
                return $bar->getNom().' '. $bar->getVille().'-'. $bar->getPays();
                },
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('hotels', EntityType::class, [
                'class' => Hotel::class,
                'choice_label' => function (Hotel $hotel){
                return $hotel->getNom().' '.$hotel->getVille().'-'.$hotel->getPays();
                },
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('jets', EntityType::class, [
                'class' => Jet::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
