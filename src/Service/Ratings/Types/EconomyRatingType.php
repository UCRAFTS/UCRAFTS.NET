<?php

declare(strict_types=1);

namespace App\Service\Ratings\Types;

use App\Service\Ratings\RatingTypeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EconomyRatingType
 * @package App\Service\Ratings\Types
 */
class EconomyRatingType implements RatingTypeInterface
{

    /**
     * @param string $type
     * @return bool
     */
    public function isSupport(string $type): bool
    {
        return $type === $this->getType();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'economy';
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function render(Request $request): Response
    {
        return new Response();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getData(Request $request): array
    {
        return [];
    }
}