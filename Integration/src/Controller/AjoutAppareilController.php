<?php

namespace App\Controller;
use App\Entity\Appareil;
use App\Entity\Utilisateur;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpClient\HttpClient;
use App\Form\ProprieteAppareilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
//use Symfony\Component\HttpFoundation\Session\Session;

class AjoutAppareilController extends AbstractController
{

  /**
     * ajoute un appareil à la base de données
     *
     * @param  httpClient $client
     * @param  Request $request
     * @param  EntityManager $em
     * @return void
     */
    /**
     * @Route("/ajoutappareil", name="ajout_appareil" )
     */    
   
    public function ajoutAppareil(HttpClient $client,Request $request, EntityManagerInterface $em)
    { 
    // deserialisation du firewall
    $user1=$this->getUser();
  
         $appareil = new Appareil();
        
         $form = $this->createForm(ProprieteAppareilType::class, $appareil);
         $form->handleRequest($request);
         // traitement du formulaire apres verification de la validité
         if($form->isSubmitted()&&$form->isValid()){
            $modele = $form["modele"]->getData();
            $capacite = $form["capacite"]->getData();
            // creation de la requete vers eBay API
            $client = HttpClient::create();
            $caract='';
          try {  $response = $client->request('GET','https://open.api.ebay.com/shopping?callname=FindProducts&responseencoding=JSON&appid=Mamoudou-Projet20-PRD-fca7fae46-2023bc5a&siteid=0&version=967&QueryKeywords='.$modele.'-'.$capacite.'&MaxEntries=2');
            $json=$response->getContent();
            $json1=json_decode($json,true);
           
       
            // formatage des caractéristiques de l'appareil
              for ( $i=0;$i<sizeof($json1["Product"][0]["ItemSpecifics"]["NameValueList"]);$i++){
                if(is_array($json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i])){
                  if(is_array($json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i]["Value"])){
                    if($json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i]["Name"]=="Color"||$json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i]["Name"]=="Manufacturer Color"){$caract.='';
                    }else {
                      $caract.=$json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i]["Name"].'=';
                      for($j=0;$j<sizeof($json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i]["Value"]);$j++){ 
                        $caract .=$json1["Product"][0]["ItemSpecifics"]["NameValueList"][$i]["Value"][$j].';';
                  }
                    }      
                  }
                }
      }
              //enregistrement dans la base de données
            }catch(\Exception $e){
              // dans le cas ou la requete sur ebay leve une exception (technicals non trouvés)
              $appareil->setTechnicals("");
        };
              $appareil->setTechnicals ($caract);
              $appareil->setCreatedAt(new \DateTime('@'.strtotime(' now +2 hour')));
              
              $appareil->setUtilisateur($user1);
        
        try {
 
          $em->persist($appareil);
          // actually executes the queries (i.e. the INSERT query)
          $em->flush();
       } catch (\Exception $e) {
        
        }
            
        
   // redirection au  dashboard

        return $this->redirectToRoute('dashboard');
         }
         // si le formulaire n'est pas soumis (block else)
     return $this->render('ajout_appareil/ajoutAppareil.html.twig', [
           'form' => $form->createView()
        ]);
    
    }
 
}