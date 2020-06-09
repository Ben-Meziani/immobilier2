<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passEncoder)
    {
        $form = $this->createFormBuilder()
        ->add('username')
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'first_options' => ['label' => 'Password'],
            'second_options' =>['label' => 'Confirm Password']
        ])
        ->add('Soumettre', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-success float-right'
            ]
        ])
        ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            //dd($data);
            $user = new User();
            $user->setUsername($data['username']);
            $user->setPassword(
                $passEncoder->encodePassword($user, $data['password'])
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        
            return $this->redirect($this->generateUrl('app_login'));
        }
        return $this->render('register/index.html.twig', [
        'form' => $form->createView()
        ]);
    }
}