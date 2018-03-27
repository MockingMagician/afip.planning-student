<?php

namespace Afip\Planning\Models;

use Afip\Planning\Models\Traits\TraitConstructor;
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

    /** @var int */
    protected $studentId;

    /** @var int */
    protected $teacherId;

    /** @var int */
    protected $startDate;

    /** @var int */
    protected $endDate;

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
     * @return self
     */
    private function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    /**
     * @param int $studentId
     * @return self
     */
    public function setStudentId(int $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTeacherId(): ?int
    {
        return $this->teacherId;
    }

    /**
     * @param int $teacherId
     * @return self
     */
    public function setTeacherId(int $teacherId): self
    {
        $this->teacherId = $teacherId;
        return $this;
    }

    /**
     * @return int
     */
    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    /**
     * @param int $startDate
     * @return self
     */
    public function setStartDate(int $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getEndDate(): ?int
    {
        return $this->endDate;
    }

    /**
     * @param int $endDate
     * @return self
     */
    public function setEndDate(int $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}
