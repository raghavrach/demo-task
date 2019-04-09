<?php
namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * User entity repository
 *
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }
    
    /**
     * Returns user items for given query params
     *
     * @param $params :: query params
     * @return object Users
     */
    public function getItems($params = array())
    {
        $q = $this->_em->createQueryBuilder()->select('U')->from('App\Entity\Users', 'U')
            ->join('U.role', 'R');

        $id = isset($params['id'])?$params['id']:NULL;
        $email = isset($params['email'])?$params['email']:NULL;
        $roleSlug = isset($params['roleSlug'])?$params['roleSlug']:NULL;
        $orderBy = isset($params['orderBy'])?$params['orderBy']:array();
        $return = isset($params['return'])?$params['return']:'result';

        $queryParams = array();

        if(is_array($id) && sizeof($id)>0)
        {
            $q->andWhere("U.id IN (:id)");
            $queryParams['id'] = $id;
        } else if(!empty($id))
        {
            $q->andWhere("U.id = :id");
            $queryParams['id'] = $id;
        }

        if(is_array($email) && sizeof($email)>0)
        {
            $q->andWhere("U.email IN (:email)");
            $queryParams['email'] = $email;
        } else if(!empty($email))
        {
            $q->andWhere("U.email = :email");
            $queryParams['email'] = $email;
        }

        if(is_array($roleSlug) && sizeof($roleSlug)>0)
        {
            $q->andWhere("R.slug IN (:roleSlug)");
            $queryParams['roleSlug'] = $roleSlug;
        } else if(!empty($roleSlug))
        {
            $q->andWhere("R.slug = :roleSlug");
            $queryParams['roleSlug'] = $roleSlug;
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
                $q->orderBy('U.name', 'ASC');
        }

        $q->setParameters($queryParams);
        switch($return)
        {
            case 'queryObject':
                return $q;
                break;
            case 'result':
            default:
                return $q->getQuery()->getResult();
                break;
        }
        
    }
    
    /**
     * Returns user item for given $email
     *
     * @param $email :: Email query param
     * @return Single user object. If not found returns false
     */
    public function getItemByEmail($email)
    {
        if(empty($email)){return false;}
        
        $user = $this->getItems(array('email' => $email));
        
        if(!$user){return false;}
        
        return $user[0];
    }
}