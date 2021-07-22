<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                "label" => "Nom du client",
                "attr" => [
                    "style" => "color: black;",
                    "placeholder" => "Nom"
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        "minMessage" => "trop petit"
                    ]),
                ]
            ])
            ->add('prenom', TextType::class, [
                "attr" => [
                    "style" => "color: black;",
                    "placeholder" => "Prénom"
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 3, 
                        "minMessage" => "trop petit"
                    ]),
                ]
            ])
            ->add("Envoyer", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
