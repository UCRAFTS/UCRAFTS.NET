<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller\PublicPart
 */
class IndexController extends AbstractController
{

    /**
     * @Route("/", name="homepage", methods="GET")
     * @Template("public/index.html.twig")
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }
}