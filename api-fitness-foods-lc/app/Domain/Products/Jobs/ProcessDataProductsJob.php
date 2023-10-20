<?php

namespace Domain\Products\Jobs;

use App\Domain\Products\Jobs\SaveDataProductsJob;
use Domain\Files\Actions\CreateSyncHistoryAction;
use Domain\Files\Interfaces\Repositories\ISyncRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shared\DTO\Files\CreateSyncHistoryDTO;
use Shared\Enums\StatusSyncHistoryEnum;

class ProcessDataProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(
        CreateSyncHistoryDTO    $createSyncHistoryDto,
        CreateSyncHistoryAction $createSyncHistoryAction
    )
    {
        try {
            $filenames = Storage::disk('downloads')->files('/js');

            foreach ($filenames as $filename) {
                $content = Storage::disk('downloads')->get($filename);

                $createSyncHistoryDto->register(get_hash_file('$content'), Str::after($filename, 'js/'), StatusSyncHistoryEnum::STARTED);
                $createSyncHistoryAction->execute($createSyncHistoryDto);

                $content = $this->getFirstHundred($content);

                Queue::pushOn('default', new SaveDataProductsJob($content));

            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
        }

    }

    private function getFirstHundred(string $content)
    {
        $arrayContent = [];
        $firstHundred = explode(PHP_EOL, $content);

        foreach ($firstHundred as $item) {
            $arrayContent[] =json_decode($item, true);

            if(count($arrayContent) === 100) break;
        }
        return $arrayContent;
    }
}
