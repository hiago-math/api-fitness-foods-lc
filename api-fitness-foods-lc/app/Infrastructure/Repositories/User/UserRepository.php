<?php

namespace Infrastructure\Repositories\User;

use Domain\User\Interfaces\Repositories\IUserRepository;
use Infrastructure\Models\User;
use Infrastructure\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository implements IUserRepository
{
    public function __construct()
    {
        parent::__construct(User::class);
    }
}
