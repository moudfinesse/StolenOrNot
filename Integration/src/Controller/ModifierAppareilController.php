<?php

namespace App\Controller;
use App\Entity\Appareil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ModificationStatutType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ModifierAppareilController
 */
class ModifierAppareilController extends AbstractController
{ /**
    * redirige vers la page de modification de l'appareil donné
    *
    * @param  Request $request
    * @param  EntityManager $em
    * @param  mixed $id
    * @return void
    */
    /**
     * @Route("/modification/{id}", name="modifier_appareil")
     */    
   
    public function modifier(Request $request, EntityManagerInterface $em ,$id)
    {
        $appareil = new Appareil();
         $form = $this->createForm(ModificationStatutType::class, $appareil);
         $form->handleRequest($request);
/* teste si la requête trouve bien un appareil et retourne ses infos pour la modification */
$existingAppareil = $this->getDoctrine()
        ->getRepository(Appareil::class)
        ->find($id);
    if ( $existingAppareil ){
return $this->render('modifier_appareil/modifier.html.twig', [
    'form' => $form->createView(),
    'appareil'=>$existingAppareil,
    'imei' =>$existingAppareil->getImei(),
    'type'=>$existingAppareil->getType(),
    'modele'=>$existingAppareil ->getModele(),
    'capacite'=>$existingAppareil ->getCapacite(),
    'description'=>$existingAppareil->getDescription(),
    'serial'=>$existingAppareil->getSerial(),
    'mac'=>$existingAppareil->getMac(),
]);
    //si la requête retourne un tableau vide
    } else {
    //  redirection to dashboard
    echo '<script>alert("the device successfully updated")</script>';
      return $this->redirectToRoute('dashboard');
    }
   
}
}
    
    

