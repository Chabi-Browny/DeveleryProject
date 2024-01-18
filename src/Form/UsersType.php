<?php

namespace App\Form;

use App\Entity\Users;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $users = new Users();

        $builder
            ->add('uname', TextType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Túl kevés karakter! Legalább {{ limit }} hosszú legyen a név.',
                        'max' => 125,
                        'maxMessage' => 'Túl sok karakter! Legfeljebb {{ limit }} hosszú lehet a név.',
                    ])
                ],
                'label' => 'Név',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);

        $builder->add('roles', ChoiceType::class, [
                'required' => true,
                'label' => 'Szerepkörök',
                'attr' => [
                    'class' => 'form-select'
                ],
                'choices' => $users->getDefaultRoles()
            ]);

        $builder->get('roles')
                ->addModelTransformer( new CallbackTransformer(
                function ($rolesArray): string {
                    // transform the array to a string
                    return implode(', ', $rolesArray);
                },
                function ($rolesString): array {
                    // transform the string back to an array
                    return explode(', ', $rolesString);
                }
            ))
        ;

        $builder->add('password', PasswordType::class, [
                'required' => true,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Túl kevés karakter! Legalább {{ limit }} hosszú legyen a jelszó.',
                    ])
                ],
                'label' => 'Jelszó',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

}
