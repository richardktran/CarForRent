<?php

namespace Khoatran\CarForRent\Service\Business;

use Aws\S3\Exception\S3Exception;
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
        $bucketName = getenv('S3_BUCKET_NAME');
        $bucketRegion = getenv('S3_BUCKET_REGION');

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $bucketRegion,
            'credentials' => ['key' => getenv('S3_ACCESS_KEY_ID'), 'secret' => getenv('S3_SECRET_ACCESS_KEY')]
        ]);
        $path = __DIR__ . "/../../../public/upload/";
        $filename = md5(date('Y-m-d H:i:s:u')) . $file["name"];

        if (move_uploaded_file($file["tmp_name"], $path . $filename)) {
            $file_Path = $path . $filename;
            $key = basename($file_Path);
            try {
                $result = $s3Client->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $key,
                    'SourceFile' => $file_Path,
                ]);
                unlink($path . $filename);
                return $result->get('ObjectURL');
            } catch (S3Exception $e) {
                return null;
            }
        } else {
            throw new UploadFileException("Error: There was an error uploading your file.");
        }
    }
}
