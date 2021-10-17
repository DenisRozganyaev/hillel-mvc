<?php

namespace App\Services\Contracts;

interface ImageServiceInterface
{
    public static function upload($image): string;
    public static function remove($image);
}
