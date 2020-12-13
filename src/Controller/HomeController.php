<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \App\Repository\PropertyRepository;


class HomeController extends AbstractController {

    /** Gloire au Seigneur Yehoshoua
     * @var Environment
     */ 
   /* Inutile avec AbstractController
    * private $twig;

   public function __construct(Environment $twig)
   {
       $this->twig=$twig;
   } */

   /** Merci Seigneur Yehoushoua
    * @Route("/", name="home")
    * @param PropertyRepository $repository
    * @return Response
    */
   public function index(PropertyRepository $repository): Response
   {
       $properties=$repository->findLatest();
       //return new Response($this->twig->render('pages/home.html.twig'));
       return $this->render('pages/home.html.twig', [
           "properties" => $properties
       ]);
   }
   /**
    * page d'accueil
    * @Route("/hello-world", name="hello")
    */
   public function home()
   {
       return new Response('<h1>Yehoshoua</h1>');
   }

   /**
    * autre page
    * @Route("/hello-world/{name}", name="hello-name")
    */
   public function homeWithName(string $name)
   {
       return new Response('<h1>Yehoshoua te bénit mon frère '. $name . '</h1>');
   }
}
