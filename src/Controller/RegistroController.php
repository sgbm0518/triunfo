<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request); // determino si el formulario fue enviado
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();//entity manager : Manejador de las entiedades, con este em, yo puedo persistir o guardar una entidad en la base de datos, eliminarla o editarla.
            $user->setBaneado(false);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($passwordEncoder->encodePassword($user, $form['password']->getData()));
            $em->persist($user);
            $em->flush();
            $this->addFlash('exito','Se ha registrado satisfactoriamente');
            return $this->redirectToRoute('registro');
        }
        return $this->render('registro/index.html.twig', [
            'controller_name' => 'Hola me llamo sergio',
            // 'mivariable'=>'eres excelente',
            'formulario'=> $form->createView() 
        ]);
       
    }
    
}
