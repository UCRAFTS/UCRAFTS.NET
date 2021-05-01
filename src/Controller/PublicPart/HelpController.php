<?php

declare(strict_types=1);

namespace App\Controller\PublicPart;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HelpController
 * @package App\Controller\PublicPart
 */
class HelpController extends AbstractController
{

    /**
     * @Route("/p/help", name="pages.help", methods="GET")
     * @Template("public/pages/help/index.html.twig")
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }
}
