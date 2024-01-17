<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uname', FormType::class, [
                'label' => 'Név'
            ]);

        $builder->add('roles', ChoiceType::class, [
                'label' => [
                    'text' => 'Szerepkörök',
                    'class' => 'form-label'
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ]);

        $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray): string {
                    // transform the array to a string
                    return implode(', ', $tagsAsArray);
                },
                function ($tagsAsString): array {
                    // transform the string back to an array
                    return explode(', ', $tagsAsString);
                }
            ))
        ;

//        dd($builder->get('roles'));

        $builder->add('password', PasswordType::class, [
                'label' => 'Jelszó'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }


    protected function transformRoles($builder)
    {
        return $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesAsArray) {
                     return count($rolesAsArray) ? $rolesAsArray[0]: null;
                },
                function ($rolesAsString) {
                     return [$rolesAsString];
                }
        ));
    }
}
