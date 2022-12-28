<?php 
namespace App\Repositories\User;


use App\Models\User;
use PhpParser\Node\Expr\Cast\Bool_;

class UserRepository
{
    public $user;

    function __construct(User $user) {
	    $this->user = $user;
    }

    public function create(array $user): User
    {
        return $this->user->create($user);
    }


    public function update(array $params, int $id): Bool
    {
        return $this->user->findOrFail($id)->updateOrFail($params);
    }

 

}