<?php

declare(strict_types=1);

namespace App\Service\Ratings\Types;

use App\Helper\TimeHelper;
use App\Service\Ratings\RatingTypeInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Doctrine\DBAL\Driver\Exception as DDDException;
use Doctrine\DBAL\Exception as DDException;

/**
 * Class PlayTimeRatingType
 * @package App\Service\Ratings\Types
 */
class PlayTimeRatingType implements RatingTypeInterface
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * PlayTimeRatingType constructor.
     * @param EntityManagerInterface $entityManager
     * @param Environment $twig
     */
    public function __construct(EntityManagerInterface $entityManager, Environment $twig)
    {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function isSupport(string $type): bool
    {
        return $type === $this->getType();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'playtime';
    }

    /**
     * @param Request $request
     * @return Response
     * @throws DDDException
     * @throws DDException
     */
    public function render(Request $request): Response
    {
        $list = $this->getData($request);

        if (!empty($list)) {
            foreach ($list as $i => $item) {
                $list[$i]['play_time'] = TimeHelper::secondToHuman((int) $item['play_time']);
            }
        }

        return new Response($this->twig->render(sprintf('public/ratings/%s.html.twig', $this->getType()), [
            'list' => $list
        ]));
    }

    /**
     * @param Request $request
     * @return array
     * @throws DDDException
     * @throws DDException
     */
    public function getData(Request $request): array
    {
        $query = '
            select
                   p.play_time, u.realname
            from
                 playtime p
            left join
                luckperms_players lpp
            on
                lpp.uuid = p.player
            left join
                users u
            on
                u.username = lpp.username
            order by
                 p.play_time desc
            limit 10
        ';
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAllAssociative();
    }
}
