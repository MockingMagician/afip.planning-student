<?php

namespace Afip\Planning\Models;

use Afip\Planning\Models\Traits\TraitConstructor;
use Afip\Planning\Models\Traits\TraitFlush;
use Afip\Planning\Models\Traits\TraitGetBy;

class TeacherTraineeshipLabel
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

    /*
 __      __           _         _      _
 \ \    / /          (_)       | |    | |
  \ \  / /__ _  _ __  _   __ _ | |__  | |  ___  ___
   \ \/ // _` || '__|| | / _` || '_ \ | | / _ \/ __|
    \  /| (_| || |   | || (_| || |_) || ||  __/\__ \
     \/  \__,_||_|   |_| \__,_||_.__/ |_| \___||___/

     */

    /** @var string */
    protected $traineeshipLabel;

    /** @var int */
    protected $teacherId;

    /*
   ____        _    _                         __   ____         _    _
  / ___|  ___ | |_ | |_  ___  _ __  ___      / /  / ___|   ___ | |_ | |_  ___  _ __  ___
 | |  _  / _ \| __|| __|/ _ \| '__|/ __|    / /   \___ \  / _ \| __|| __|/ _ \| '__|/ __|
 | |_| ||  __/| |_ | |_|  __/| |   \__ \   / /     ___) ||  __/| |_ | |_|  __/| |   \__ \
  \____| \___| \__| \__|\___||_|   |___/  /_/     |____/  \___| \__| \__|\___||_|   |___/

    */

    /**
     * @return string
     */
    public function getTraineeshipLabel(): ?string
    {
        return $this->traineeshipLabel;
    }

    /**
     * @param string $traineeshipLabel
     * @return self
     */
    public function setTraineeshipLabel(string $traineeshipLabel): self
    {
        $this->traineeshipLabel = $traineeshipLabel;
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

    public static function getByTeacherId(int $id): array
    {
        return self::getBy('teacherId', $id);
    }
}
