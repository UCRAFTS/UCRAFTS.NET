<?php

declare(strict_types=1);

namespace App\Services\Widgets;

use InvalidArgumentException;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class WidgetsCollection
 * @package App\Services\Widgets
 */
class WidgetsCollection implements IteratorAggregate
{


    /**
     * @var iterable
     */
    private $widgets;


    /**
     * WidgetsCollection constructor.
     * @param iterable $widgets
     */
    public function __construct($widgets)
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
     * @return array|iterable|Traversable
     */
    public function getIterator()
    {
        return $this->widgets;
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