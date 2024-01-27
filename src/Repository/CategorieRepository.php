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

    public function remove(Categorie $category, bool $flush = false): void
    {
        $this->getEntityManager()->remove($category);

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
     * @param string $nom Le nom de la catégorie à rechercher.
     * @return Categorie[] Liste des catégories correspondantes.
     */
    public function findByNom(string $nom): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere(['c.nom' => $nom])
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