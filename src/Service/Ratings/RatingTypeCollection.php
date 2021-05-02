<?php

declare(strict_types=1);

namespace App\Service\Ratings;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;

/**
 * Class RatingTypeCollection
 * @package App\Service\Ratings
 */
class RatingTypeCollection implements IteratorAggregate
{

    /**
     * @var array|iterable
     */
    public iterable $ratings;

    /**
     * RatingTypeInterface constructor.
     * @param iterable $ratings
     */
    public function __construct(iterable $ratings)
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
    public function getIterator()
    {
        return $this->ratings;
    }
}
