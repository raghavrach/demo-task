<?php
namespace App\Repository;

use App\Entity\Groups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class GroupsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groups::class);
    }
    
    /**
     * Returns user items for given query params
     *
     * @param $params :: query params
     * @return object Users
     */
    public function getItems($params = array())
    {
        $q = $this->_em->createQueryBuilder()->select('G')->from('App\Entity\Groups', 'G');

        $id = isset($params['id'])?$params['id']:NULL;
        $name = isset($params['name'])?$params['name']:NULL;
        $isDeleted = isset($params['isDeleted'])?$params['isDeleted']:NULL;
        $orderBy = isset($params['orderBy'])?$params['orderBy']:array();

        $queryParams = array();

        if(is_array($id) && sizeof($id)>0)
        {
            $q->andWhere("G.id IN (:id)");
            $queryParams['id'] = $id;
        } else if(!empty($id))
        {
            $q->andWhere("G.id = :id");
            $queryParams['id'] = $id;
        }

        if(is_array($name) && sizeof($name)>0)
        {
            $q->andWhere("G.name IN (:name)");
            $queryParams['name'] = $name;
        } else if(!empty($name))
        {
            $q->andWhere("G.name = :name");
            $queryParams['name'] = $name;
        }

        if(is_array($isDeleted) && sizeof($isDeleted)>0)
        {
            $q->andWhere("G.isDeleted IN (:isDeleted)");
            $queryParams['isDeleted'] = $isDeleted;
        } else if(!is_null($isDeleted))
        {
            $q->andWhere("G.isDeleted = :isDeleted");
            $queryParams['isDeleted'] = $isDeleted;
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
                $q->orderBy('G.name', 'ASC');
        }

        $q->setParameters($queryParams);
        return $q->getQuery()->getResult();
    }
    
    /**
     * Returns group item for given $groupId
     *
     * @param $groupId :: Group id query param
     * @return Single group object. If not found returns false
     */
    public function getItemById($groupId)
    {
        if(empty($groupId)){return false;}
        $groupInfo = $this->getItems(array('id' => $groupId));
        
        if(!$groupInfo){return false;}
        return $groupInfo[0];
    }
}