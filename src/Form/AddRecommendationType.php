<?php

namespace App\Form;

use App\Stock\Content\Recommendation\Data\StockRecommendationData;
use App\Stock\Content\Recommendation\Data\StringToDatetimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddRecommendationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companyName', TextType::class)
            ->add('recommendationDay', TextType::class)
            ->add('submit', SubmitType::class)
        ;
        $builder->get('recommendationDay')->addModelTransformer(new StringToDateTimeTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StockRecommendationData::class
        ]);
    }
}
