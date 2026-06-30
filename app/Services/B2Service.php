<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;

class B2Service
{
    private $authData;
    private $buckets;  // Just declare the property without initialization

    public function __construct()
    {
        // Initialize buckets in constructor
        $this->buckets = [
            'bmpcdn90' => [
                'id' => env('B2_BUCKET_bmpcdn90_ID'),
                'name' => env('B2_BUCKET_bmpcdn90')
            ],
            'bmpcdn90original' => [
                'id' => env('B2_BUCKET_bmpcdn90original_ID'),
                'name' => env('B2_BUCKET_bmpcdn90original')
            ],
            'utbcdn' => [
                'id' => env('B2_BUCKET_utbcdn_ID'),
                'name' => env('B2_BUCKET_utbcdn')
            ]
        ];

        $this->authenticate();
    }

    private function authenticate()
    {
        $credentials = base64_encode(env('B2_KEY_ID') . ':' . env('B2_APPLICATION_KEY'));

        $response = $this->makeRequest(
            'https://api.backblazeb2.com/b2api/v2/b2_authorize_account',
            ['Authorization: Basic ' . $credentials]
        );

        $this->authData = $response;
        return $response;
    }

    private function makeRequest($url, $headers = [], $postData = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($postData) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new Exception('Request failed: ' . $response);
        }

        return json_decode($response, true);
    }

    public function uploadFile(UploadedFile $file, string $bucketType = 'original', string $folder = 'uploads')
    {
        if (!isset($this->buckets[$bucketType])) {
            throw new Exception('Invalid bucket type specified');
        }

        $bucket = $this->buckets[$bucketType];

        // Get upload URL for specific bucket
        $uploadUrlData = $this->makeRequest(
            $this->authData['apiUrl'] . '/b2api/v2/b2_get_upload_url',
            ['Authorization: ' . $this->authData['authorizationToken']],
            json_encode(['bucketId' => $bucket['id']])
        );

        $folder = trim($folder, '/');
        $fileName = $folder ? $folder . '/' . time() . '_' . $file->getClientOriginalName()
            : time() . '_' . $file->getClientOriginalName();

        $fileContents = file_get_contents($file->getRealPath());

        $uploadData = $this->makeRequest(
            $uploadUrlData['uploadUrl'],
            [
                'Authorization: ' . $uploadUrlData['authorizationToken'],
                'X-Bz-File-Name: ' . urlencode($fileName),
                'Content-Type: ' . $file->getMimeType(),
                'X-Bz-Content-Sha1: ' . sha1_file($file->getRealPath()),
            ],
            $fileContents
        );

        return [
            'url' => $this->authData['downloadUrl'] . '/file/' . $bucket['name'] . '/' . urlencode($fileName),
            'fileName' => $fileName,
            'fileId' => $uploadData['fileId'],
            'bucket' => $bucketType,
            'folder' => $folder
        ];
    }

    public function copyFile(string $sourceFileId, string $destinationBucketType, string $newFileName)
    {
        if (!isset($this->buckets[$destinationBucketType])) {
            throw new Exception('Invalid bucket type specified');
        }

        $destinationBucket = $this->buckets[$destinationBucketType];
        $url = $this->authData['apiUrl'] . '/b2api/v3/b2_copy_file';

        $postData = json_encode([
            'sourceFileId' => $sourceFileId,
            'destinationBucketId' => $destinationBucket['id'],
            'fileName' => $newFileName,
            'metadataDirective' => 'COPY' // Copy metadata from source
        ]);

        $headers = [
            'Authorization: ' . $this->authData['authorizationToken'],
            'Content-Type: application/json'
        ];
        $response = $this->makeRequest($url, $headers, $postData);

        return $response;
    }

    public function getFileInfo(string $fileId)
    {
        $url = $this->authData['apiUrl'] . '/b2api/v2/b2_get_file_info';

        $postData = json_encode(['fileId' => $fileId]);
        $headers = [
            'Authorization: ' . $this->authData['authorizationToken'],
            'Content-Type: application/json'
        ];

        $response = $this->makeRequest($url, $headers, $postData);
        return $response;
    }


    // public function copyFile(string $sourceFilePath, string $destinationFilePath, string $sourceBucketType = 'bmpcdn90', string $destinationBucketType = 'bmpcdn90')
    // {
    //     if (!isset($this->buckets[$sourceBucketType]) || !isset($this->buckets[$destinationBucketType])) {
    //         throw new Exception('Invalid source or destination bucket type specified');
    //     }

    //     $sourceBucket = $this->buckets[$sourceBucketType];
    //     $destinationBucket = $this->buckets[$destinationBucketType];

    //     $downloadUrl = $this->authData['downloadUrl'] . '/file/' . $sourceBucket['name'] . '/' . urlencode($sourceFilePath);
    //     $fileContents = file_get_contents($downloadUrl);

    //     if (!$fileContents) {
    //         throw new Exception('Failed to download file from source bucket');
    //     }

    //     $uploadUrlData = $this->makeRequest(
    //         $this->authData['apiUrl'] . '/b2api/v2/b2_get_upload_url',
    //         ['Authorization: ' . $this->authData['authorizationToken']],
    //         json_encode(['bucketId' => $destinationBucket['id']])
    //     );

    //     $uploadData = $this->makeRequest(
    //         $uploadUrlData['uploadUrl'],
    //         [
    //             'Authorization: ' . $uploadUrlData['authorizationToken'],
    //             'X-Bz-File-Name: ' . urlencode($destinationFilePath),
    //             'Content-Type: ' . mime_content_type($downloadUrl),
    //             'X-Bz-Content-Sha1: ' . sha1($fileContents),
    //         ],
    //         $fileContents
    //     );

    //     return [
    //         'url' => $this->authData['downloadUrl'] . '/file/' . $destinationBucket['name'] . '/' . urlencode($destinationFilePath),
    //         'fileName' => $destinationFilePath,
    //         'fileId' => $uploadData['fileId'],
    //         'bucket' => $destinationBucketType,
    //     ];
    // }
}