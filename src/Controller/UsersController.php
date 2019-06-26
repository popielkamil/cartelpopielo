<?php
// src/Controller/LuckyController.php
namespace App\Controller;
use App\Entity\Gang;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
class UsersController extends AbstractController
{

    /**
     * @Route("/ad", name="ad")
     */
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $product = new Users();

        $gang= $this->getDoctrine()->getRepository(Gang::class)->findAll();
        $form = $this->createFormBuilder([$product,$gang])
            ->add('name',TextType::class)
            ->add('role',TextType::class)
            ->add('level',TextType::class)
            ->add('gangs', EntityType::class, [
                'class' => Gang::class,
                'choices' => $this->getDoctrine()->getRepository(Gang::class)->findAll(),
            ])

            ->add('save',submitType::class,['label'=>'Add Gangsta'])
            ->getForm();

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid())
        {
            $product->setName($form->get('name')->getData());
            $product->setRole($form->get('role')->getData());
            $product->setLevel($form->get('level')->getData());
            $product->setGang($form->get('gangs')->getData());


            $em->persist($product);

            $em->flush();
            return $this->redirectToRoute('ad');
        }

        return $this->render('tasks/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}
