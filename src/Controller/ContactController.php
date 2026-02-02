<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\ContactType;
use App\Class\Contact;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(MailerInterface $mailer, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // contenu du message
            $messageContent = sprintf(
                "Nom: %s\nEmail: %s\n\nMessage:\n%s",
                $contact->getFirstName(),
                $contact->getLastName(),
                $contact->getEmail(),
                $contact->getMessage()
            );
            // envoi le mail
            $email = (new Email())
            ->from('contact@gallery.com')
            ->replyTo($contact->getEmail())
            ->to('admin@gallery.com')
            ->subject($contact->getSubject())
            ->text($messageContent);
            
            $mailer->send($email);
            
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}