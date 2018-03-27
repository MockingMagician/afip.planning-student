<?php

namespace Afip\Planning\Models\Traits;


trait TraitConstructor
{
    /*
   ____                    _                       _
  / ___| ___   _ __   ___ | |_  _ __  _   _   ___ | |_  ___   _ __  ___
 | |    / _ \ | '_ \ / __|| __|| '__|| | | | / __|| __|/ _ \ | '__|/ __|
 | |___| (_) || | | |\__ \| |_ | |   | |_| || (__ | |_| (_) || |   \__ \
  \____|\___/ |_| |_||___/ \__||_|    \__,_| \___| \__|\___/ |_|   |___/

     */

    /**
     * TraitConstructor constructor.
     *
     * @param array|null $associativeArrayValues
     */
    public function __construct(array $associativeArrayValues = null)
    {
        foreach ($associativeArrayValues as $variable => $value) {
            $method = 'set'.ucfirst($variable);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }
}
