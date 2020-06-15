<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Appareil;
use App\Form\ModificationStatutType;
use Symfony\Component\HttpFoundation\Request;
/**
 * SaveUpdatesController
 */
class SaveUpdatesController extends AbstractController
{ /**
    * prend en charge le formulaire de modification  et enregistre les informations dans la base de données
    *
    * @param  Request $request
    * @param  mixed $id
    * @return void
    */
    /**
     * @Route("/modifierappareil/{id}", name="save_updates")
     */    
   
    public function saveUpdates(Request $request,$id)
    {   
        $appareil = new Appareil();
        $entityManager = $this->getDoctrine()->getManager();

             
                             
        $form = $this->createForm(ModificationStatutType::class, $appareil);
        $form->handleRequest($request);
        $statutFromData=$form["statut"]->getData();
         if($form->isSubmitted()&&$form->isValid()){
             
            if ( $statutFromData =="Vendu"){

            //requête vers la base de données afin de supprimer l'appareil si l'utilisateur le déclare vendu
                $appareil = $this->getDoctrine()
                                ->getRepository(Appareil::class)
                                ->find($id);
                //confirmation avant la suppression
            echo '<script>alert("cet appareil va être supprimé")</script>';             
             $entityManager->remove($appareil);
             $this->addFlash('success',  ' l\'appareil  a bien été supprimé de  la base de données');
    
            }
            // le statut est juste mis a jour dans les autres cas
            else {
                $appareil = $this->getDoctrine()
                                ->getRepository(Appareil::class)
                                ->find($id);
            $appareil->setStatut($statutFromData);
         
            $this->addFlash('success',  'le statut de l\'appareil  a bien été modifié dans la base de données');
            
    }
  
  
        }
        //redirection to the dashboard
        $entityManager->flush();
      
     
        return $this->redirectToRoute('dashboard');
       
    }
}
