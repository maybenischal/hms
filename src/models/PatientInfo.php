<?php

use App\models\Address;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity]
#[ORM\Table(name: 'patient_info')]
class PatientInfo {

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string', name: 'blood_type')]
    private string $bloodType;

    #[ORM\Column(type: 'datetime', name: 'admitted_date', nullable: true)]
    private string $admittedDate;

    #[ORM\Column(type: 'datetime', name: 'discharged_date', nullable: true)]
    private string $dischargedDate;


    #[ORM\Column(type: 'integer', name: 'age', nullable: true)]
    private int $age;

    #[ORM\Column(type: 'integer', name: 'height', nullable: true)]
    private int $height;

    #[ORM\Column(type: 'integer', name: 'weight', nullable: true)]
    private string $weight;

    #[OneToOne(targetEntity: Address::class)]
    private Address $address;
}