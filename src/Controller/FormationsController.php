<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController {

    private $formationRepository;
    
        private $categorieRepository;

    private const FORMATIONS_PATH = 'pages/formations.html.twig';
    private const FORMATION_PATH = 'pages/formation.html.twig';

    public function __construct(FormationRepository $formationRepository, CategorieRepository $categorieRepository) {
        $this->formationRepository = $formationRepository;
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("/formations", name="formations")
     * @return Response
     */
    public function index(): Response{
        $formations = $this->formationRepository->findAll();
        $categories = $this->categorieRepository->findAll();

       
        return $this->render(self::FORMATIONS_PATH, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/formations/tri/{champ}/{ordre}/{table}", name="formations.sort")
     * @param string $champ
     * @param string $ordre
     * @param string $table
     * @return Response
     */
    public function sort($champ, $ordre, $table = ""): Response{
        $formations = $this->formationRepository->findAllOrderBy($champ, $ordre, $table);
        $categories = $this->categorieRepository->findAll();

       
        
        return $this->render(self::FORMATIONS_PATH, [
            'formations' => $formations,
            'categories' => $categories
        ]);
    }

     /**
     * Récupère les enregistrements selon le $champ et la $valeur
     * Et selon le $champ et la $valeur si autre $table
     * @Route("/formations/recherche/{champ}/{table}", name="formations.findallcontain")
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        if($table !=""){
            $formations = $this->formationRepository->findByContainValueTable($champ, $valeur, $table);
        }else{
            $formations = $this->formationRepository->findByContainValue($champ, $valeur);
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::FORMATIONS_PATH, [
            'formations' => $formations,
            'categories' => $categories,
            'valeur' => $valeur,
            'table' => $table
        ]);
    }   

    /**
     * @Route("/formations/formation/{id}", name="formations.showone")
     * @param int $id
     * @return Response
     */
    public function showOne($id): Response{
        $formation = $this->formationRepository->find($id);

        
        return $this->render(self::FORMATION_PATH, [
            'formation' => $formation
        ]);        
    }
}