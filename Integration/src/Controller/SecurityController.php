<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use App\Form\ResetPassType;
use App\Form\LoginType;
use App\Form\UtilisateurEditType;
use App\Form\ResetPasswordType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller ;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\Extension\Core\Type\SubmitType ;
use Symfony\Component\Form\Extension\Core\Type\TextType ;
use App\Repository\AppareilRepository;
use Symfony\Component\HttpFoundation\Session\Session;

/*
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\UtilisateurRepository;

use App\Repository\UtilisateurRepository as RepositoryUtilisateurRepository;




 */


class SecurityController extends AbstractController
{
  /**
   * @Route("/inscription", name = "security_registration")
   */

    public function registration(Request $request, EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder , \Swift_Mailer $mailer ){
        $user = new Utilisateur();

        $form =  $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // encodage  du mot de passe
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // génèration du token d'activation
            $user ->setActivationToken(md5(uniqid()));

            $manager->persist($user);
            $manager->flush();

          
             $message = (new \Swift_Message('Account Activation'))

           
                ->setFrom('moudholding@gmail.com')

          
                ->setTo($user->getEmail())

             // on crée le contenu 
                ->setBody($this->renderView(
                 'emails/activation.html.twig', ['token' => $user->getActivationToken()])
                 , 'text/html');

             // on envoie le mail
             $mailer->send($message);
                    
            return $this->redirectToRoute('security_login');

        }

        return $this->render('Security/registration.html.twig' ,[ 
            'form' => $form-> createView()
            ]);
    }
/**
     * connexion de l'utilisateur
     *
     * @param  Request $request
     * @return void
     */
    /**
     * @Route("/connexion", name= "security_login")
     */    
    
    public function login(Request $request)

    {    $user=new Utilisateur();
        $form = $this->createForm(LoginType::class, $user);
        $form->handleRequest($request);
        // traitement du formulaire apres verification de la validité
        if($form->isSubmitted()&&$form->isValid()){
               // var_dump($request->getSession());
           // return $this->redirect('/dasboard');
        }

        return $this->render('security/login.html.twig');
       
    }

  /**
     * @Route("/connexion", name= "success")
     */
     public function success()
     {
         return $this->render('security/registration.html.twig');
        
     }
 
    
    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){}


    /**
     * @Route("/activation/{token}", name = "activation")
     */
    public function activation($token, UtilisateurRepository $userRepo){

        // on vérifie si un utilisateur a ce token
        $user = $userRepo->findOneBy(['activation_token' => $token]);

        // si aucun utilisateur n existe avec ce token
        if(! $user){
            // Erreur 404
            throw $this->createNotFoundException('this user do not exist');
        }

        // on supprime le token
        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // on envoie un message flash
        $this->addFlash('message','you have successfully activated your account');

        // on retourne a la page d'acceuil
        return $this->redirectToRoute('dashboard');

    }
/**
     * gere l'oubli de mot de passe sur la page de connexion
     *
     * @param  Request $request
     * @param  Repository $userRepo
     * @param  Swift_Mailer $mailer
     * @return void
     */
    /**
     * @Route("/forgotten", name = "forgotten_password")
     */    
    
    public function forgettenPassword(Request $request, UtilisateurRepository $userRepo, \Swift_Mailer $mailer,
    TokenGeneratorInterface $tokenGenerator){

   
        $form = $this->createForm(ResetPassType::class);

       
        $form->handleRequest($request);

        // si le formulaire est valide
        if($form->isSubmitted() && $form->isValid()){
            
        
            $donnees = $form->getData();

            // on cherche si un utilisateur a cet email
            $user = $userRepo->findOneByEmail($donnees['email']);

            // si l'utilisateur n'existe pas 
            if(!$user){
                //envoie du message flush
                $this->addFlash('danger', 'this email do not exist');
               return  $this->redirectToRoute('security_login');
            }
            //  génèration du token 
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            }catch(\Exception $e){
                $this->addFlash('warnning', 'Error : ' . $e->getMessage());
                return $this->redirectToRoute('security_login');
            }

            // on génère l'url de réinitialisation de password
            $url = $this->generateUrl('reset_password', [ 'token' => $token],
        UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Account Activation'))

             // on attribue l'expediteur
                ->setFrom('mahmoudblack55@yahoo.fr')

            
                ->setTo($user->getEmail())
 
                ->setBody("<p> a reset request has been requested, click here :" . $url 
                 , 'text/html');

         
             $mailer->send($message);

         
             $this->addFlash('message', ' a reset email has been sent');

             return $this->redirectToRoute('security_login');
        }
             // on renvoie vers la page de demande de l'email
             return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
        
    }
