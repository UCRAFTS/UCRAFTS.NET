<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MapController
 * @package App\Controller\PublicPart
 */
class RulesController extends AbstractController
{

    /**
     * @Route("/p/rules", name="pages.rules", methods="GET")
     * @Template("public/pages/rules/index.html.twig")
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }
}
