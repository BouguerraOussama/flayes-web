<?php

namespace App\Form;

use App\Entity\Offer;
use App\Entity\Funding;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;

class OfferFundingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title' ,TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Offer title cannot be blank',
                    ]),
                ],
            ])
            ->add('description',TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Description cannot be blank',
                    ]),
                ],
            ])
//            ->add('status')
//            ->add('dateCreated')

//            ->add('project')
//            ->add('user')
            ->add('funding', FundingType::class, [
                'data' => $options['funding'],
                'constraints' => [
                    new Valid(),
                ],
            ])
         ->add('Submit', SubmitType::class, [
             'label' => 'Save',
         ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
            'funding' => null,
        ]);
    }
}
