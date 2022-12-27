<?php 
namespace App\Repositories\User;

use App\Interfaces\User\UserRepositoryInterface;;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public $user;

    function __construct(User $user) {
	    $this->user = $user;
    }

    public function create(array $user): User
    {
        return $this->user->create($user);
    }

 

}