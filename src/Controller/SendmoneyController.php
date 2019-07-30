<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\PersistentObject;
use App\Repository\PersonneRepository;
use App\Repository\PartenaireRepository;
use App\Repository\CompteBancaireRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\TypeRepository;
use App\Repository\DepotRepository;
use App\Repository\UserRepository;
use App\Entity\CompteBancaire;
use App\Entity\Personne;
use App\Entity\Partenaire;
use App\Entity\Depot;
use App\Entity\Type;
use App\Entity\User;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
        $entityManager->persist($personne);
        $entityManager->flush();
        return new Response('Cette Personne a été ajouté');
    }
    /**
     * @Route("/lister_personne", name="lister_personne",methods={"GET"})
     */
    public function lister_personne(CompteBancaireRepository $PersonneRepository, SerializerInterface $serializer)
    {
        $PersonneRepository = $PersonneRepository->findAll();
        $data            = $serializer->serialize($PersonneRepository, 'json');
        return new Response($data, 200, []);
    }
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
        $partenaire->setPersonne($personne);
        $partenaire->setRaisonSociale($valeur->raison_sociale);
        $partenaire->setNinea($valeur->ninea);
        $partenaire->setStatus($valeur->status);
        $entityManager->persist($partenaire);
        $entityManager->flush();
        return new Response("le partenaire a été ajouté avec success");
    }


    /**
     * @Route("/listerpartenaire", name="listerpartenaire",methods={"GET"})
     */
    public function listerPartenaire(PartenaireRepository $partenaireRepository, SerializerInterface $serializer)
    {
        $partenaire = $partenaireRepository->findAll();
        $data       = $serializer->serialize($partenaire, 'json');
        return new Response($data, 200, []);
    }


    //=========================>ICI LE CODE QUI ME PERMET D'AJOUTER UN COMPTE BANCAIRE
    /**
     * @Route("/ajout_compte_bancaire", name="ajout_compte_bancaire")
     */
    public function ajoutcomptebancaire(Request $request)
    {
        $valeur          = json_decode($request->getContent());
        $entityManager   = $this->getDoctrine()->getManager();

        $partenaireRepo  = $this->getDoctrine()->getRepository(Partenaire::class);
        $partenaire      = $partenaireRepo->find($valeur->partenaire);

        $compte_bancaire = new CompteBancaire();

        $compte_bancaire->setPartenaire($partenaire);
        $compte_bancaire->setNumeroCompte($valeur->numero_compte);
        $entityManager->persist($compte_bancaire);
        $entityManager->flush();
        return new Response("le compte a été ajouté avec success");
    }
    /**
     * @Route("/lister_compte_bancaire", name="lister_compte_bancaire",methods={"GET"})
     */
    public function lister_compte_bancaire(CompteBancaireRepository $CompteBancaireRepository, SerializerInterface $serializer)
    {
        $compte_bancaire = $CompteBancaireRepository->findAll();
        $data            = $serializer->serialize($compte_bancaire, 'json');
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

        $personneRepo    = $this->getDoctrine()->getRepository(Personne::class);
        $personne        = $personneRepo->find($valeur->personne);

        $compteRepo      = $this->getDoctrine()->getRepository(CompteBancaire::class);
        $compte_bancaire = $compteRepo->find($valeur->compte_bancaire);

        $depot           = new Depot();
        $depot->setPersonne($personne);
        $depot->setMontant($valeur->montant);
        $depot->setCompteBancaire($compte_bancaire);
        $depot->setDateDepot(new \DateTime('2019-10-10'));
        $entityManager->persist($depot);
        $entityManager->flush();
        return new Response("Votre depot a été ajouté avec success");
    }
    /**
     * @Route("/lister_depot", name="lister_depot",methods={"GET"})
     */
    public function lister_depot(CompteBancaireRepository $DepotRepository, SerializerInterface $serializer)
    {
        $DepotRepository = $DepotRepository->findAll();
        $data            = $serializer->serialize($DepotRepository, 'json');
        return new Response($data, 200, []);
    }
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

    /**
     * @Route("/lister_user", name="lister_user",methods={"GET"})
     */
    public function lister_user(CompteBancaireRepository $UserRepository, SerializerInterface $serializer)
    {
        $UserRepository = $UserRepository->findAll();
        $data            = $serializer->serialize($UserRepository, 'json');
        return new Response($data, 200, []);
    }

    /**
     * @Route("/type/{id}", name="update_type", methods={"PUT"})
     */
    public function updatetype(Request $request, SerializerInterface $serializer, Type $type, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $typeUpdate = $entityManager->getRepository(Type::class)->find($type->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value) {
            if ($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set' . $name;
                $typeUpdate->$setter($value);
            }
        }
        $errors = $validator->validate($typeUpdate);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => 'Le téléphone a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }


    /**
     * @Route("/depot/{id}", name="update_depo", methods={"PUT"})
     */
    public function updatedepot(Request $request, SerializerInterface $serializer, Depot $depot, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $depotUpdate = $entityManager->getRepository(Depot::class)->find($depot->getId());
        $data = json_decode($request->getContent());
        foreach ($data as $key => $value) {
            if ($key && !empty($value)) {
                $name = ucfirst($key);
                $setter = 'set' . $name;
                $depotUpdate->$setter($value+ $depot->getMontant());
            }
        }
        $errors = $validator->validate($depotUpdate);
        if (count($errors)) {
            $errors = $serializer->serialize($errors, 'json');
            return new Response($errors, 500, [
                'Content-Type' => 'application/json'
            ]);
        }
        $entityManager->flush();
        $data = [
            'status' => 200,
            'message' => 'Le téléphone a bien été mis à jour'
        ];
        return new JsonResponse($data);
    }

}
