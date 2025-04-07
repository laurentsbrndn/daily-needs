<?php

namespace App\Services;

use App\Models\MsCustomerAddress;

class CustomerService
{
    public static function getAddresses($customer_id)
    {
        return MsCustomerAddress::where('customer_id', $customer_id)->get();
    }
}
