<?php

namespace OpenAI\Testing\Resources;

use OpenAI\Contracts\Resources\FilesContract;
use OpenAI\Resources\Files;
use OpenAI\Responses\Files\CreateResponse;
use OpenAI\Responses\Files\DeleteResponse;
use OpenAI\Responses\Files\ListResponse;
use OpenAI\Responses\Files\RetrieveResponse;
use OpenAI\Testing\Resources\Concerns\Testable;

final class FilesTestResource implements FilesContract
{
    use Testable;

    protected function resource(): string
    {
        return Files::class;
    }

    public function list(): ListResponse
    {
        return $this->record(__FUNCTION__);
    }

    public function retrieve(string $file): RetrieveResponse
    {
        return $this->record(__FUNCTION__, $file);
    }

    public function download(string $file): string
    {
        return $this->record(__FUNCTION__, $file);
    }

    public function upload(array $parameters): CreateResponse
    {
        return $this->record(__FUNCTION__, $parameters);
    }

    public function delete(string $file): DeleteResponse
    {
        return $this->record(__FUNCTION__, $file);
    }
}
