<?php

declare(strict_types=1);

namespace App\Services\Widgets;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class WidgetProcessorFactory
 * @package App\Services\Widgets
 */
class WidgetsProcessorFactory
{


    /**
     * @var WidgetsCollection
     */
    private $widgets;

    /**
     * @var RequestStack
     */
    private $requestStack;


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