<?php

namespace App\Entities;

use Illuminate\Contracts\Support\Arrayable;

class SampleEntry implements Arrayable
{
    private string $name;
    private array $values;
    private bool $result;
    private string $graphFileName;
    private string $graphBvsFileName;
    private string $sampleId;
    private \Ramsey\Uuid\UuidInterface $storageId;

    public function __construct()
    {
    }

    public static function fromArray($payload): self
    {
        $sample = new self();

        if(isset($payload['name'])) {
            $sample->setName($payload['name']);
        }

        if(isset($payload['values'])) {
            $sample->setValues($payload['values']);
        }

        if(isset($payload['result'])) {
            $sample->setResult($payload['result']);
        }

        if(isset($payload['graphFileName'])) {
            $sample->setGraphFileName($payload['graphFileName']);
        }

        if(isset($payload['graphBvsFileName'])) {
            $sample->setGraphBvsFileName($payload['graphBvsFileName']);
        }

        if(isset($payload['sampleId'])) {
            $sample->setId($payload['sampleId']);
        }

        if(isset($payload['storageId'])) {
            $sample->setStorageId($payload['storageId']);
        }

        return $sample;
    }

    public function getAlphaScore(): int
    {
        return $this->values[0];
    }

    public function getBetaScore(): int
    {
        return $this->values[1];
    }

    public function getGammaScore(): int
    {
        return $this->values[2];
    }

    public function getDeltaScore(): int
    {
        return $this->values[3];
    }

    public function getEpsilonScore(): int
    {
        return $this->values[4];
    }

    public function setValues(array $values): void
    {
        $this->values = $values;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setResult(bool $result): void
    {
        $this->result = $result;
    }

    public function setGraphFileName(string $graphFileName): void
    {
        $this->graphFileName = $graphFileName;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setGraphBvsFileName(string $getBvsGraph): void
    {
        $this->graphBvsFileName = $getBvsGraph;
    }

    public function setId(string $sampleId): void
    {
        $this->sampleId = $sampleId;
    }

    public function getId(): string
    {
        return $this->sampleId;
    }

    public function getResult(): bool
    {
        return $this->result;
    }

    public function getGraphFileName(): string
    {
        return $this->graphFileName;
    }

    public function getGraphBvsFileName(): string
    {
        return $this->graphBvsFileName;
    }

    public function setStorageId(\Ramsey\Uuid\UuidInterface $uuid): void
    {
        $this->storageId = $uuid;
    }

    public function getStorageId(): \Ramsey\Uuid\UuidInterface
    {
        return $this->storageId;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'values' => $this->values,
            'result' => $this->result,
            'graphFileName' => $this->graphFileName,
            'graphBvsFileName' => $this->graphBvsFileName,
            'sampleId' => $this->sampleId,
            'storageId' => $this->storageId,
        ];
    }
}
