<?php

namespace App\models;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

/**
 * This class is used as base class to include audit properties for 
 * all the classes
 */

#[ORM\MappedSuperclass]
abstract class Auditable
{

    #[ORM\Column(type:'string', name: 'created_by')]
    private string $createdBy;

    #[ORM\Column(type:'string', name: 'updated_by')]
    private string $updatedBy;
    
    #[ORM\Column(type: 'datetime_immutable', name: 'created_at')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable', name:'updated_at', nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: 'datetime_immutable', name:'deleted_at', nullable: true)]
    private ?DateTimeImmutable $deletedAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->createdBy = 'nischal';
        $this->updatedBy = 'nischal';
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(DateTimeImmutable $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    public function softDelete(): void
    {
        $this->deletedAt = new DateTimeImmutable();
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}
