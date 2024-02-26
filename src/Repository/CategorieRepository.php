<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;

class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function add(Categorie $category, bool $flush = false): void
    {
        $this->getEntityManager()->persist($category);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categorie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param int $idPlaylist
     * @return array
     */
    public function findAllForOnePlaylist($idPlaylist): array
    {
        return $this->createQueryBuilderForPlaylist($idPlaylist)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

   /**
     * Retourne toutes les catégories triées sur un champ
     * @param type $champ
     * @param type $ordre
     * @param type $table
     * @return Categorie[]
     */
    public function findAllOrderBy($champ, $ordre): array{
            return $this->createQueryBuilder('c')
                    ->orderBy('c.'.$champ, $ordre)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @param int $idPlaylist
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function createQueryBuilderForPlaylist(int $idPlaylist)
    {
        return $this->createQueryBuilder('c')
            ->join('c.formations', 'f')
            ->join('f.playlist', 'p')
            ->where('p.id = :id')
            ->setParameter('id', $idPlaylist);
    }
}