<?php

namespace Afip\Planning\Models;

use Afip\Planning\Models\Traits\TraitConstructor;
use Afip\Planning\Models\Traits\TraitDelete;
use Afip\Planning\Models\Traits\TraitFlush;
use Afip\Planning\Models\Traits\TraitGetBy;

class Student
{
    /*
  _____             _  _
 |_   _|_ __  __ _ (_)| |_  ___
   | | | '__|/ _` || || __|/ __|
   | | | |  | (_| || || |_ \__ \
   |_| |_|   \__,_||_| \__||___/

    */

    use TraitConstructor;
    use TraitGetBy;
    use TraitFlush;
    use TraitDelete;

    /*
 __      __           _         _      _
 \ \    / /          (_)       | |    | |
  \ \  / /__ _  _ __  _   __ _ | |__  | |  ___  ___
   \ \/ // _` || '__|| | / _` || '_ \ | | / _ \/ __|
    \  /| (_| || |   | || (_| || |_) || ||  __/\__ \
     \/  \__,_||_|   |_| \__,_||_.__/ |_| \___||___/

     */

    /** @var int */
    protected $id;

    /** @var string */
    protected $lastName;

    /** @var string */
    protected $firstName;

    /** @var int */
    protected $nationalityId;

    /** @var int */
    protected $traineeshipId;

    /*
   ____        _    _                         __   ____         _    _
  / ___|  ___ | |_ | |_  ___  _ __  ___      / /  / ___|   ___ | |_ | |_  ___  _ __  ___
 | |  _  / _ \| __|| __|/ _ \| '__|/ __|    / /   \___ \  / _ \| __|| __|/ _ \| '__|/ __|
 | |_| ||  __/| |_ | |_|  __/| |   \__ \   / /     ___) ||  __/| |_ | |_|  __/| |   \__ \
  \____| \___| \__| \__|\___||_|   |___/  /_/     |____/  \___| \__| \__|\___||_|   |___/

    */

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     *
     * @return self
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     *
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return int
     */
    public function getNationalityId(): ?int
    {
        return $this->nationalityId;
    }

    /**
     * @param int $nationalityId
     *
     * @return self
     */
    public function setNationalityId(?int $nationalityId): self
    {
        $this->nationalityId = $nationalityId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTraineeshipId(): ?int
    {
        return $this->traineeshipId;
    }

    /**
     * @param int $traineeshipId
     *
     * @return self
     */
    public function setTraineeshipId(?int $traineeshipId): self
    {
        $this->traineeshipId = $traineeshipId;
        return $this;
    }
}
