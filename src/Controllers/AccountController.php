<?php

namespace SonarSoftware\CustomerPortalFramework\Controllers;

use SonarSoftware\CustomerPortalFramework\Exceptions\ApiException;
use SonarSoftware\CustomerPortalFramework\Helpers\HttpHelper;
use SonarSoftware\CustomerPortalFramework\Models\Account;

class AccountController
{
    private $httpHelper;

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->httpHelper = new HttpHelper();
    }

    /**
     * Get account details
     * @param $accountID
     * @return mixed
     * @throws ApiException
     */
    public function getAccountDetails($accountID)
    {
        return $this->httpHelper->get("accounts/" . intval($accountID));
    }

    /**
     * Get details of an account, including its first address.
     * @param $accountID
     * @return Account
     * @throws \SonarSoftware\CustomerPortalFramework\Exceptions\ApiException
     */
    public function getAccount($accountID)
    {
        // Fetch account details
        $result1 = $this->httpHelper->get("/accounts/" . intval($accountID));

        // Fetch account addresses
        $result2 = $this->httpHelper->get("/accounts/" . intval($accountID) . "/addresses");

        // Ensure the address data is available and extract the first address
        $firstAddress = !empty($result2->data) && isset($result2->data[0]) ? $result2->data[0] : null;

        // Create and return the Account object
        return new Account([
            'account_id' => intval($accountID),
            'name' => $result1->name ?? null,
            'line1' => $firstAddress->line1 ?? 'hello',
            'city' => $firstAddress->city ?? null,
            'state' => $firstAddress->state ?? null,
            'zip' => $firstAddress->zip ?? null,
            'country' => $firstAddress->country ?? null,
        ]);
    }
}
