<?php

declare(strict_types=1);

namespace BitPaySDK\Model\Invoice;

class InvoiceRefundAddresses
{
    protected string $type;
    protected string $date;
    protected ?int $tag;
    protected ?string $email;

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getTag(): ?int
    {
        return $this->tag;
    }

    public function setTag(?int $tag): void
    {
        $this->tag = $tag;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
