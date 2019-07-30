<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Personne;
use App\Entity\Partenaire;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\CompteBancaire;
use App\Entity\Depot;
use App\Entity\Type;
use App\Entity\User;
use Doctrine\Common\Persistence\PersistentObject;
use App\Repository\PersonneRepository;
use App\Repository\PartenaireRepository;
use App\Repository\CompteBancaireRepository;
use App\Repository\TypeRepository;
use App\Repository\DepotRepository;
use App\Repository\UserRepository;
<<<<<<< HEAD
=======


>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
class SendmoneyController extends AbstractController
{
    /**
     * @Route("/sendmoney", name="sendmoney")
     */
    public function index()
    {
        return $this->render('sendmoney/index.html.twig', [
            'controller_name' => 'SendmoneyController',
        ]);
    }
    /**
     * @Route("/ajout_personne", name="ajout_personne")
     */
    public function ajout_personne(Request $request)
    {
        $valeur        = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $typeRepo      = $this->getDoctrine()->getRepository(Type::class);
        $type          = $typeRepo->find($valeur->type);
        $userRepo      = $this->getDoctrine()->getRepository(User::class);
        $user          = $userRepo->find($valeur->user);
        $personne      = new Personne();
        $personne->setPrenom($valeur->prenom);
        $personne->setNom($valeur->nom);
        $personne->setAdresse($valeur->adresse);
        $personne->setTelephone($valeur->telephone);
        $personne->setEmail($valeur->email);
        $personne->setType($type);
        $personne->setUser($user);
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
        $entityManager->persist($personne);
        $entityManager->flush();
        return new Response('Cette Personne a été ajouté');
    }
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    /**
     * @Route("/listerpersonne", name="listerpersonne",methods={"GET"})
     */
    public function listerPersonne(PersonneRepository $personneRepository, SerializerInterface $serializer)
    {
        $personne = $personneRepository->findAll();
        $data = $serializer->serialize($personne, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    //=========================>ICI LE CODE QUI ME PERMET D'AJOUTER UN PARTENAIRE
    /**
     * @Route("/ajout_partenaire", name="ajout_partenaire")
     */
    public function ajoutpartenaire(Request $request)
    {
        $valeur        = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $personneRepo  = $this->getDoctrine()->getRepository(Personne::class);
        $personne      = $personneRepo->find($valeur->personne);
        $partenaire    = new Partenaire();
        $partenaire->setRaisonSociale($valeur->raison_sociale);
        $partenaire->setNinea($valeur->ninea);
        $partenaire->setPersonne($personne);
        $entityManager->persist($partenaire);
        $entityManager->flush();
        return new Response("le partenaire a été ajouté avec success");
    }
<<<<<<< HEAD
=======


>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    /**
     * @Route("/listerpartenaire", name="listerpartenaire",methods={"GET"})
     */
    public function listerPartenaire(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        $partenaire = $partenaireRepository->findAll();
        $data       = $serializer->serialize($partenaire, 'json');
        return new Response($data, 200, []);
    }
<<<<<<< HEAD
=======


>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    //=========================>ICI LE CODE QUI ME PERMET D'AJOUTER UN COMPTE BANCAIRE
    /**
     * @Route("/ajout_compte_bancaire", name="ajout_compte_bancaire")
     */
    public function ajoutcomptebancaire(Request $request)
    {
        $valeur          = json_decode($request->getContent());
        $entityManager   = $this->getDoctrine()->getManager();
<<<<<<< HEAD
        $partenaireRepo  = $this->getDoctrine()->getRepository(Partenaire::class);
        $partenaire      = $partenaireRepo->find($valeur->partenaire);
        $compte_bancaire = new CompteBancaire();
=======

        $partenaireRepo  = $this->getDoctrine()->getRepository(Partenaire::class);
        $partenaire      = $partenaireRepo->find($valeur->partenaire);

        $compte_bancaire = new CompteBancaire();

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
        $compte_bancaire->setPartenaire($partenaire);
        $compte_bancaire->setNumeroCompte($valeur->numero_compte);
        $entityManager->persist($compte_bancaire);
        $entityManager->flush();
        return new Response("le compte a été ajouté avec success");
    }
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    /**
     * @Route("/lister_compte_bancaire", name="lister_compte_bancaire",methods={"GET"})
     */
    public function lister_compte_bancaire(CompteBancaireRepository $CompteBancaireRepository, SerializerInterface $serializer)
    {
        $compte_bancaire = $CompteBancaireRepository->findAll();
        $data = $serializer->serialize($compte_bancaire, 'json');
        return new Response($data, 200, []);
    }
    //=========================>ICI LE CODE QUI ME PERMET D'AJOUTER UN DEPOT DANS UN COMPTE BANCAIRE
    /**
     * @Route("/ajout_depot", name="ajout_depot")
     */
    public function ajoutdepot(Request $request)
    {
        $valeur          = json_decode($request->getContent());
        $entityManager   = $this->getDoctrine()->getManager();
<<<<<<< HEAD
        $personneRepo    = $this->getDoctrine()->getRepository(Personne      ::class);
        $personne        = $personneRepo->find($valeur->personne);
        $compteRepo      = $this->getDoctrine()->getRepository(CompteBancaire::class);
        $compte_bancaire = $compteRepo->find($valeur->compte_bancaire);
=======

        $personneRepo    = $this->getDoctrine()->getRepository(Personne      ::class);
        $personne        = $personneRepo->find($valeur->personne);

        $compteRepo      = $this->getDoctrine()->getRepository(CompteBancaire::class);
        $compte_bancaire = $compteRepo->find($valeur->compte_bancaire);

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
        $depot           = new Depot();
        $depot->setPersonne($personne);
        $depot->setMontant($valeur->montant);
        $depot->setCompteBancaire($compte_bancaire);
        $depot->setDateDepot(new \DateTime('2019-10-10'));
        $entityManager->persist($depot);
        $entityManager->flush();
        return new Response("Votre depot a été ajouté avec success");
    }
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    /**
     * @Route("/lister_depot", name="lister_depot",methods={"GET"})
     */
    public function lister_depot(CompteBancaireRepository $DepotRepository, SerializerInterface $serializer)
    {
        $DepotRepository = $DepotRepository->findAll();
        $data = $serializer->serialize($DepotRepository, 'json');
        return new Response($data, 200, []);
    }
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    /**
     * @Route("/ajout_Type", name="ajout_type")
     */
    public function ajout_type(Request $request)
    {
        $valeur        = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $type          = new Type();
        $type->setLibelleDuTypeDeRole($valeur->libelleDuTypeDeRole);
        $entityManager->persist($type);
        $entityManager->flush();
        return new Response('Le type a été ajouté');
    }
<<<<<<< HEAD
=======

>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
    /**
     * @Route("/ajout_user", name="ajout_user")
     */
    public function ajout_user(Request $request)
    {
        $valeur        = json_decode($request->getContent());
        $entityManager = $this->getDoctrine()->getManager();
        $user          = new User();
        $user->setUsername($valeur->username);
        $user->setPassword($valeur->password);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('Le type a été ajouté');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> a0435ad260804d14581692e55ca3425d539bff2b
