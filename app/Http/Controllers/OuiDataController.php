<?php

namespace App\Http\Controllers;

use App\Models\OuiData;
use Illuminate\Http\Request;

class OuiDataController extends Controller
{

    public function SingleMACLookup($query)
    {

        //Remove all characters from queried MAC address except for numbers and letters
        $filteredMAC = preg_replace("/[^a-zA-Z0-9]+/", '', $query);

        //Get first 6 characters from MAC address to get the OUI
        $OUIvalue = substr($filteredMAC, 0, 6);

        //Search database for OUI data matching the mac address queried
        $OuiResults = OuiData::where('assignment', $OUIvalue)->get();

        //Create an object containing the queried mac address and the vendor name to output to the end user, matching the format in the brief.
        $OutputResults = array();

        foreach ($OuiResults as $ouiResult){
            $OutputResults[] = ['mac_address' => $query, 'vendor' => $ouiResult->organization_name];
        }

        return json_encode($OutputResults);
    }

}
