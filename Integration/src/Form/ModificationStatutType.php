<?php

namespace App\Form;

use App\Entity\Appareil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ModificationStatutType extends AbstractType
{    
    /**
     * genere le formulaire qui peemet de modifier
     *avec des valeurs de retour du controleur
     *
     * @param  mixed $builder
     * @param  mixed $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         
            ->add('type',TextType::class)
            ->add('modele',TextType::class)
            ->add('capacite',TextType::class)
            ->add('imei',TextType::class)
            ->add('serial',TextType::class)
            ->add('mac',TextType::class)
            ->add('description',TextType::class)
            ->add('statut', ChoiceType::class, [
                'choices'  => [
                        'Possede' => 'Possede',
                        'Volé' => 'Vole',
                        'Vendu' => 'Vendu',
                         
                ]
                
            ])
            //->add('detenteur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appareil::class,
        ]);
    }
}
