<?php

namespace Khoatran\CarForRent\Validator;


class ImageValidator extends FileValidator
{
    public function isImage(): self
    {
        if (!empty($this->errors[$this->name])) {
            return $this;
        }
        $allowed = array(
            "jpg" => "image/jpg",
            "jpeg" => "image/jpeg",
            "gif" => "image/gif",
            "png" => "image/png"
        );
        $ext = pathinfo($this->file["name"], PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed) || !in_array($this->file['type'], $allowed)) {
            $this->errors[$this->name] = "Please select a valid file format.";
        }

        return $this;
    }

    public function validateImage($image)
    {
        $isValidate = $this->name('image')->setFile($image)->required()->checkSize(10)->isImage();
        if ($this->isSuccess()) {
            return true;
        }
        return $this->getErrors();
    }
}
