<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class IndexController
 * @package App\Controller\PublicPart
 */
class IndexController extends AbstractController
{

    /**
     * @Route("/", name="index", methods="GET")
     * @Template("public/index.html.twig")
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }
}
