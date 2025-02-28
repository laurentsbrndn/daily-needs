<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerPurchaseHistoryController extends Controller
{
    public function index(){
        return view('purchasehistory.index', [
            
        ]);
    }
}
