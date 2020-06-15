<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{    
    /**
     * formulaire de modification du mot de passe 
     *étant connecté
     *
     * @param  mixed $builder
     * @param  mixed $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('oldPassword', PasswordType::class, array(

            'mapped' => false,
            'label'=>' ',
            'attr' => array(
                'placeholder' => 'Ancien mot de passe...',
                'class' => 'form-control password',
            
        )))

        ->add('plainPassword', RepeatedType::class, array(

            'type' => PasswordType::class,

            'invalid_message' => 'Les deux mots de passe doivent être identiques',

            'options' => ['attr' => ['class' => 'form-control']],
            'required' => true,
            'options'  => [ 'label' => ' ' ,'attr' => [ 'placeholder' => 'Votre nouveau mot de passe...', 'class' => 'form-control password']],
            'second_options' => [ 'label' => ' ' ,'attr' => [ 'placeholder' => 'Confirmer votre mot de passe', 'class' => 'form-control password']],

        ))

        ->add('submit', SubmitType::class, array(
            'label'=>'Modifier',

            'attr' => array(

                'class' => 'btn btn-primary'

            )

            ))
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
