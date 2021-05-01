<?php

declare(strict_types=1);

namespace App\Service\Widgets;

/**
 * Class WidgetsProcessor
 * @package App\Service\Widget
 */
class WidgetsProcessor
{

    /**
     * @var WidgetsInterface
     */
    private WidgetsInterface $widget;

    /**
     * @var array
     */
    private array $options;

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
