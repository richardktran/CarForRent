<?php

namespace Khoatran\CarForRent\Request;

interface RequestInterface
{
    public function validate(): bool;

    public function fromArray(array $requestBody): self;
}
