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
     * Get details of an account, including its first address and sub-accounts.
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
        $firstAddress = !empty($result2) && isset($result2[0]) ? $result2[0] : null;

        // Create the main Account object
        $account = new Account([
            'account_id' => intval($accountID),
            'name' => $result1->name ?? null,
            'line1' => $firstAddress->line1 ?? null,
            'city' => $firstAddress->city ?? null,
            'state' => $firstAddress->state ?? null,
            'zip' => $firstAddress->zip ?? null,
            'country' => $firstAddress->country ?? null,
        ]);

        // Check if the account has sub-accounts and create them
        if (!empty($result1->sub_accounts)) {
            foreach ($result1->sub_accounts as $subAccountID) {
                // Fetch sub-account details (recursive)
                $subAccountDetails = $this->getAccount($subAccountID); 
                // Add the sub-account to the main account object
                $account->addSubAccount($subAccountDetails);
            }
        }

        // Return the main account object, now with sub-accounts
        return $account;
    }
}
