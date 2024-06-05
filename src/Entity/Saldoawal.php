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
 * Entity class for "saldoawal" table
 */
#[Entity]
#[Table(name: "saldoawal")]
class Saldoawal extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(name: "periode_id", type: "integer", nullable: true)]
    private ?int $periodeId;

    #[Column(name: "akun_id", type: "integer", nullable: true)]
    private ?int $akunId;

    #[Column(type: "float", nullable: true)]
    private ?float $debet;

    #[Column(type: "text", nullable: true)]
    private ?string $kredit;

    #[Column(name: "user_id", type: "integer", nullable: true)]
    private ?int $userId;

    #[Column(type: "float", nullable: true)]
    private ?float $saldo;

    public function __construct()
    {
        $this->saldo = 0.000;
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

    public function getPeriodeId(): ?int
    {
        return $this->periodeId;
    }

    public function setPeriodeId(?int $value): static
    {
        $this->periodeId = $value;
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

    public function getKredit(): ?string
    {
        return HtmlDecode($this->kredit);
    }

    public function setKredit(?string $value): static
    {
        $this->kredit = RemoveXss($value);
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $value): static
    {
        $this->userId = $value;
        return $this;
    }

    public function getSaldo(): ?float
    {
        return $this->saldo;
    }

    public function setSaldo(?float $value): static
    {
        $this->saldo = $value;
        return $this;
    }
}
