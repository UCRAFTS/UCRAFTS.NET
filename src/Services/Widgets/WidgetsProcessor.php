<?php

declare(strict_types=1);

namespace App\Services\Widgets;

use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * Class WidgetsProcessor
 * @package App\Services\Widgets
 */
class WidgetsProcessor
{


    /**
     * @var WidgetsInterface
     */
    private $widget;

    /**
     * @var array
     */
    private $options;


    /**
     * WidgetsProcessor constructor.
     * @param WidgetsInterface $widget
     * @param array $options
     */
    public function __construct(WidgetsInterface $widget, array $options)
    {
        $this->widget = $widget;
        $this->options = $options;
    }


    /**
     * @return string
     */
    public function process(): string
    {
        return $this->getWidgetHtml();
    }


    /**
     * @return string
     */
    private function getWidgetHtml(): string
    {
        $data = $this->widget->process($this->options);

        return $this->widget->render($data);
    }
}