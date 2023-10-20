<?php

namespace Shared\DTO\Files;

use Shared\DTO\DTOAbstract;
use Shared\Enums\StatusSyncHistoryEnum;

class UpdateSyncHistoryDTO extends DTOAbstract
{
    public string $hash;

    public string $status;

    /**
     * @param string $hash
     * @param string $status
     * @return UpdateSyncHistoryDTO
     */
    public function register(
        string $hash,
        string $status = StatusSyncHistoryEnum::PROCESSING
    ): self
    {
        $this->hash = $hash;
        $this->status = $status;

        return $this;
    }


}
