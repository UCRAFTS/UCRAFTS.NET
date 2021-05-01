<?php

declare(strict_types=1);

namespace App\Provider;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\DBAL\Driver\Exception as DDDException;
use Doctrine\DBAL\Exception as DDException;

/**
 * Class UserProvider
 * @package App\Security
 */
class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{


    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * UserProvider constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $username
     * @return UserInterface
     * @throws DDDException
     * @throws DDException
     */
    public function loadUserByUsername(string $username): ?UserInterface
    {
        $query = '
            select 
                u.realname, u.password, lpp.uuid 
            from 
                users u 
            left join 
                luckperms_players lpp 
            on 
                lpp.username = u.username 
            where u.username = ?
        ';

        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->bindValue(1, mb_strtolower($username));
        $stmt->execute();

        $result = $stmt->fetchAssociative();

        if (!$result || empty($result)) {
            return null;
        }

        $user = new User();
        $user->setLogin($result['realname']);
        $user->setPassword($result['password']);
        $user->setUuid($result['uuid']);

        return $user;
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     * @throws DDDException
     * @throws DDException
     */
    public function refreshUser(UserInterface $user): ?UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        $query = '
            select 
                u.realname, u.password, lpp.uuid 
            from 
                luckperms_players lpp 
            left join 
                users u
            on
                u.username = lpp.username
            where lpp.uuid = ?
        ';

        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->bindValue(1, mb_strtolower($user->getUuid()));
        $stmt->execute();

        $result = $stmt->fetchAssociative();

        if (!$result || empty($result)) {
            return null;
        }

        $user->setPassword($result['password']);
        $user->setLogin($result['realname']);

        return $user;
    }

    /**
     * @param string $class
     * @return bool
     */
    public function supportsClass(string $class): bool
    {
        return User::class === $class || is_subclass_of($class, User::class);
    }

    /**
     * @param UserInterface $user
     * @param string $newEncodedPassword
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {

    }
}
