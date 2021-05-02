<?php

declare(strict_types=1);

namespace App\Service\Ratings;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface RatingTypeInterface
 * @package App\Service\Ratings
 */
interface RatingTypeInterface
{

    /**
     * @param string $type
     * @return bool
     */
    public function isSupport(string $type): bool;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param Request $request
     * @return Response
     */
    public function render(Request $request): Response;

    /**
     * @param Request $request
     * @return array
     */
    public function getData(Request $request): array;
}