/**
     * gère la modification du mot de passe du compte utilisateur sur la page connexion
     
     *
     * @param  Token $token
     * @param  Request $request
     * @param  Encoder $passwordEncoder
     * @return void
     */
    /**
     * @Route("/reset-pass/{token}", name ="reset_password")
     */
    public function reset($token, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        // recherche l'utilisateur avec le token fourni
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['reset_token' => $token]);

        if(!$user ){
            $this->addFlash('danger', 'token unknown');
            return $this->redirectToRoute('security_login');
        }

        if($request->isMethod('POST')){

            // on supprime le token
            $user->setResetToken(null);

            //encodage du mot de passe
            $hash = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'password successfully changed');
            return $this->redirectToRoute('security_login');
        }else{
            return $this->render('security/reset_password.html.twig', ['token'=> $token]);
        }
    }


/**
    * cette méthode modifiera le mot de passe de l'utilisateur 
    *connecté
    *
    * @param  Request $request
    * @param  Encoder $passwordEncoder
    * @return void
    */
    /**
   * @Route("/reset-password", name="Security_reset_password")
   */   
   public function resetPassword(Request $request,UserPasswordEncoderInterface $passwordEncoder)
   {
   
      $em = $this->getDoctrine()->getManager();
      $user = $this->getUser();
    
      $form = $this->createForm(ResetPasswordType::class, $user);
      
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
       
 
         $oldPassword = $request->request->get('reset_password')['oldPassword'];
     
         // Si l'ancien mot de passe est bon
         if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {
           
            $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
          //  dd($newEncodedPassword);
            $user->setPassword($newEncodedPassword);

            //$em->persist($user);
          

            $this->addFlash('notice', 'Votre mot de passe à bien été changé !');
            $em->flush();
            return $this->redirectToRoute('security_login');
         } else {
            $form->addError(new FormError('Ancien mot de passe incorrect'));
         }
      }
   
      return $this->render('security/resetPassword.html.twig', array(
      'form' => $form->createView(),
      ));
   }
    /**
    * cette méthode supprimera l'utilisateur 
    *
    * @param  Utilisateur $user
    * @return void
    */
   /**
   * @Route("/delete_user/{id}", name="delete_user")
   */   
   public function deleteUser(Utilisateur $user)
   {
      $em = $this->getDoctrine()->getManager();
      
      $currentUser = $this->getUser();

      if ($currentUser->getId() ==$user->getId()) {
         $session = $this->get('session');
         $session = new Session();
         $session->invalidate();
         $em->remove($user);
        
      }
      $em->flush();
      return $this->redirectToRoute('security_registration');
   }
 
/**
 * cette méthode modifiera les informations de l'utilisateur
 *
 * @param  Request $request
 * @param  EntityManager $manager
 * @param  Utilisateur $user
 * @return void
 */  
/**
 * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
 */
 
public function edit(Request $request, EntityManagerInterface $manager,UtilisateurRepository $user)
{
   $user=$this->getUser();
   $form = $this->createForm(UtilisateurEditType::class, $user);
   $form->handleRequest($request);

   if ($form->isSubmitted() && $form->isValid()) {
    
       $manager->flush();

        return $this->redirectToRoute('dashboard');
    }

    return $this->render('security/edit.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
}
   
     
}
