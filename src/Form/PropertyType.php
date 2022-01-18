<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'required' => true,
                'label' => 'Titre'
            ])
            ->add('description')
            ->add('surface')
            ->add('rooms', IntegerType::class,[
                'required' => true,
                'label' => 'Nombre de pièces'
            ])
            ->add('bedrooms', IntegerType::class,[
                'required' => true,
                'label' => 'Nombre de chambres'
            ])
            ->add('floor', IntegerType::class,[
                'required' => true,
                'label' => 'Nombre d\'étages'
            ])
            ->add('price')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Chauffage'
            ])
            ->add('pictureFiles', FileType::class, [
                'required' => false,
                'multiple' => true, 
                'label' => 'Chargement d\'images (jpeg uniquement)'
            ])
            ->add('city', TextType::class,[
                'required' => true,
                'label' => 'Ville'])
            ->add('address', TextType::class,[
                'required' => true,
                'label' => 'Adresse'])
            ->add('postal_code', IntegerType::class,[
                'required' => true,
                'label' => 'Code postal'
            ])
            ->add('sold')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices()
    {
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
