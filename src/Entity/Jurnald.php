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
 * Entity class for "jurnald" table
 */
#[Entity]
#[Table(name: "jurnald")]
class Jurnald extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "jurnal_id", type: "integer", nullable: true)]
    private ?int $jurnalId;

    #[Column(name: "akun_id", type: "integer", nullable: true)]
    private ?int $akunId;

    #[Column(type: "float", nullable: true)]
    private ?float $debet;

    #[Column(type: "float", nullable: true)]
    private ?float $kredit;

    public function __construct()
    {
        $this->debet = 0;
        $this->kredit = 0;
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

    public function getJurnalId(): ?int
    {
        return $this->jurnalId;
    }

    public function setJurnalId(?int $value): static
    {
        $this->jurnalId = $value;
        return $this;
    }

    public function getAkunId(): ?int
    {
        return $this->akunId;
    }

    public function setAkunId(?int $value): static
    {
        $this->akunId = $value;
        return $this;
    }

    public function getDebet(): ?float
    {
        return $this->debet;
    }

    public function setDebet(?float $value): static
    {
        $this->debet = $value;
        return $this;
    }

    public function getKredit(): ?float
    {
        return $this->kredit;
    }

    public function setKredit(?float $value): static
    {
        $this->kredit = $value;
        return $this;
    }
}
