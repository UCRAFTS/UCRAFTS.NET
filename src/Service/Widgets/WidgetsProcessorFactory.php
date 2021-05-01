<?php

declare(strict_types=1);

namespace App\Service\Widgets;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class WidgetProcessorFactory
 * @package App\Service\Widget
 */
class WidgetsProcessorFactory
{

    /**
     * @var WidgetsCollection
     */
    private WidgetsCollection $widgets;

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;

    /**
     * WidgetProcessorFactory constructor.
     * @param WidgetsCollection $widgets
     * @param RequestStack $requestStack
     */
    public function __construct(WidgetsCollection $widgets, RequestStack $requestStack)
    {
        $this->widgets = $widgets;
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $alias
     * @param array $options
     * @return WidgetsProcessor
     */
    public function create(string $alias, array $options): WidgetsProcessor
    {
        $widget = $this->widgets->getByAlias($alias);

        return new WidgetsProcessor($widget, $options);
    }
}
