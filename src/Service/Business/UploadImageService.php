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
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            throw new UploadFileException('Invalid request method');
        }
        if (!isset($file) || $file["error"] != 0) {
            throw new UploadFileException('File upload does not exist');
        }
        $allowed = array(
            "jpg" => "image/jpg",
            "jpeg" => "image/jpeg",
            "gif" => "image/gif",
            "png" => "image/png"
        );
        $path = __DIR__ . "/../../../public/upload/";
        $filename = md5(date('Y-m-d H:i:s:u')) . $file["name"];
        $filetype = $file["type"];
        $filesize = $file["size"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            throw new UploadFileException("Error: Please select a valid file format.");
        }
        $maxsize = 10 * 1024 * 1024;

        if ($filesize > $maxsize) {
            throw new UploadFileException("Error: File size is larger than the allowed limit.");
        }
        // Validate type of the file
        if (!in_array($filetype, $allowed)) {
            throw new UploadFileException("Error: Please select a valid file format.");
        }


        if (move_uploaded_file($file["tmp_name"], $path . $filename)) {
            $file_Path = $path . $filename;
            $key = basename($file_Path);
            try {
                $result = $s3Client->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $key,
                    'SourceFile' => $file_Path,
                ]);

                return $result->get('ObjectURL');
            } catch (S3Exception $e) {
                return null;
            }
        } else {
            throw new UploadFileException("Error: There was an error uploading your file.");
        }
    }
}
