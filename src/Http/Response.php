<?php

namespace Khoatran\CarForRent\Http;

class Response
{
    const HTTP_OK = 200;
    const HTTP_NOT_FOUND = 404;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_UNAUTHORIZED = 401;

    protected ?string $template = null;

    /**
     * @return string|null
     */
    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @param string|null $template
     */
    public function setTemplate(?string $template): void
    {
        $this->template = $template;
    }


    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * @param string|null $redirectUrl
     */
    public function setRedirectUrl(?string $redirectUrl): void
    {
        $this->redirectUrl = $redirectUrl;
    }

    protected ?string $redirectUrl = null;
    protected ?array $data = null;

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    protected int $statusCode;


    public function renderView($template, array $data = null): self
    {
        $this->setTemplate($template);
        if ($data != null) {
            $this->setData([...$data]);
        } else {
            $this->setData(null);
        }
        return $this;
    }

    public function redirect(string $url): self
    {
        $this->setRedirectUrl($url);
        return $this;
    }
}
