<?php

namespace Khoatran\CarForRent\Model;

class SessionModel
{
    protected string $sessID;
    protected string $sessData;
    protected int $sessLifetime;

    /**
     * @return string|null
     */
    public function getSessID(): string | null
    {
        return $this->sessID ?? null;
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
    public function getSessData(): string | null
    {
        return $this->sessData ?? null;
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
    public function getSessLifetime(): int | null
    {
        return $this->sessLifetime ?? null;
    }

    /**
     * @param int $sessLifetime
     */
    public function setSessLifetime(int $sessLifetime): void
    {
        $this->sessLifetime = $sessLifetime;
    }
}
