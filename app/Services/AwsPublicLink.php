<?php

namespace App\Services;

use App\Services\Contracts\AwsPublicLinkInterface;
use Illuminate\Support\Facades\Storage;

class AwsPublicLink implements AwsPublicLinkInterface
{
    public static function generate(string $filePath): string
    {
        try {
            $s3 = Storage::disk('s3');
            $client = $s3->getDriver()->getAdapter()->getClient();
            $expiry = "+7 days";

            $cmd = $client->getCommand('GetObject', [
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $filePath,
                'ACL' => 'public-read'
            ]);

            $request = $client->createPresignedRequest($cmd, $expiry);

            return (string)$request->getUri();
        } catch (\Exception $exception) {
            logs()->warning("AwsPublicLink => " . $exception->getMessage());
        }

        return '';
    }
}
