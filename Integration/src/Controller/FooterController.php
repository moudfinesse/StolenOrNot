<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    /**
     * @Route("/aPropos", name="aPropos")
     */
    public function aPropos()
    {
        return $this->render('footer/A propos.html.twig', [
            
        ]);
    }
     /**
     * @Route("/aide", name="aide")
     */
     public function aide()
     {
         return $this->render('footer/Aide.html.twig', [
             
         ]);
     }
      /**
     * @Route("/confidentiel", name="confidentiel")
     */
    public function confidentiel()
    {
        return $this->render('footer/Confidentiel.html.twig', [
            
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
     public function contact()
     {
         return $this->render('footer/Nous contacter.html.twig', [
             
         ]);
     }
}