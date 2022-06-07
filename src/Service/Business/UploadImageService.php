<?php

namespace Khoatran\CarForRent\Service\Business;

use Aws\S3\S3Client;
use Khoatran\CarForRent\Exception\UploadFileException;

class UploadImageService
{
    /**
     * @param $file
     * @return mixed|null
     * @throws UploadFileException
     */
    public function upload($file): ?string
    {
        if (!move_uploaded_file($file["tmp_name"], $this->getFileName($file))) {
            throw new UploadFileException("Error: There was an error uploading your file.");
        }

        $filePath = $this->getFileName($file);

        $result = $this->uploadS3Service($filePath);
        return $result->get('ObjectURL');
    }

    private function uploadS3Service($filePath): \Aws\Result
    {
        $bucketName = getenv('S3_BUCKET_NAME');
        $bucketRegion = getenv('S3_BUCKET_REGION');

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $bucketRegion,
            'credentials' => ['key' => getenv('S3_ACCESS_KEY_ID'), 'secret' => getenv('S3_SECRET_ACCESS_KEY')]
        ]);
        $key = basename($filePath);
        $result = $s3Client->putObject([
            'Bucket' => $bucketName,
            'Key' => $key,
            'SourceFile' => $filePath,
        ]);
        unlink($filePath);
        return $result;
    }

    private function getFileName($file): string
    {
        $path = __DIR__ . "/../../../public/upload/";
        $filename = md5(date('Y-m-d H:i:s:u')) . $file["name"];
        return $path . $filename;
    }
}
