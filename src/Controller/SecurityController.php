<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'inscription')]
    public function registration(Request $request,EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, MailerInterface $mailer)
    {
        $user = new User();
        // $password = 'test';
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $manager->persist($user);
            $manager->flush();
            // echo "sent"; die;
            $email = (new Email())
            ->from('hello@example.com')
            ->to('you@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');
    
           
                $mailer->send($email);
            
            
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig',
        ['form' => $form->createView()
        
    ]);
    }


    #[Route('/connexion', name: 'security_login')]
    public function login()
    {
        return $this->render('security/login.html.twig');

    }
    #[Route('/deconnexion', name: 'security_logout')]
    public function logout()
    {
        return $this->render('security/logout.html.twig');

    }
}
