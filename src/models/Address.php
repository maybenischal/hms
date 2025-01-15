<?php


use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

use App\models\Auditable;

#[ORM\Entity]
#[ORM\Table(name: 'address')]
class Address extends Auditable{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    private string $name;

    #[ORM\Column(type: 'string')]
    private string $addressType;
}