<?php

namespace App\Entities;

class SampleEntry
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
}
