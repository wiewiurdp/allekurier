<?php

declare(strict_types=1);

namespace App\Core\User\Application\Query\GetInactiveUsersEmail;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetInactiveUsersEmailHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ){}

    /**
     * @return UserDTO[]
     */
    public function __invoke(GetInactiveUsersEmailQuery $query): array
    {
        $users = $this->userRepository->getInactiveUsers();

        return array_map(function (User $user) {
            return new UserDTO(
                $user->getId(),
                $user->getEmail(),
            );
        }, $users);
    }
}
