<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }


    /**
     * @Route("/contact", name="contact_page" )
     * @Method ({ "GET", "POST" })
     */
    public function contact( Request $request  ){
        $form = $this->createFormBuilder()
            ->add('from')
            ->add('subject')
            ->add('body', TextareaType::class)
            ->add('Send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() ){
            //Traitement de mail
            $data = $form->getData();

            $message = (new \Swift_Message($data['subject']))
            ->setFrom($data['from'])
            ->setTo('saidboutoudit@ewa.ma')
            ->setBody($data['body'], 'text/plain');

            $this->get('mailer')->send($message);
            
        }
        
        return $this->render('default/contact.html.twig', ['form' => $form->createView()]);
    }
}
