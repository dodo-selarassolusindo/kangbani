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
 * Entity class for "produk" table
 */
#[Entity]
#[Table(name: "produk")]
class Produk extends AbstractEntity
{
    #[Id]
    #[Column(type: "integer", unique: true)]
    #[GeneratedValue]
    private int $id;

    #[Column(type: "string", nullable: true)]
    private ?string $kode;

    #[Column(type: "string", nullable: true)]
    private ?string $nama;

    #[Column(name: "kelompok_id", type: "integer", nullable: true)]
    private ?int $kelompokId;

    #[Column(name: "satuan_id", type: "integer", nullable: true)]
    private ?int $satuanId;

    #[Column(name: "satuan_id2", type: "integer", nullable: true)]
    private ?int $satuanId2;

    #[Column(name: "gudang_id", type: "integer", nullable: true)]
    private ?int $gudangId;

    #[Column(type: "float", nullable: true)]
    private ?float $minstok;

    #[Column(type: "float", nullable: true)]
    private ?float $minorder;

    #[Column(type: "integer", nullable: true)]
    private ?int $akunhpp;

    #[Column(type: "integer", nullable: true)]
    private ?int $akunjual;

    #[Column(type: "integer", nullable: true)]
    private ?int $akunpersediaan;

    #[Column(type: "integer", nullable: true)]
    private ?int $akunreturjual;

    #[Column(type: "float", nullable: true)]
    private ?float $hargapokok;

    #[Column(type: "float", nullable: true)]
    private ?float $p;

    #[Column(type: "float", nullable: true)]
    private ?float $l;

    #[Column(type: "float", nullable: true)]
    private ?float $t;

    #[Column(type: "float", nullable: true)]
    private ?float $berat;

    #[Column(name: "supplier_id", type: "integer", nullable: true)]
    private ?int $supplierId;

    #[Column(type: "integer", nullable: true)]
    private ?int $waktukirim;

    #[Column(type: "integer", nullable: true)]
    private ?int $aktif;

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

    public function getKelompokId(): ?int
    {
        return $this->kelompokId;
    }

    public function setKelompokId(?int $value): static
    {
        $this->kelompokId = $value;
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

    public function getSatuanId2(): ?int
    {
        return $this->satuanId2;
    }

    public function setSatuanId2(?int $value): static
    {
        $this->satuanId2 = $value;
        return $this;
    }

    public function getGudangId(): ?int
    {
        return $this->gudangId;
    }

    public function setGudangId(?int $value): static
    {
        $this->gudangId = $value;
        return $this;
    }

    public function getMinstok(): ?float
    {
        return $this->minstok;
    }

    public function setMinstok(?float $value): static
    {
        $this->minstok = $value;
        return $this;
    }

    public function getMinorder(): ?float
    {
        return $this->minorder;
    }

    public function setMinorder(?float $value): static
    {
        $this->minorder = $value;
        return $this;
    }

    public function getAkunhpp(): ?int
    {
        return $this->akunhpp;
    }

    public function setAkunhpp(?int $value): static
    {
        $this->akunhpp = $value;
        return $this;
    }

    public function getAkunjual(): ?int
    {
        return $this->akunjual;
    }

    public function setAkunjual(?int $value): static
    {
        $this->akunjual = $value;
        return $this;
    }

    public function getAkunpersediaan(): ?int
    {
        return $this->akunpersediaan;
    }

    public function setAkunpersediaan(?int $value): static
    {
        $this->akunpersediaan = $value;
        return $this;
    }

    public function getAkunreturjual(): ?int
    {
        return $this->akunreturjual;
    }

    public function setAkunreturjual(?int $value): static
    {
        $this->akunreturjual = $value;
        return $this;
    }

    public function getHargapokok(): ?float
    {
        return $this->hargapokok;
    }

    public function setHargapokok(?float $value): static
    {
        $this->hargapokok = $value;
        return $this;
    }

    public function getP(): ?float
    {
        return $this->p;
    }

    public function setP(?float $value): static
    {
        $this->p = $value;
        return $this;
    }

    public function getL(): ?float
    {
        return $this->l;
    }

    public function setL(?float $value): static
    {
        $this->l = $value;
        return $this;
    }

    public function getT(): ?float
    {
        return $this->t;
    }

    public function setT(?float $value): static
    {
        $this->t = $value;
        return $this;
    }

    public function getBerat(): ?float
    {
        return $this->berat;
    }

    public function setBerat(?float $value): static
    {
        $this->berat = $value;
        return $this;
    }

    public function getSupplierId(): ?int
    {
        return $this->supplierId;
    }

    public function setSupplierId(?int $value): static
    {
        $this->supplierId = $value;
        return $this;
    }

    public function getWaktukirim(): ?int
    {
        return $this->waktukirim;
    }

    public function setWaktukirim(?int $value): static
    {
        $this->waktukirim = $value;
        return $this;
    }

    public function getAktif(): ?int
    {
        return $this->aktif;
    }

    public function setAktif(?int $value): static
    {
        $this->aktif = $value;
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
