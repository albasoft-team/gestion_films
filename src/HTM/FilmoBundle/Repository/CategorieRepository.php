<?php

namespace HTM\FilmoBundle\Repository;

/**
 * CategorieRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->createQueryBuilder("p")
            ->select("p")
            ->orderBy("p.nom","ASC")
            ->getQuery()
            ->getResult();
    }
}
