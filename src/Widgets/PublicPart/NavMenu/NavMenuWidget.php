<?php

declare(strict_types=1);

namespace App\Widgets\PublicPart\NavMenu;

use App\Services\Widgets\WidgetsInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class NavMenuWidget
 * @package App\Widgets\PublicPart\NavMenu
 */
class NavMenuWidget implements WidgetsInterface
{


    /**
     * @var Environment
     */
    private Environment $twig;


    /**
     * NavMenuWidget constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @param array $options
     * @return array
     */
    public function process($options = []): array
    {
        return [];
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
        return $this->twig->render('public/widgets/nav_menu/nav_menu.html.twig');
    }


    /**
     * @return string
     */
    public function getAlias(): string
    {
        return 'nav_menu';
    }
}