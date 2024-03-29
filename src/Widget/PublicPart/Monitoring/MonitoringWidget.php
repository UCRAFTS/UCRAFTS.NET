<?php

declare(strict_types=1);

namespace App\Widget\PublicPart\Monitoring;

use App\Service\Widgets\WidgetsInterface;
use Doctrine\ORM\EntityManagerInterface;
use Predis\Client;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Driver\Exception as DriverException;

/**
 * Class MonitoringWidget
 * @package App\Widget\PublicPart\Monitoring
 */
class MonitoringWidget implements WidgetsInterface
{

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
     * @var Client
     */
    private Client $redis;


    /**
     * MonitoringWidget constructor.
     * @param Environment $twig
     * @param ParameterBagInterface $parameterBag
     * @param EntityManagerInterface $entityManager
     * @param Client $redis
     */
    public function __construct(
        Environment $twig,
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $entityManager,
        Client $redis
    )
    {
        $this->twig = $twig;
        $this->parameterBug = $parameterBag;
        $this->entityManager = $entityManager;
        $this->redis = $redis;
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
        return [
            'totalOnline' => $this->getTotalPlayers(),
            'allPlayers' => $this->getAllPlayers()
        ];
    }

    /**
     * @return int
     * @throws ParameterNotFoundException
     */
    private function getTotalPlayers(): int
    {
        $totalOnline = 0;

        try {
            $this->redis->select($this->parameterBug->get('redisOnlineServersIndex'));
            $proxyList = $this->redis->keys('*');

            foreach ($proxyList as $proxy) {
                $servers = $this->redis->hgetall($proxy);

                foreach (array_values($servers) as $serverOnline) {
                    $totalOnline += (int) $serverOnline;
                }
            }

            return $totalOnline;
        } catch (Throwable $e) {
            return $totalOnline;
        }
    }

    /**
     * @return int
     * @throws DriverException
     * @throws DBALException
     */
    private function getAllPlayers(): int
    {
        $query = 'SELECT COUNT(u.id) FROM users AS u';
        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($query);
        $stmt->execute();

        return abs($stmt->fetchOne());
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
        return $this->twig->render('public/widgets/monitoring/monitoring.html.twig', $data);
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'monitoring';
    }
}
