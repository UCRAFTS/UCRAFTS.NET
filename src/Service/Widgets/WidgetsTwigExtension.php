<?php

declare(strict_types=1);

namespace App\Service\Widgets;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class WidgetTwigExtension
 * @package App\Service\Widget
 */
class WidgetsTwigExtension extends AbstractExtension
{

    /**
     * @var WidgetsProcessorFactory
     */
    private WidgetsProcessorFactory $factory;

    /**
     * WidgetTwigExtension constructor.
     * @param WidgetsProcessorFactory $factory
     */
    public function __construct(WidgetsProcessorFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('widget', [
                $this, 'renderWidget'
            ], [
                'is_safe' => [
                    'html'
                ]
            ]),
        ];
    }

    /**
     * @param string $alias
     * @param array $options
     * @return string
     */
    public function renderWidget(string $alias, array $options = []): string
    {
        return $this->factory->create($alias, $options)->process();
    }
}
