<?php

namespace App\Console\Commands;

use App\Models\OuiData;
use Illuminate\Console\Command;

class ImportCsvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:import {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports specified csv file placed in the public/csv folder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Load the csv file from the folder in the public directory
        $filename = public_path('csv/'.$this->argument('filename'));

        //Converting the CSV into an array that can be imported
        $csvArray = $this->csvToArray($filename);

        //Looping over each row in the returned array and importing into the database's oui_data table
        for ($i = 0; $i < count($csvArray); $i ++)
        {
            $this->info('Importing item '.$i.' of '.count($csvArray));
            $oui_data = new OuiData;
            $oui_data->registry = $csvArray[$i]["Registry"];
            $oui_data->assignment = $csvArray[$i]["Assignment"];
            $oui_data->organization_name = $csvArray[$i]["Organization Name"];
            $oui_data->organization_address = $csvArray[$i]["Organization Address"];
            $oui_data->save();
        }

        return 'Csv Imported';
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }
}
