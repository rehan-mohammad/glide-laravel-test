<?php

namespace App\Http\Controllers;

use App\Models\OuiData;
use Illuminate\Http\Request;

class OuiDataController extends Controller
{

    public function SingleMACLookup($query)
    {

        //Remove all characters from queried MAC address except for numbers and letters, and also convert to uppercase
        $filteredMAC = strtoupper(preg_replace("/[^a-zA-Z0-9]+/", '', $query));

        //Check if second character indicates that it could be randomised
        $isRandom = 0;
        if(in_array(substr($filteredMAC, 1, 1), ['2','6','A','E'])){
            $isRandom = 1;
        }

        //Get first 6 characters from MAC address to get the OUI
        $OUIvalue = substr($filteredMAC, 0, 6);

        //Search database for OUI data matching the mac address queried
        $ouiResult = OuiData::where('assignment', $OUIvalue)->first();

        //Create an object containing the queried mac address and the vendor name to output to the end user, matching the format in the brief.
        $OutputResults = array();

            if($isRandom){
                //Add a message noting that this MAC address is possibly randomised
                $OutputResults[] = ['mac_address' => $query, 'vendor' => $ouiResult->organization_name ?? 'No matching result', 'notes' => "The second character of this MAC Address indicates this could possibly be randomised"];
            }
            else {
                $OutputResults[] = ['mac_address' => $query, 'vendor' => $ouiResult->organization_name ?? 'No matching result'];
            }

        return json_encode($OutputResults);
    }

    public function MultipleMACLookup(Request $request)
    {
        //Convert comma-seperated MAC addresses into array
        $requestArray = explode(',',$request->get('mac_addresses'));

        $OutputResults = array();

        foreach ($requestArray as $query){

            //Remove all characters from queried MAC address except for numbers and letters, and also convert to uppercase
            $filteredMAC = strtoupper(preg_replace("/[^a-zA-Z0-9]+/", '', $query));

            //Check if second character indicates that it could be randomised
            $isRandom = 0;
            if(in_array(substr($filteredMAC, 1, 1), ['2','6','A','E'])){
                $isRandom = 1;
            }

            //Get first 6 characters from MAC address to get the OUI
            $OUIvalue = substr($filteredMAC, 0, 6);

            //Search database for OUI data matching the mac address queried
            $ouiResult = OuiData::where('assignment', $OUIvalue)->first();

                //Create an object containing the queried mac address and the vendor name to output to the end user, matching the format in the brief.
                if($isRandom){
                    //Add a message noting that this MAC address is possibly randomised
                    $OutputResults[] = ['mac_address' => $query, 'vendor' => $ouiResult->organization_name ?? 'No matching result', 'notes' => "The second character of this MAC Address indicates this could possibly be randomised"];
                }
                else {
                    $OutputResults[] = ['mac_address' => $query, 'vendor' => $ouiResult->organization_name ?? 'No matching result'];
                }

        }

        return json_encode($OutputResults);
    }

}
