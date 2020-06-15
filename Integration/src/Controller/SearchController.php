<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\HomeSearchType;
use App\Entity\Appareil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
 /**
     * verifie la solvabilité de l'appareil
     *
     * @param  Request $request
     * @return void
     */
    /**
     * @Route("/", name="search")
     */    
   
    public function search(Request $request)
    {
        
        $appareil = new Appareil();
         $form = $this->createForm(HomeSearchType::class, $appareil);
         $form->handleRequest($request);
         $posts=array();
/* teste si le formulaire est soumis pour une recherche */
if($form->isSubmitted()&&$form->isValid()){
    if($form->get('imei')->getData() != null){
        $imei=$form->get('imei')->getData();
        //requête vers la base de données 
        /* si l'IMEI n'est pas null
         */
        $appareil=$this->getDoctrine()
        ->getRepository(Appareil::class)
        ->findOneBy(['imei' => $imei]);}
        
    elseif($form->get('mac')->getData() != null){
        $mac=$form->get('mac')->getData();
        $appareil=$this->getDoctrine()
        ->getRepository(Appareil::class)
        ->findOneBy(['mac' => $mac]);                          
    }

    if($appareil != null){
        if($appareil->getStatut()   !='vole'){
        $this->addFlash('success', 'L\'appareil  est '.$appareil->getStatut());
    }else{$this->addFlash('unsuccess', 'L\'appareil  est volé vous pourrez etre accusé de recel');}
    }
    else{
        $this->addFlash( 'unsuccess','L\'appareil n\'existe pas dans la base de donnée ');
    }


}
 
    return $this->render('compte/acceuil.html.twig', [
        'form' => $form->createView()
    ]);
}
    }
