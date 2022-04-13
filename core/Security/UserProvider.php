<?php

namespace Core\Security;

use App\Entity\CoreUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // TODO: Implement upgradePassword() method.
    }


    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof \App\Entity\CoreUser) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        $this->loadUserByIdentifier($user->getLogin());

        return $user;
        // Return a User object after making sure its data is "fresh".
        // Or throw a UserNotFoundException if the user no longer exists.
        // throw new \Exception('TODO: fill in refreshUser() inside ' . __FILE__);
    }

    public function supportsClass(string $class)
    {
        return \App\Entity\CoreUser::class === $class || is_subclass_of($class, \App\Entity\CoreUser::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $oneOrNullResult = $this->entityManager
            ->createQueryBuilder()
            ->select('cu')
            ->from(\App\Entity\CoreUser::class, 'cu')
            ->where('
            cu.state = :state 
            AND cu.login = :login 
            ')
            // AND cu.is_deleted = :is_deleted
            ->setParameters([
                'state'      => CoreUser::STATE_ON,
                'login'      => $identifier,
                // 'is_deleted' => (int)CoreUser::IS_DELETED_NO,
            ])
            ->getQuery()
            ->getOneOrNullResult();

        if (!$oneOrNullResult) {
            throw new UserNotFoundException("User {$identifier} not found or is disabled");
        }

        return $oneOrNullResult;
    }


}