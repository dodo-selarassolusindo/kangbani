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
 * Entity class for "akun" table
 */
#[Entity]
#[Table(name: "akun")]
class Akun extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: "string", nullable: true)]
    private ?string $kode;

    #[Column(type: "string", nullable: true)]
    private ?string $nama;

    #[Column(name: "subgrup_id", type: "integer", nullable: true)]
    private ?int $subgrupId;

    #[Column(name: "user_id", type: "integer", nullable: true)]
    private ?int $userId;

    #[Column(name: "matauang_id", type: "integer", nullable: true)]
    private ?int $matauangId;

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

    public function getSubgrupId(): ?int
    {
        return $this->subgrupId;
    }

    public function setSubgrupId(?int $value): static
    {
        $this->subgrupId = $value;
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

    public function getMatauangId(): ?int
    {
        return $this->matauangId;
    }

    public function setMatauangId(?int $value): static
    {
        $this->matauangId = $value;
        return $this;
    }
}
