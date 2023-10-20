<?php

namespace Shared\DTO\Files;

use Carbon\Carbon;

class CreateSyncHistoryDTO
{
    public ?string $hash;

    public ?string $filename;

    public Carbon $sync_at;

    /**
     * @param string|null $hash
     * @param string|null $filename
     * @return CreateSyncHistoryDTO
     */
    public function register(?string $hash, ?string $filename): self
    {
        $this->hash = $hash;
        $this->filename = $filename;
        $this->sync_at = Carbon::now();

        return $this;
    }
}
