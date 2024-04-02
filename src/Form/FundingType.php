<?php

namespace App\Form;

use App\Entity\Funding;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FundingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Dept Investment' => 'dept',
                    'Revenue Investment' => 'revenue',
                    'Equity Investment' => 'equity',
                ],
                'placeholder' => 'Select Funding Type',
                // Add any other options you need (e.g., required, expanded, etc.)
            ])
            ->add('attribute1')
            ->add('attribute2')
            ->add('attribute3')
            ->add('textattribute')
//            ->add('score')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Funding::class,
        ]);
    }
}
