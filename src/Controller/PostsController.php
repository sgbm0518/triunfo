<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * @Route("/registrar-posts", name="RegistrarPosts")
     */
    public function index(Request $request)
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser(); // Obtener al usuario loqueado, que esta actualmente logueado en mi sistema
            // $post->setUser($user); // editar el post, le estamos diciendo que edite el usuario, y el usuario es el que acabamos de obtener ($user)
            $em = $this->getDoctrine()->getManager(); // estas 3 lineas de codigo que estan siendo comentariadas estan guardando mi posts en la base de datos
            $em->persist($post);                      //
            $em->flush();                             //
            return $this->redirectToRoute('dashboard'); // retornar una redireccion.
        }
        return $this->render('posts/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
