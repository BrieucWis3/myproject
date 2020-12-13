<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use \App\Entity\PropertySearch;
use \App\Entity\Property;
use \App\Entity\Contact;
use \App\Notification\ContactNotification;
use \App\Form;
use \App\Form\PropertySearchType;
use \App\Form\ContactType;

class PropertyController extends AbstractController {

    /* création d'un repository pour l'entity Property : methode 2*/ 
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository=$repository;
        $this->em=$em;
    }

    /**Amen
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response //création d'un repository (methode 3) avec index(PropertyRepository $repository)
    {
        $search =new PropertySearch();
        $form=$this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        /*
        $search = new Search();
        $form=$this->createForm(Form\SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $searchData=$search->getText();
        }
        */
        $properties=$paginator->paginate(
            $this->repository->findAllVisibleQuery($search), //findAllVisibleQuery($searchData)
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('property/index.html.twig', [
            'properties' => $properties,
            'current_menu' => 'properties',
            //'search' => $search, intile ?
            'form' => $form->createView()
        ]);

        /* Exemple pour insérer un élément de l'entity en base
        $property=new Property();
        $property->setTitle('Mon premier bien')
                ->setPrice(200000)
                ->setRooms(4)
                ->setBedrooms(3)
                ->setDescription('Une petite description')
                ->setSurface(60)
                ->setFloor(4)
                ->setHeat(1)
                ->setCity('Lyon')
                ->setAddress('5 cours de Verdun Gensoul')
                ->setPostalCode(69002);

        $em=$this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();
        */
        /** création d'un repository pour l'entity Property : methode 1 */
        //$repository=$this-> getDoctrine()->getRepository(Property::class);
        //dump($repository);
        //
        //$property=$this->repository->find(1);//équivalent à findById(1)
        //ou findAll()
        // ou $property=$this->repository->findOneBy(['floor' => 4]);

        /*$property=$this->repository->findAllVisible();
        //$property[0]->setSold(true); // modification en direct de la valeur de solde
        $this->em->flush(); // insère une requête pour modifier la valeur de solde en base
        dump($property);
        return $this->render("property/index.html.twig", [
            'current_menu' => 'properties'
        ]);*/

    }

    /**
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug, Request $request, ContactNotification $notification): Response  // ou show($slug, $id)
    {
      /* création de l'instance du formulaire de contact */
        $contact=new Contact();
        $contact->setProperty($property);
        $form=$form=$this->createForm(ContactType::class, $contact);

      /* on vérifie si le nom du bien passé dans l'url est bien celui sélectionné*/
        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property.show', [
               'id' => $property->getId(),
               'slug' => $property->getSlug()
            ], 301);
        }

        /* création de l'instance du formulaire de contact */
          $contact=new Contact();
          $contact->setProperty($property);
          $form=$form=$this->createForm(ContactType::class, $contact);
          $form->handleRequest($request);

          /* traitement des informations envoyées par le formulaire de contact*/
          if($form->isSubmitted() && $form->isValid())
          {
              dump($contact);
              $notification->notify($contact);
              $this->addFlash('success', 'Votre message a bien été envoyé');
              return $this->redirectToRoute('property.show', [
                   'id' => $property->getId(),
                   'slug' => $property->getSlug()
                ]);
          }
        // $property=$this->repository->find($id); si première solution

      /* s'il n'y a pas d'erreur, on renvoi appel la vue show à laquelle on envoi les éléments de notre bien */
        return $this->render("property/show.html.twig", [
            //'current_menu' => 'properties',
            'property' => $property,
            'form' => $form->createView()
        ]);

    }
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
