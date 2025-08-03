<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\{TextType, TextareaType, DateTimeType, FileType, SubmitType};
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

final class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
            'events' => $events
        ]);
    }

    #[Route('/event/new_event', name: 'app_new_event')]
    public function new_event(
        Request $request,EntityManagerInterface $em,SluggerInterface $slugger
    ): Response {
        $event = new Event();
        if (!$this->getUser()) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Création manuelle du formulaire
        $form = $this->createFormBuilder($event)
            ->add('title', TextType::class, [
                'label' => 'Titre de l’évènement',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le nom de l\'évènement'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'Le nom de l\'évènement'
                ]
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le nom de l\'évènement'
                ]
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le nom de l\'évènement'
                ]
            ])
            ->add('img', FileType::class, [
                'label' => 'Image',
                'mapped' => false, // car on gère le fichier nous-mêmes
                'required' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer l’évènement',
                'attr' => [
                    'class' => 'btn btn-success mt-5'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'image
            $imageFile = $form->get('img')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('event_images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l’upload de l’image.');
                }

                $event->setImg($newFilename); // setter conforme à ton entité
            }

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Évènement ajouté avec succès !');

            return $this->redirectToRoute('app_event');
        }

        return $this->render('event/add_new_event.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser(), // ✅ maintenant défini correctement
        ]);
    }
}

