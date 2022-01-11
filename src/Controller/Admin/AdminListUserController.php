<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 /**
     * @Route("/admin/list", name="admin_list_")
     */
class AdminListUserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function userList(UserRepository $users)
    {
        return $this->render('admin_list_user/user.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

/**
 * @Route("/edit_user/{id}", name="edit_user")
 */
public function editUser(User $user, Request $request)
{
    $form = $this->createForm(EditUserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('message', 'Utilisateur modifié avec succès');
        return $this->redirectToRoute('admin_list_user');
    }
    return $this->render('admin_list_user/edituser.html.twig', [
        'userForm' => $form->createView(),
    ]);
}
}
