<?php

namespace PHPMaker2024\prj_accounting\Entity;

use DateTime;
use DateTimeImmutable;
use DateInterval;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\DBAL\Types\Types;
use PHPMaker2024\prj_accounting\AbstractEntity;
use PHPMaker2024\prj_accounting\AdvancedSecurity;
use PHPMaker2024\prj_accounting\UserProfile;
use function PHPMaker2024\prj_accounting\Config;
use function PHPMaker2024\prj_accounting\EntityManager;
use function PHPMaker2024\prj_accounting\RemoveXss;
use function PHPMaker2024\prj_accounting\HtmlDecode;
use function PHPMaker2024\prj_accounting\EncryptPassword;

/**
 * Entity class for "satuan" table
 */
#[Entity]
#[Table(name: "satuan")]
class Satuan extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: "string", nullable: true)]
    private ?string $kode;

    #[Column(type: "string", nullable: true)]
    private ?string $nama;

    #[Column(type: "string", nullable: true)]
    private ?string $keterangan;

    #[Column(type: "integer", nullable: true)]
    private ?int $unitdasar;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getKode(): ?string
    {
        return HtmlDecode($this->kode);
    }

    public function setKode(?string $value): static
    {
        $this->kode = RemoveXss($value);
        return $this;
    }

    public function getNama(): ?string
    {
        return HtmlDecode($this->nama);
    }

    public function setNama(?string $value): static
    {
        $this->nama = RemoveXss($value);
        return $this;
    }

    public function getKeterangan(): ?string
    {
        return HtmlDecode($this->keterangan);
    }

    public function setKeterangan(?string $value): static
    {
        $this->keterangan = RemoveXss($value);
        return $this;
    }

    public function getUnitdasar(): ?int
    {
        return $this->unitdasar;
    }

    public function setUnitdasar(?int $value): static
    {
        $this->unitdasar = $value;
        return $this;
    }
}
