<?php
/**
 * Created by PhpStorm.
 * User: Joani
 * Date: 16/02/14
 * Time: 12:34
 */

namespace Model\Users;


interface UserSpecification {

    public function isSatisfiedBy(User $user);

} 