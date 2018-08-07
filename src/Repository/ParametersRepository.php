<?php

    namespace App\Repository;

    use App\Entity\Parameters;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;

    /**
     * Class ParametersRepository
     *
     * @method Parameters|null find($id, $lockMode = null, $lockVersion = null)
     * @method Parameters|null findOneBy(array $criteria, array $orderBy = null)
     * @method Parameters[]    findAll()
     * @method Parameters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     *
     * @package App\Repository
     */
    class ParametersRepository extends ServiceEntityRepository {

        /**
         * ParametersRepository constructor.
         *
         * @param RegistryInterface $registry
         */
        public function __construct(RegistryInterface $registry) {

            parent::__construct($registry, Parameters::class);
        }

        /**
         * Get data to edit
         *
         * @return mixed
         */
        public function findByEdits() {

            $qb = $this->createQueryBuilder('p');

            return $qb->where($qb->expr()->like('p.name', ':name1'))
                ->orWhere($qb->expr()->like('p.name', ':name2'))
                ->orWhere($qb->expr()->like('p.name', ':name3'))
                ->setParameter('name1', 'directory%')
                ->setParameter('name2', 'cache_%')
                ->setParameter('name3', 'js_%')
                ->getQuery()
                ->getResult();
        }
    }