<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, [
                'help' => 'The ZIP/Postal code for your credit card\'s billing address.',
            ])
            ->add('contenu')

            ->add('user', EntityType::class, [
                "class" => User::class,
                "choice_label" => "email"
            ])
            ->add('imageFile', FileType::class, [
                "required" => false,
                // "mapped"    => false,
                "multiple" => true,
                "data_class"=> null,
                "attr" => [
                    "accept" => "image/png, image/jpeg, image/jpg",
                    "multiple" => true,
                ]
            ])
            ->add('fichierFile', FileType::class, [
                "required" => false,
                // "mapped"    => false,
                "multiple" => true,
                "data_class"=> null,
                "attr" => [
                    "accept" => "application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,
                    text/plain, application/pdf, image/*",
                    "multiple" => false,
                ]
            ])
            ->add('videoFile', FileType::class, [
                "required" => false,
                "multiple" => true,
                // "mapped"    => false,
                "data_class"=> null,
                "attr" => [
                    "accept" => "video/mp4",
                    "multiple" => true,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
