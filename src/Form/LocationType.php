<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,array(
                'label' => 'nom',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('ville', TextType::class,array(
                'label' => 'ville',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('adresse', TextType::class,array(
                'label' => 'adresse',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('code_postal', TextType::class,array(
                'label' => 'code postal',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('french', TextType::class,array(
                'label' => 'france',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('lon', TextType::class,array(
                'label' => 'lon',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('lat', TextType::class,array(
                'label' => 'lat',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
            ->add('dist', TextType::class,array(
                'label' => 'distance',
                'attr' => ['class' => 'form-control form_input'],
                )
                )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
