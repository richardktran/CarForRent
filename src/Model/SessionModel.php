<?php

namespace Khoatran\CarForRent\Model;

class SessionModel
{
    protected string $sessID;
    protected string $sessData;
    protected int $sessLifetime;

    /**
     * @return string
     */
    public function getSessID(): string
    {
        return $this->sessID;
    }

    /**
     * @param string $sessID
     */
    public function setSessID(string $sessID): void
    {
        $this->sessID = $sessID;
    }

    /**
     * @return string
     */
    public function getSessData(): string
    {
        return $this->sessData;
    }

    /**
     * @param string $sessData
     */
    public function setSessData(string $sessData): void
    {
        $this->sessData = $sessData;
    }

    /**
     * @return int
     */
    public function getSessLifetime(): int
    {
        return $this->sessLifetime;
    }

    /**
     * @param int $sessLifetime
     */
    public function setSessLifetime(int $sessLifetime): void
    {
        $this->sessLifetime = $sessLifetime;
    }
}
