<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamController
 * @package App\Controller\PublicPart
 */
class TeamController extends AbstractController
{

    /**
     * @Route("/p/team", name="team", methods="GET")
     * @Template("public/pages/team/index.html.twig")
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }
}
