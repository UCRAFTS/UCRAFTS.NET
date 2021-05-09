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

//    /**
//     * @Route("/p/rules/v1", name="pages.rules", methods="GET")
//     * @Template("public/pages/rules/v1.html.twig")
//     *
//     * @return array
//     */
//    public function v1(): array
//    {
//        return [];
//    }

    /**
     * @Route("/p/rules", name="pages.rules.new", methods="GET")
     * @Template("public/pages/rules/v2.twig")
     *
     * @return array
     */
    public function v2(): array
    {
        return [];
    }
}
