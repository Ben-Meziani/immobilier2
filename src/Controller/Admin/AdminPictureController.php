<?php
namespace App\Controller\Admin;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController {

    /**
     * @Route("/{id}", name="admin.picture.delete")
     */
    public function delete(Picture $picture) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();
            $this->addFlash('success', 'Photo supprimée avec succès');
            return $this->redirectToRoute('admin.property.index');
    }

}
