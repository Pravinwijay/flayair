<?php

namespace App\Form;

use App\Entity\Aeroport;
use App\Entity\Avion;
use App\Entity\Vol;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormError;

class VolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numVol')
            ->add('duree', null, [
                'widget' => 'single_text',
            ])
            ->add('heureDepart', null, [
                'widget' => 'single_text',
            ])
            ->add('heureArrive', null, [
                'widget' => 'single_text',
            ])
            ->add('nbPassagers')
            ->add('prixVol')
            ->add('avion', EntityType::class, [
                'class' => Avion::class,
                'choice_label' => 'modele',
            ])
            ->add('aeroportDepart', EntityType::class, [
                'class' => Aeroport::class,
                'choice_label' => 'nom_aeroport',
            ])
            ->add('aeroportArrive', EntityType::class, [
                'class' => Aeroport::class,
                'choice_label' => 'nom_aeroport',
            ]);

        // Écouteur pour valider les règles métiers
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData(); // Les données du formulaire
            $form = $event->getForm(); // Le formulaire lui-même

            // Vérification des aéroports
            if ($data->getAeroportDepart() === $data->getAeroportArrive()) {
                $form->get('aeroportArrive')->addError(new FormError(
                    'L’aéroport d’arrivée doit être différent de l’aéroport de départ.'
                ));
            }

            // Vérification des horaires
            if ($data->getHeureDepart() >= $data->getHeureArrive()) {
                $form->get('heureArrive')->addError(new FormError(
                    'L’heure d’arrivée doit être postérieure à l’heure de départ.'
                ));
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vol::class,
        ]);
    }
}
