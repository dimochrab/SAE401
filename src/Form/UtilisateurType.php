<?php


namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                // Attribut placeholder pour le champ 'username'
                'attr' => ['placeholder' => 'Votre nom d\'utilisateur'],
                'required' => false, // Définissez selon vos besoins
            ])
            ->add('email', EmailType::class, [
                // Attribut placeholder pour le champ 'email'
                'attr' => ['placeholder' => 'Votre adresse email'],
                'required' => false, // Définissez selon vos besoins
            ])
            ->add('bio', TextareaType::class, [
                // Attribut placeholder pour le champ 'bio'
                'attr' => ['placeholder' => 'Votre bio'],
                'required' => false,
            ])
            // Ajoutez d'autres champs selon les besoins
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
