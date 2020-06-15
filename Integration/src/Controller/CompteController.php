<?php

namespace App\Controller;
use App\Entity\Appareil;
use App\Entity\PropertySearch;
use App\Entity\Utilisateur;
use App\Form\PropertySearchType;
use App\Repository\UtilisateurRepository;
use App\Form\AppareilType;
use App\Form\UtilisateurType;
use App\Repository\AppareilRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use symfony\Component\HttpFoundation\RedirectResponse;
use symfony\Component\Routing\RouterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use symfony\component\HttpFoundation\Session\Flash\FlashBagInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * CompteController
 */
class CompteController extends AbstractController
{
    private $FlashMessage;
    private $entityManager;
    private $router;
    private $reposortry;
      /**
     * cette métthode affichera le detail de chaque appareil
     *
     * @param  mixed $id
     * @return void
     */
    /**
     * @Route("/compte/appareil/{id}", name="appareil_show")
    */    
  
    public function appareil($id){
        $reposortry =$this->getDoctrine()->getRepository(Appareil::class);
        $post=$reposortry->find($id);
        return $this->render('compte/appareil.html.twig',[
            'post'=>$post
            ]);

    }
     /**
     * cette méthode retourne le dashboard de l'utilisateur
     *
     * @param  Request $request
     * @param  EntityManager  $manager
     * @param  Repository $repository
     * @return void
     */
     /**
     * @Route("/dashboard", name="dashboard", methods={"GET","POST"})
     */    
   
    public function dashboard(Request $request,EntityManagerInterface $manager,AppareilRepository $repository){
     
        $appareil=new PropertySearch();
        $form=$this->createForm(PropertySearchType::class,$appareil);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $term =$appareil->getModele();
            $posts1=$repository
                           ->search($term,$this->getUser());
        } else{

        $posts1 = $this->getDoctrine()
        ->getRepository(Appareil::class)
        ->findBy(['utilisateur' => $this->getUser()]);
       
                        }              
           
        return $this->render('compte/home.html.twig',[
        'posts' => $posts1 ,
        'form' => $form->createView()

    ]);

    }
   
  /**
     * génération du fichier pdf pour la déclaration de vol
     *
     * @param  mixed $id
     * @return void
     */
    /**
     * @Route("/appareil/show/{id}", name="post_show")
    */
    public function show($id){
        $pdfOptions = new Options();
        $pdfOptions->set('defaultfont','Arial');
        $dompdf =new Dompdf($pdfOptions);
        $reposortry =$this->getDoctrine()->getRepository(Appareil::class);
        $post =$reposortry->find($id);
        $html =$this->renderView('compte/show.html.twig', [
            'post' => $post
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        $dompdf->stream("mypdf.pdf",[
            "Attachment"=> true
        ]);
        
    }
  
} 
