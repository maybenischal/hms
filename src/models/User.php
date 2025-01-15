<?php

namespace App\models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

use App\models\Auditable;


enum UserType: string {
    case INTERNAL = 'I';
    case EXTERNAL = 'E';
}


#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User extends Auditable {

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    private string $userName;

    #[ORM\Column(type: 'string')]
    private string $password;


    #[ORM\Column(type: "string", enumType: UserType::class)]
    private $userType;


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    public function getUserType(): UserType
    {
        return $this->userType;
    }

    public function setUserType(UserType $userType): self
    {
        $this->userType = $userType;
        return $this;
    }
}