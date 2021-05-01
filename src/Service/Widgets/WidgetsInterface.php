<?php

declare(strict_types=1);

namespace App\Service\Widgets;

/**
 * Interface WidgetInterface
 * @package App\Service\Widget
 */
interface WidgetsInterface
{

    /**
     * @param array $options
     * @return array
     */
    public function process($options = []): array;

    /**
     * @param null $data
     * @return string
     */
    public function render($data = null): string;

    /**
     * @return string
     */
    public function getAlias(): string;
}
