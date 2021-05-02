<?php

declare(strict_types=1);

namespace App\Service\Widgets;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;
use RuntimeException;

/**
 * Class WidgetsCollection
 * @package App\Service\Widget
 */
class WidgetsCollection implements IteratorAggregate
{

    /**
     * @var iterable
     */
    private iterable $widgets;

    /**
     * WidgetsCollection constructor.
     * @param iterable $widgets
     */
    public function __construct(iterable $widgets)
    {
        $widgetsByAlias = [];

        /** @var WidgetsInterface $widget */
        foreach ($widgets as $widget) {
            $alias = $widget->getAlias();

            if (isset($widgetsByAlias[$alias])) {
                throw new RuntimeException('Widget with alias ' . $alias . ' already registered');
            }

            $widgetsByAlias[$alias] = $widget;
        }

        $this->widgets = $widgetsByAlias;
    }

    /**
     * @return iterable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->widgets);
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias)
    {
        if ( ! isset($this->widgets[$alias])) {
            throw new InvalidArgumentException('Widget with alias ' . $alias . ' not found');
        }

        return $this->widgets[$alias];
    }
}
