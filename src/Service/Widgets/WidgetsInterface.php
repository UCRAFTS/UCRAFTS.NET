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
    public function process(array $options = []): array;

    /**
     * @param array $data
     * @return string
     */
    public function render(array $data = []): string;

    /**
     * @return string
     */
    public function getAlias(): string;
}
