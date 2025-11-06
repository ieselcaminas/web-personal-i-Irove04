<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Pikmin;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PikminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'nombre',
            ])
            ->add('guardar', SubmitType::class, [
                'label' => 'Guardar Pikmin',
                'attr' => ['class' => 'btn btn-success mt-3']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pikmin::class,
        ]);
    }
}
