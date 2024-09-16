<?php

namespace SonarSoftware\CustomerPortalFramework\Models;

use InvalidArgumentException;

class Account
{
    private $accountID;
    private $name;
    private $line1;
    private $city;
    private $state;
    private $zip;
    private $country;

    /**
     * Account constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->storeInput($values);
    }

    /**
     * Get the account ID.
     * @return mixed
     */
    public function getAccountID()
    {
        return $this->accountID;
    }

    /**
     * Get the name.
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the address line 1.
     * @return mixed
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * Get the city.
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get the state.
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the zip code.
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Get the country.
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set the account ID.
     * @param $accountID
     * @return void
     */
    public function setAccountID($accountID): void
    {
        if (trim($accountID) === null)
        {
            throw new InvalidArgumentException("You must supply an account ID.");
        }

        if (!is_numeric($accountID))
        {
            throw new InvalidArgumentException("Account ID must be numeric.");
        }
        $this->accountID = intval($accountID);
    }

    /**
     * Set the name.
     * @param $name
     * @return void
     */
    public function setName($name): void
    {
        if (trim($name) === null)
        {
            throw new InvalidArgumentException("You must supply a name.");
        }
        $this->name = $name;
    }

    /**
     * Set the address line 1.
     * @param $line1
     * @return void
     */
    public function setLine1($line1): void
    {
        if (trim($line1) === null)
        {
            throw new InvalidArgumentException("You must supply an address line 1.");
        }
        $this->line1 = $line1;
    }

    /**
     * Set the city.
     * @param $city
     * @return void
     */
    public function setCity($city): void
    {
        if (trim($city) === null)
        {
            throw new InvalidArgumentException("You must supply a city.");
        }
        $this->city = $city;
    }

    /**
     * Set the state.
     * @param $state
     * @return void
     */
    public function setState($state): void
    {
        if (trim($state) === null)
        {
            throw new InvalidArgumentException("You must supply a state.");
        }
        $this->state = $state;
    }

    /**
     * Set the zip code.
     * @param $zip
     * @return void
     */
    public function setZip($zip): void
    {
        if (trim($zip) === null)
        {
            throw new InvalidArgumentException("You must supply a zip code.");
        }
        $this->zip = $zip;
    }

    /**
     * Set the country.
     * @param $country
     * @return void
     */
    public function setCountry($country): void
    {
        if (trim($country) === null)
        {
            throw new InvalidArgumentException("You must supply a country.");
        }
        $this->country = $country;
    }

    /**
     * Store input values into the object properties.
     * @param array $values
     * @return void
     */
    public function storeInput(array $values): void
    {
        $requiredKeys = [
            'account_id',
            'name',
            'line1',
            'city',
            'state',
            'zip',
            'country'
        ];

        foreach ($requiredKeys as $key)
        {
            if (!array_key_exists($key, $values))
            {
                throw new InvalidArgumentException("$key is a required key in the input array.");
            }
        }

        $this->setAccountID($values['account_id']);
        $this->setName($values['name']);
        $this->setLine1($values['line1']);
        $this->setCity($values['city']);
        $this->setState($values['state']);
        $this->setZip($values['zip']);
        $this->setCountry($values['country']);
    }
}
