<?php

declare(strict_types=1);

namespace App\Helper;

/**
 * Class TimeHelper
 * @package App\Helper
 */
class TimeHelper
{

    /**
     * @param int $time
     * @return string|null
     */
    public static function secondToHuman(int $time): ?string
    {
        if ($time < 60) {
            return $time . ' с.';
        } else if ($time >= 60 && $time < (60 * 60)) {
            return round(($time / 60)) . ' м.';
        } else if ($time >= (60 * 60)) {
            return round((($time / 60) / 60)) . ' ч.';
        } else {
            return null;
        }
    }
}
