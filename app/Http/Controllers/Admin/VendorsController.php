<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\MainCate;
use App\models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class VendorsController extends Controller
{
    // SHOW VENDORS TABLE
    public function index()
    {
        // DATABASE VENDORS WITH THEIR CATEGORIES
        $vendors = Vendor::/*with([
            'category'
        ])->*/selection()->paginate(PAGINATION_COUNT);

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
                
                // START VALUES TRANSACTIONS TO DATABASE
                DB::beginTransaction();

                // HELPER UPLOAD FILE METHOD
                $vendLogo = uploadFile(
                    'vendors',
                    $request->vend_logo
                );
                
                // CREATE NEW VENDOR DATABASE STATEMENT
                $vendor = Vendor::create([
                    'name'      => $request->input('vend-name'),     // REQUEST VENDOR NAME
                    'status'    => $vendStat,                        // REQUEST VENDOR STATUS
                    'cate_id'   => $request->input('vend-cate'),     // REQUEST VENDOR CATEGORY
                    'email'     => $request->input('vend-mail'),     // REQUEST VENDOR EMAIL
                    'mobile'    => $request->input('vend-mobi'),     // REQUEST VENDOR ADDRESS
                    'address'   => $request->input('vend-addr'),     // REQUEST VENDOR MOBILE
                    'logo'      => $vendLogo,                        // REQUEST VENDOR LOGO
                    'password'  => $request->input('vend-pass'),     // REQUEST VENDOR PASSWORD
                ]);

                // DATABASE NEW VENDOR CREATED CHECK
                if ($vendor) {
                    // NOTIFY WITH AN EMAIL
                    Notification::send(
                        $vendor,                    // SENDER
                        new VendorCreated($vendor)  // RECIEVER
                    );
                }

                // COMMIT VALUES TO DATABASE
                DB::commit();
                
            } else {

                // REDIRECT TO VENDOR CREATION FORM VIEW WITH ERROR MESSAGE
                return redirect()->route('admin.vendor.create')->with([
                    'error' => 'Please upload a logo'
                ]);
            }

            // REDIRECT TO VENDORS INDEX TABLE VIEW
            return redirect()->route('admin.vendors')->with([
                'success' => 'Stored successfully'
            ]);
            
        } catch (\Throwable $th) {
            
            // ROLLBACK IF ANY ERROR OCCURRED
            DB::rollback();

            // REDIRECT TO VENDOR CREATION FORM VIEW WITH ERROR MESSAGE
            return redirect()->route('admin.vendor.create')->with([
                'error' => 'Something went terribly wrong'
            ]);

        }
    }

    // SHOW VENDOR EDIT FORM
    public function edit($vendor_id)
    {
        try {

            // DATABASE VENDOR DATA
            $vend = Vendor::find($vendor_id);

            // VENDOR NOT EXIST CHECK
            if (!$vend) {

                // REDIRECT TO VENDORS INDEX TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.vendors')->with([
                    'error' => 'No such vendor'
                ]);
            }

            // ADMIN DEFAULT LANGUAGE
            $defLang = getDefaultLang();

            // DATABASE ACTIVE DEFAULT MAIN CATEGORIES
            $cates = MainCate::where(
                'trans_lang',
                '=',
                $defLang
            )->active()->get();
            
            // VENDORS EDIT FORM
            return view(
                'admin.vendors.edit',
                compact(
                    'vend',
                    'cates'
                )
            );

        } catch (\Throwable $th) {
            
            // REDIRECT TO VENDORS INDEX TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.vendors')->with([
                'error' => 'Something went terribly wrong'
            ]);

        }
        
    }

    // UPDATE VENDOR EDIT FORM DATA
    public function update(VendorRequest $request, $vendor_id)
    {

        try {

            // DATABASE VENDOR OF A SPECIFIC ID
            $vend = Vendor::find($vendor_id);
            
            // DATABASE VENDOR EXISTANCE CHECK
            if (!$vend) {
                
                // REDIRECT TO VENFORS TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.vendors')->with([
                    'error' => 'No such vendor'
                ]);
            }
            
            // READ ONLY INPUT IS CHANGED CHECK
            if (
                $request->input('vend-show-addr') == null ||
                $request->input('vend-show-addr') !== $vend->address
            ) {

                // REDIRECT TO VENDORS TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.vendors')->with([
                    'error' => 'Something went terribly wrong'
                ]);
            }

            // START DATABASE TRANSACTIONS
            DB::beginTransaction();

            // REQUEST LOGO CHECK
            if ($request->has('vend_logo')) {

                // CHECK VENDOR EXISTANCE IN DATABASE
                if ($vend) {
                        
                    // DELETE THE OLD VENDOR LOGO FROM SERVER FOLDER
                    deleteFile($vend->logo);
                }

                // HELPER UPLOAD FILE METHOD
                $vendLogo = uploadFile(
                    'vendors',              // SERVER FOLDER WHERE TO UPLOAD
                    $request->vend_logo     // FILE NAME WHICH TO STORE
                );

                // DATABASE UPDATE NEW LOGO STATEMENT
                $vend->update([
                    'logo' => $vendLogo
                ]);
                
            }

            // ANY INPUT VALUE NOT EQUAL DATABASE VALUE CHECK
            if (
                $request->input('vend-name') !== $vend->name ||
                $request->input('vend-mobi') !== $vend->mobile ||
                intval($request->input('vend-cate')) !== $vend->cate_id ||
                $request->input('vend-mail') !== $vend->email ||
                intval($request->input('vend-stat')) !== $vend->status ||
                $request->input('vend-addr') !== $vend->address ||
                $request->has('vend-pass')
            ) {

                // ADDRESS CHANGED CHECK
                if (
                    $request->input('vend-addr') !== null &&
                    $request->input('vend-addr') !== $vend->address
                ) {

                    // DATABASE ADDRESS UPDATE STATEMENT
                    $vend->update([
                        'address' => $request->input('vend-addr')
                    ]);
                    
                }

                // ADDRESS CHANGED CHECK
                if (
                    $request->input('vend-pass') !== null
                ) {

                    // DATABASE ADDRESS UPDATE STATEMENT
                    $vend->update([
                        'password'  => $request->input('vend-pass')
                    ]);
                    
                }

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

                // DATABASE NEW EDITED VALUES UPDATE STATEMENT
                $vend->update([
                    'name'      => $request->input('vend-name'),
                    'mobile'    => $request->input('vend-mobi'),
                    'cate_id'   => intval($request->input('vend-cate')),
                    'email'     => $request->input('vend-mail'),
                    'status'    => $vendStat
                ]);

            }

            // COMMIT DATABASE CHANGES
            DB::commit();

            // REDIRCT TO VENDORS TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.vendors')->with([
                'success' => 'Updated Successfully'
            ]);

        } catch (\Throwable $th) {

            // DATABASE ROLL-BACK
            DB::rollback();

            // REDIRECT TO VENDORS TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.vendors')->with([
                'error' => 'Something went terribly wrong'
            ]);

        }

    }

    // DELETE VENDOR TABLE ROW
    public function destroy($vendorID)
    {
        try {

            // DATABASE VENDOR OF AN ID
            $vend = Vendor::find($vendorID);
            
            // DATABASE VENDOR EXISTANCE CHECK
            if (!$vend) {
                
                // REDIRECT TO VENDORS TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.vendors')->with([
                    'error' => 'No such vendor'
                ]);
            }

            // START DATABASE TRANSACTIONS
            DB::beginTransaction();

            // DELETE MAIN CATEGORY IMAGE FROM SERVER
            deleteFile($vend->logo);

            // DATABASE MAIN CATEGORY DELETE STATEMENT
            $vend->delete();

            // DATABASE COMMIT TRANSACTIONS
            DB::commit();

            // REDIRECT TO MAIN CATEGORIES TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.vendors')->with([
                'success' => 'Deleted Successfully'
            ]);

        } catch (\Throwable $th) {
            
            // REDIRECT TO VENDORS TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.vendors')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

    // ACTIVATE OR DEACTIVATE VENDOR WITH AN ID
    public function changeStatus($vendID)
    {
        try {

            // DATABASE VENDOR OF AN ID
            $vend = Vendor::find($vendID);

            // DATABASE VENDOR EXISTANCE CHECK
            if (!$vend) {
                
                // REDIRECT TO VAENDORS TABLE WITH ERROR MESSAGE
                return redirect()->route('admin.vendors')->with([
                    'error' => 'No such vendor'
                ]);
            }

            // CHANGE VENDOR'S STATUS
            $vendStat = ($vend->status == 1)? 0: 1;

            // DATABASE UPDATE VENDOR'S STATUS STATEMENT
            $vend->update([
                'status' => $vendStat
            ]);

            // REDIRECT TO VENDORS TABLE WITH SUCCESS MESSAGE
            return redirect()->route('admin.vendors')->with([
                'success' => 'Status changed successfully'
            ]);

        } catch (\Throwable $th) {
            
            // REDIRECT TO VENDORS TABLE WITH ERROR MESSAGE
            return redirect()->route('admin.vendors')->with([
                'error' => 'Something went terribly wrong'
            ]);
        }

    }

}
