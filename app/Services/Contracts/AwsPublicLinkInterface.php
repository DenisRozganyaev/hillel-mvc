<?php

namespace App\Services\Contracts;

interface AwsPublicLinkInterface
{
    public static function generate(string $filePath): string;
}
