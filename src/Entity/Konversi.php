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
 * Entity class for "konversi" table
 */
#[Entity]
#[Table(name: "konversi")]
class Konversi extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "satuan_id", type: "integer", nullable: true)]
    private ?int $satuanId;

    #[Column(type: "float", nullable: true)]
    private ?float $nilai;

    #[Column(name: "satuan_id2", type: "integer", nullable: true)]
    private ?int $satuanId2;

    #[Column(type: "integer", nullable: true)]
    private ?int $operasi;

    #[Column(name: "id_FK", type: "integer")]
    private int $idFk;

    public function __construct()
    {
        $this->idFk = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getSatuanId(): ?int
    {
        return $this->satuanId;
    }

    public function setSatuanId(?int $value): static
    {
        $this->satuanId = $value;
        return $this;
    }

    public function getNilai(): ?float
    {
        return $this->nilai;
    }

    public function setNilai(?float $value): static
    {
        $this->nilai = $value;
        return $this;
    }

    public function getSatuanId2(): ?int
    {
        return $this->satuanId2;
    }

    public function setSatuanId2(?int $value): static
    {
        $this->satuanId2 = $value;
        return $this;
    }

    public function getOperasi(): ?int
    {
        return $this->operasi;
    }

    public function setOperasi(?int $value): static
    {
        $this->operasi = $value;
        return $this;
    }

    public function getIdFk(): int
    {
        return $this->idFk;
    }

    public function setIdFk(int $value): static
    {
        $this->idFk = $value;
        return $this;
    }
}
