<?php

declare(strict_types=1);

namespace App\Widget\PublicPart\Monitoring;

use App\Service\Widgets\WidgetsInterface;
use Doctrine\ORM\EntityManagerInterface;
use MCServerStatus\MCPing;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Throwable;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Doctrine\DBAL\Exception as DBALException;
use Doctrine\DBAL\Driver\Exception as DriverException;
use xPaw\MinecraftPing;
use xPaw\MinecraftQuery;

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
     * MonitoringWidget constructor.
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
            $proxy = explode(',', $this->parameterBug->get('proxyServer'));
            array_map(function($item) use (&$totalOnline) {
                $ping = new MinecraftPing($item, 25565, 2);
                var_dump($ping->Query());
                $ping->Close();
//                $query = new MinecraftQuery();
//                $query->Connect($item, 25577);
//                dd($query->GetPlayers());
////                $totalOnline += $query->GetPlayers() ?? 0;
            }, $proxy);

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
