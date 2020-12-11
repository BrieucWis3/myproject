<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Option;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'required' => false,
                'choice_label' => 'name',  // spécifie l'attribut de Option devant apparaitre dans le formulaire
                'multiple' => true      // plusieurs choix possibles
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('city', null, ['label' => 'Ville'])
            ->add('address')
            ->add('postal_code')
            ->add('sold')
            //->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

// on inverse les clés et valeurs du tableau de heat, ex : choices['Electrique'] = 0
    private function getChoices()
    {
        $choices= Property::HEAT;
        $output=[];
        foreach($choices as $k => $v)
        {
            $output[$v]=$k;
        }
        return $output;
    }
}
