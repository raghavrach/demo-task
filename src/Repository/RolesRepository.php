<?php
namespace App\Repository;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class RolesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roles::class);
    }
    
   /**
     * Returns user items for given query params
     *
     * @param $params :: query params
     * @return object Users
     */
    public function getItems($params = array())
    {
        $q = $this->_em->createQueryBuilder()->select('R')->from(Roles::class, 'R');

        $id = isset($params['id'])?$params['id']:NULL;
        $email = isset($params['slug'])?$params['slug']:NULL;
        $orderBy = isset($params['orderBy'])?$params['orderBy']:array();

        $queryParams = array();

        if(is_array($id) && sizeof($id)>0)
        {
            $q->andWhere("R.id IN (:id)");
            $queryParams['id'] = $id;
        } else if(!empty($id))
        {
            $q->andWhere("R.id = :id");
            $queryParams['id'] = $id;
        }

        if(is_array($email) && sizeof($email)>0)
        {
            $q->andWhere("R.slug IN (:email)");
            $queryParams['email'] = $email;
        } else if(!empty($email))
        {
            $q->andWhere("R.slug = :email");
            $queryParams['email'] = $email;
        }

        if(sizeof($orderBy)>0)
        {
            foreach($orderBy as $oData)
            {
                $mode = empty($oData['mode'])?'ASC':$oData['mode'];
                $q->orderBy($oData['column'], $mode);
            }
        } else
        {
                $q->orderBy('R.name', 'ASC');
        }

        $q->setParameters($queryParams);
        return $q->getQuery()->getResult();
    }
    
    /**
     * Returns role item for given $slug
     *
     * @param $slug :: Role slug
     * @return Single role object. If not found returns false
     */
    public function getItemBySlug($slug)
    {
        if(empty($slug)){return false;}
        
        $role = $this->getItems(array('slug' => $slug));
        
        if(!$role){return false;}
        
        return $role[0];
    }
}