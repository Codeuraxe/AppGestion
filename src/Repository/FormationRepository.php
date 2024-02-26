<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Formation>
 *
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    public function add(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Formation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Retourne toutes les formations triées sur un champ
     * @param string $champ
     * @param string $ordre
     * @param string $table si $champ dans une autre table
     * @return Formation[]
     */
    public function findAllOrderBy($champ, $ordre, $table = ""): array
    {
        if ($table === "") {
            return $this->createQueryBuilder('f')
                ->orderBy('f.' . $champ, $ordre)
                ->getQuery()
                ->getResult();
        } else {
            return $this->createQueryBuilder('f')
                ->join('f.' . $table, 't')
                ->orderBy('t.' . $champ, $ordre)
                ->getQuery()
                ->getResult();
        }
    }

    /**
     * Retourne toutes les formations triées sur un champ d'une autre table
     * @param string $champ
     * @param string $ordre
     * @param string $table Nom de la table
     * @return Formation[]
     */
    public function findAllOrderByTable($champ, $ordre, $table = ""): array
    {
        if ($table === "") {
            return $this->findAllOrderBy($champ, $ordre);
        } else {
            return $this->createQueryBuilder('f')
                ->join('f.' . $table, 't')
                ->orderBy('t.' . $champ, $ordre)
                ->getQuery()
                ->getResult();
        }
    }

    /**
 * Recherche les enregistrements dont un champ contient une valeur spécifiée.
 * Si la valeur est vide, retourne tous les enregistrements.
 * @param string $champ
 * @param string $valeur
 * @return Formation[]
 */
public function findByContainValue($champ, $valeur): array
{
    if ($valeur === "") {
        return $this->findAll();
    }
    
    return $this->createQueryBuilder('f')
        ->where('f.' . $champ . ' LIKE :valeur')
        ->orderBy('f.publishedAt', 'DESC')
        ->setParameter('valeur', '%' . $valeur . '%')
        ->getQuery()
        ->getResult();
}

/**
 * Recherche les enregistrements selon la valeur contenue dans un champ.
 * Si la valeur est vide, retourne tous les enregistrements.
 * Vérifie également si un champ contient une valeur spécifiée dans une autre table.
 * @param string $champ
 * @param string $valeur
 * @param string $table
 * @return Formation[]
 */
public function findByContainValueTable($champ, $valeur, $table): array
{
    if ($valeur === "") {
        return $this->findAll();
    }
    
    return $this->createQueryBuilder('f')
        ->join('f.' . $table, 't')
        ->where('t.' . $champ . ' LIKE :valeur')
        ->orderBy('f.publishedAt', 'DESC')
        ->setParameter('valeur', '%' . $valeur . '%')
        ->getQuery()
        ->getResult();
}

    /**
     * Retourne les n formations les plus récentes
     * @param int $nb
     * @return Formation[]
     */
    public function findAllLasted($nb): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.publishedAt', 'DESC')
            ->setMaxResults($nb)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne la liste des formations d'une playlist
     * @param int $idPlaylist
     * @return array
     */
    public function findAllForOnePlaylist($idPlaylist): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.playlist', 'p')
            ->where('p.id=:id')
            ->setParameter('id', $idPlaylist)
            ->orderBy('f.publishedAt', 'ASC')
            ->getQuery()
            ->getResult();
    }
}