<?php

namespace Commons\UsersBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class LoginRepository extends EntityRepository{

    public function getLike($app, $droitRole, $q){
        $mgr = $this->getEntityManager();
        $like = strtolower(str_replace(' ', '% ', $q)) . '%';
        $qr = $mgr->createQuery("select o from CommonsUsersBundle:Login o where o.id_application=?1 and lower(o.nom_complet) like ?2 and o.maxdroit >= ?3");
        $qr->setParameter(1, $app);
        $qr->setParameter(2, $like);
        $qr->setParameter(3, $droitRole);
        return $qr->getResult();
    }
}
