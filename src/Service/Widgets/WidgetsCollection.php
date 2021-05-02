<?php

declare(strict_types=1);

namespace App\Service\Widgets;

use InvalidArgumentException;
use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class WidgetsCollection
 * @package App\Service\Widget
 */
class WidgetsCollection implements IteratorAggregate
{

    /**
     * @var Traversable
     */
    private Traversable $widgets;

    /**
     * WidgetsCollection constructor.
     * @param Traversable $widgets
     */
    public function __construct(Traversable $widgets)
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

        $this->widgets = $widgets;
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return $this->widgets;
    }

    /**
     * @param $alias
     * @return mixed
     */
    public function getByAlias($alias): WidgetsInterface
    {
        /** @var WidgetsInterface $widget */
        foreach ($this->getIterator() as $widget) {
            if ($widget->getAlias() === $alias) {
                return $widget;
            }
        }

        throw new InvalidArgumentException('Widget with alias ' . $alias . ' not found');
    }
}
