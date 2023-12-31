<?php

namespace Shared\DTO\Files;

use Carbon\Carbon;
use Shared\DTO\DTOAbstract;
use Shared\Enums\StatusSyncHistoryEnum;

class CreateSyncHistoryDTO extends DTOAbstract
{
    public ?string $hash;

    public ?string $filename;


    public ?string $status;

    public string $sync_at;

    /**
     * @param string|null $hash
     * @param string|null $filename
     * @return CreateSyncHistoryDTO
     */
    public function register(?string $hash, ?string $filename): self
    {
        $this->hash = $hash;
        $this->filename = $filename;
        $this->sync_at = Carbon::now()->format('Y-m-d H:i:s');
        $this->status = StatusSyncHistoryEnum::STARTED;

        return $this;
    }
}
