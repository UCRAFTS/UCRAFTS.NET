<?php

declare(strict_types=1);

namespace App\Widget\PublicPart\Team;

use App\Service\Widgets\WidgetsInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Driver\Exception as DriverException;

/**
 * Class TeamWidget
 * @package App\Widget\PublicPart\Team
 */
class TeamWidget implements WidgetsInterface
{

    /**
     * @var array
     */
    private const GROUPS = [
        'admin' => 'Администратор',
        'curator' => 'Куратор',
        'mainmoderator' => 'Главный модератор',
        'moderator' => 'Модератор',
        'helper' => 'Помощник',
        'builder' => 'Строитель'
    ];

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameterBug;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;


    /**
     * TeamWidget constructor.
     * @param Environment $twig
     * @param ParameterBagInterface $parameterBag
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        Environment $twig,
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $entityManager
    )
    {
        $this->twig = $twig;
        $this->parameterBug = $parameterBag;
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $options
     * @return array
     * @throws DBALException
     * @throws DriverException
     * @throws ParameterNotFoundException
     */
    public function process($options = []): array
    {
        return $this->getTeam();
    }

    /**
     * @return array
     * @throws DBALException
     * @throws DriverException
     */
    private function getTeam(): array
    {
        $list = [];
        $groups = [];
        $prevGroupMembers = [];

        foreach (self::GROUPS as $group => $title) {
            $groups[] = 'group.' . $group;
        }

        $query = '
            select
                u.realname, lpp.uuid, replace(lpup.permission, \'group.\', \'\') role
            from
                luckperms_user_permissions lpup
            left join
                luckperms_players lpp
            on
                lpp.uuid = lpup.uuid
            left join
                users u
            on
                u.username = lpp.username
            where
                lpup.permission IN (?)
        ';

        $connection = $this->entityManager->getConnection();
        $stmt = $connection->executeQuery($query, [$groups], [Connection::PARAM_STR_ARRAY]);
        $result = $stmt->fetchAllAssociative();

        if (!$result || empty($result)) {
            return $list;
        }

        foreach (self::GROUPS as $group => $title) {
            $members = [];

            foreach ($result as $row) {
                $role = $row['role'] ?? null;
                $user = $row['realname'] ?? null;
                $uuid = $row['uuid'] ?? null;

                if ($role === null || $user === null || $uuid === null) {
                    continue;
                }

                if ($row['role'] === $group) {
                    $members[] = [
                        'user' => $user,
                        'uuid' => $uuid
                    ];
                }
            }

            if (!empty($members)) {
                $list[] = [
                    'title' => $title,
                    'members' => $members
                ];
            }
        }

        foreach ($list as $g => $group) {
            foreach ($group['members'] as $m => $member) {
                foreach ($prevGroupMembers as $prevGroupMember) {
                    if ($prevGroupMember['uuid'] === $member['uuid']) {
                        unset($list[$g]['members'][$m]);
                    }
                }

                $prevGroupMembers[] = $member;
            }
        }

        return $list;
    }

    /**
     * @param null $data
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render($data = null): string
    {
        return $this->twig->render('public/widgets/team/team.html.twig', [
            'list' => $data
        ]);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'team';
    }
}
