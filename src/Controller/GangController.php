<?php
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
use \Doctrine\Common\Collections\ArrayCollection;
class GangController extends AbstractController
{
    /**
     * @Route("/adgang",name="adgang")
     */

    public function Request(Request $request)

    {

        $em = $this->getDoctrine()->getManager();
        $product = new Gang();


        $form = $this->createFormBuilder($product)
            ->add('name',TextType::class)
            ->add('description',TextType::class)
            ->add('users')



            ->add('save',submitType::class,['label'=>'Add Gang'])
            ->getForm();

        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid())
        {
            $product->setName($form->get('name')->getData());
            $product->setDescription($form->get('description')->getData());
            foreach ($form->get('users')->getData() as $item) {
                $product->addUser($item);
            }


            $em->persist($product);

            $em->flush();
            return $this->redirectToRoute('adgang');
        }

        return $this->render('tasks/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }




}