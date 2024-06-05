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
 * Entity class for "person" table
 */
#[Entity]
#[Table(name: "person")]
class Person extends AbstractEntity
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
    private ?string $kontak;

    #[Column(name: "type_id", type: "integer", nullable: true)]
    private ?int $typeId;

    #[Column(type: "string", nullable: true)]
    private ?string $telp1;

    #[Column(name: "matauang_id", type: "integer", nullable: true)]
    private ?int $matauangId;

    #[Column(type: "string", nullable: true)]
    private ?string $username;

    #[Column(type: "string", nullable: true)]
    private ?string $password;

    #[Column(type: "string", nullable: true)]
    private ?string $telp2;

    #[Column(type: "string", nullable: true)]
    private ?string $fax;

    #[Column(type: "string", nullable: true)]
    private ?string $hp;

    #[Column(type: "string", nullable: true)]
    private ?string $email;

    #[Column(type: "string", nullable: true)]
    private ?string $website;

    #[Column(type: "string", nullable: true)]
    private ?string $npwp;

    #[Column(type: "string", nullable: true)]
    private ?string $alamat;

    #[Column(type: "string", nullable: true)]
    private ?string $kota;

    #[Column(type: "string", nullable: true)]
    private ?string $zip;

    #[Column(name: "klasifikasi_id", type: "integer", nullable: true)]
    private ?int $klasifikasiId;

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

    public function getKontak(): ?string
    {
        return HtmlDecode($this->kontak);
    }

    public function setKontak(?string $value): static
    {
        $this->kontak = RemoveXss($value);
        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $value): static
    {
        $this->typeId = $value;
        return $this;
    }

    public function getTelp1(): ?string
    {
        return HtmlDecode($this->telp1);
    }

    public function setTelp1(?string $value): static
    {
        $this->telp1 = RemoveXss($value);
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

    public function getUsername(): ?string
    {
        return HtmlDecode($this->username);
    }

    public function setUsername(?string $value): static
    {
        $this->username = RemoveXss($value);
        return $this;
    }

    public function getPassword(): ?string
    {
        return HtmlDecode($this->password);
    }

    public function setPassword(?string $value): static
    {
        $this->password = RemoveXss($value);
        return $this;
    }

    public function getTelp2(): ?string
    {
        return HtmlDecode($this->telp2);
    }

    public function setTelp2(?string $value): static
    {
        $this->telp2 = RemoveXss($value);
        return $this;
    }

    public function getFax(): ?string
    {
        return HtmlDecode($this->fax);
    }

    public function setFax(?string $value): static
    {
        $this->fax = RemoveXss($value);
        return $this;
    }

    public function getHp(): ?string
    {
        return HtmlDecode($this->hp);
    }

    public function setHp(?string $value): static
    {
        $this->hp = RemoveXss($value);
        return $this;
    }

    public function getEmail(): ?string
    {
        return HtmlDecode($this->email);
    }

    public function setEmail(?string $value): static
    {
        $this->email = RemoveXss($value);
        return $this;
    }

    public function getWebsite(): ?string
    {
        return HtmlDecode($this->website);
    }

    public function setWebsite(?string $value): static
    {
        $this->website = RemoveXss($value);
        return $this;
    }

    public function getNpwp(): ?string
    {
        return HtmlDecode($this->npwp);
    }

    public function setNpwp(?string $value): static
    {
        $this->npwp = RemoveXss($value);
        return $this;
    }

    public function getAlamat(): ?string
    {
        return HtmlDecode($this->alamat);
    }

    public function setAlamat(?string $value): static
    {
        $this->alamat = RemoveXss($value);
        return $this;
    }

    public function getKota(): ?string
    {
        return HtmlDecode($this->kota);
    }

    public function setKota(?string $value): static
    {
        $this->kota = RemoveXss($value);
        return $this;
    }

    public function getZip(): ?string
    {
        return HtmlDecode($this->zip);
    }

    public function setZip(?string $value): static
    {
        $this->zip = RemoveXss($value);
        return $this;
    }

    public function getKlasifikasiId(): ?int
    {
        return $this->klasifikasiId;
    }

    public function setKlasifikasiId(?int $value): static
    {
        $this->klasifikasiId = $value;
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
