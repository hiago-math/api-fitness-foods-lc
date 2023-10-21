<?php

namespace Shared\DTO\Utils;

use Shared\DTO\DTOAbstract;

class PaginateDTO extends DTOAbstract
{
    /**
     * @var int
     */
    public int $page;

    /**
     * @var int
     */
    public int $per_page;

    /**
     * @param int $page
     * @param int $per_page
     * @return $this
     */
    public function register(int $page, int $per_page = 10): self
    {
        $this->page = $page;
        $this->per_page = $per_page;

        return $this;
    }
}
