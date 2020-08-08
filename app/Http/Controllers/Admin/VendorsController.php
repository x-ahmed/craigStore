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

        try {

            // REQUEST NOT ACTIVE CHECK
            if (!$request->has('vend-stat')) {
                
                $vendStat = array_merge(    // CONVERT REQUEST TO ARRAY & ADD DEACTIVATION VALUE
                    $request->all(),        // REQUEST AS AN ARRAY
                    [
                        'vend-stat' => 0    // DEACTIVATION KEY & VALUE
                    ]
                )['vend-stat'];             // DEACTIVATION VALUE RETRIEVEMENT
            } else {

                // CONVERT DEFAULT ACTIVE STRING VALUE TO INTEGER
                $vendStat = intval(
                    $request->input('vend-stat')
                );
            }

            // REQUEST LOGO CHECK
            if ($request->has('vend_logo')) {
                
                // HELPER UPLOAD FILE METHOD
                $vendLogo = uploadFile(
                    'vendors',
                    $request->vend_logo
                );
                
                // CREATE NEW VENDOR DATABASE STATEMENT
                Vendor::create([
                    'name'      => $request->input('vend-name'),     // REQUEST VENDOR NAME
                    'status'    => $vendStat,                        // REQUEST VENDOR STATUS
                    'cate_id'   => $request->input('vend-cate'),     // REQUEST VENDOR CATEGORY
                    'email'     => $request->input('vend-mail'),     // REQUEST VENDOR EMAIL
                    'mobile'    => $request->input('vend-mobi'),     // REQUEST VENDOR ADDRESS
                    'address'   => $request->input('vend-addr'),     // REQUEST VENDOR MOBILE
                    'logo'      => $vendLogo,                        // REQUEST VENDOR LOGO
                ]);
            } else {

                // REDIRECT TO VENDOR CREATION FORM VIEW WITH ERROR MESSAGE
                return redirect()->route('admin.vendor.create')->with([
                    'error' => 'Please upload the vendor logo'
                ]);
            }

            // REDIRECT TO VENDORS INDEX TABLE VIEW
            return redirect()->route('admin.vendors')->with([
                'success' => 'Vendor has been stored successfully'
            ]);
            
        } catch (\Throwable $th) {
            
            // REDIRECT TO VENDOR CREATION FORM VIEW WITH ERROR MESSAGE
            return redirect()->route('admin.vendor.create')->with([
                'error' => 'Something went terribly wrong'
            ]);

        }
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
