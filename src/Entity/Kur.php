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
 * Entity class for "kurs" table
 */
#[Entity]
#[Table(name: "kurs")]
class Kur extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "matauang_id", type: "integer", nullable: true)]
    private ?int $matauangId;

    #[Column(type: "integer", nullable: true)]
    private ?int $tanggal;

    #[Column(type: "integer", nullable: true)]
    private ?int $nilai;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getMatauangId(): ?int
    {
        return $this->matauangId;
    }

    public function setMatauangId(?int $value): static
    {
        $this->matauangId = $value;
        return $this;
    }

    public function getTanggal(): ?int
    {
        return $this->tanggal;
    }

    public function setTanggal(?int $value): static
    {
        $this->tanggal = $value;
        return $this;
    }

    public function getNilai(): ?int
    {
        return $this->nilai;
    }

    public function setNilai(?int $value): static
    {
        $this->nilai = $value;
        return $this;
    }
}
