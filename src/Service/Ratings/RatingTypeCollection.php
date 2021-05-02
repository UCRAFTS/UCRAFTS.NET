<?php

declare(strict_types=1);

namespace App\Service\Ratings;

use IteratorAggregate;
use RuntimeException;
use Traversable;

/**
 * Class RatingTypeCollection
 * @package App\Service\Ratings
 */
class RatingTypeCollection implements IteratorAggregate
{

    /**
     * @var Traversable
     */
    private Traversable $ratings;

    /**
     * RatingTypeInterface constructor.
     * @param Traversable $ratings
     */
    public function __construct(Traversable $ratings)
    {
        $ratingTypes = [];

        /** @var RatingTypeInterface $rating */
        foreach ($ratings as $rating) {
            $type = $rating->getType();

            if (isset($ratingTypes[$type])) {
                throw new RuntimeException('Rating type ' . $type . ' already registered');
            }

            $ratingTypes[$type] = $rating;
        }

        $this->ratings = $ratings;
    }

    /**
     * @return iterable
     */
    public function getIterator(): iterable
    {
        return $this->ratings;
    }
}
