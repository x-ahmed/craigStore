<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\MainCate;
use App\models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    // SHOW VENDORS TABLE
    public function index()
    {
        // DATABASE VENDORS WITH THEIR CATEGORIES
        $vendors = Vendor::with([
            'category'
        ])->selection()->paginate(PAGINATION_COUNT);

        // VENDORS TABLE VIEW
        return view(
            'admin.vendors.index',
            compact('vendors')
        );
    }

    // SHOW VENDOR CREATION FORM
    public function create()
    {
        // ADMIN DEFAULT LANGUAGE
        $defLang = getDefaultLang();

        // DATABASE ACTIVE DEFAULT MAIN CATEGORIES
        $cates = MainCate::where(
            'trans_lang',
            '=',
            $defLang
        )->active()->get();

        // VENDORS CREATION FORM VIEW
        return view(
            'admin.vendors.create',
            compact('cates')
        );
    }

    // STORE VENDOR CREATION FORM DATA
    public function save(VendorRequest $request)
    {
        return $request;
    }

    // SHOW VENDOR EDIT FORM
    public function edit()
    {
        # code...
    }

    // UPDATE VENDOR EDIT FORM DATA
    public function update()
    {
        # code...
    }

    // DELETE VENDOR TABLE ROW
    public function delete()
    {
        # code...
    }

}
