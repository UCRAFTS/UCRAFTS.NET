<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 * @package App\Controller\PublicPart
 */
class MapController extends AbstractController
{

    /**
     * @Route("/p/map", name="pages.map", methods="GET")
     * @Template("public/pages/map/index.html.twig")
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }
}