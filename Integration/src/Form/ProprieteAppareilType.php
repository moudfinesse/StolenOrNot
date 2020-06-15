<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\StringType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Appareil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ TextareaType;

class ProprieteAppareilType extends AbstractType
{// this form is for adding items
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type', ChoiceType::class, [
            'choices'  => [
                '---------'          =>'',
                'Laptop' => 'Laptop',
                'Mobile' => 'Mobile',
                'Tablet' =>'Tablet'
            ] ])
      
        ->add('modele', ChoiceType::class, [
            'choices'  => [
                'Mobile' =>[
                '---------'          =>'',
                'Iphone 11' => 'Apple-iPhone-11',
                'Iphone 8' => 'Apple-iPhone-8',
                'Iphone 8 plus' => 'Apple-iPhone-8-Plus',
                'Iphone X' => 'Apple-iPhone-X',
                'Iphone 7 Plus' => 'Apple-iPhone-7-Plus',
                'Samsung Galaxy Note 9'=>'Samsung-galaxy-Note9',
                'Samsung Galaxy Note 8'=>'Samsung-galaxy-Note8',
                'Samsung Galaxy S9'=>'Samsung-galaxy-S9',
                'Samsung Galaxy S8'=>'Samsung-galaxy-S8',
                'Iphone 7' => 'Apple-iPhone-7',],
                'laptop'=>[
                    'Asus' => 'asus',
                    'Macbook Pro'=>'MacBook-Pro-13'
                ],'tablet'=>[
                    'Samsung galaxy tab S3' => 'Samsung-Galaxy-Tab-S3',
                   
                ]
            ] ])
            //->add('marque',TextType::class)
            ->add('capacite', ChoiceType::class, [
                'choices' => [
                    'Mobile' => [
                        '---------'          =>'',
                        '64GB' => '64GB',
                        '128GB' => '128GB',
                        '256GB' => '256GB',
                    ],
                    'laptop' => [
                        'Asus core i5' => 'core-i5',
                        'Macbook Pro Core i7' =>'CORE-i7'
                        
                    ],
                    'tablet' => [
                        'Samsung 32GB' => '32GB',
                        
                        
                    ],
                ],
            ])   
            ->add('imei',TextType::class,[
                'required' => false,
            
            ])
            ->add('serial',TextType::class)
            ->add('mac',TextType::class,[
                'required' => false,
            
            ])
            ->add('description',TextAreaType::class)
            
            ->add('statut', ChoiceType::class, [
                'choices'  => [
                        'Possedé' => 'possedé',
                        'Volé' =>'volé'
                         
                ]
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appareil::class,
        ]);
    }
}
