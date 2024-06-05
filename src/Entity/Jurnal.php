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
 * Entity class for "jurnal" table
 */
#[Entity]
#[Table(name: "jurnal")]
class Jurnal extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "tipejurnal_id", type: "integer", nullable: true)]
    private ?int $tipejurnalId;

    #[Column(name: "period_id", type: "integer", nullable: true)]
    private ?int $periodId;

    #[Column(type: "datetime", nullable: true)]
    private ?DateTime $createon;

    #[Column(type: "string", nullable: true)]
    private ?string $keterangan;

    #[Column(name: "person_id", type: "integer", nullable: true)]
    private ?int $personId;

    #[Column(type: "string", nullable: true)]
    private ?string $nomer;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $value): static
    {
        $this->id = $value;
        return $this;
    }

    public function getTipejurnalId(): ?int
    {
        return $this->tipejurnalId;
    }

    public function setTipejurnalId(?int $value): static
    {
        $this->tipejurnalId = $value;
        return $this;
    }

    public function getPeriodId(): ?int
    {
        return $this->periodId;
    }

    public function setPeriodId(?int $value): static
    {
        $this->periodId = $value;
        return $this;
    }

    public function getCreateon(): ?DateTime
    {
        return $this->createon;
    }

    public function setCreateon(?DateTime $value): static
    {
        $this->createon = $value;
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

    public function getPersonId(): ?int
    {
        return $this->personId;
    }

    public function setPersonId(?int $value): static
    {
        $this->personId = $value;
        return $this;
    }

    public function getNomer(): ?string
    {
        return HtmlDecode($this->nomer);
    }

    public function setNomer(?string $value): static
    {
        $this->nomer = RemoveXss($value);
        return $this;
    }
}
