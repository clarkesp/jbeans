<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RawTables extends Command
{
    protected $signature = 'db:raw-tables';

    protected $description = 'Display the raw contents of all tables in the database, showing columns even if there is no data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all tables in the database
        $tables = DB::select('SELECT name FROM sqlite_master WHERE type="table"');

        if (empty($tables)) {
            $this->info('No tables found in the database.');
            return;
        }

        // Loop through each table and display its contents
        foreach ($tables as $table) {
            $tableName = $table->name;
            $this->line("\nTable: " . $tableName);

            // Get the columns of the table
            $columns = Schema::getColumnListing($tableName);

            if (empty($columns)) {
                $this->info('No columns found for this table.');
                continue;
            }

            // Get the first 5 rows of data from the table
            $rows = DB::table($tableName)->limit(5)->get();

            if ($rows->isEmpty()) {
                // If there is no data, just show the column headers
                $this->line('No data found. Showing column headers:');
                $headers = $columns;
                $this->table($headers, []);
            } else {
                $this->displayTable($rows, $columns);
            }
        }
    }

    protected function displayTable($rows, $columns)
    {
        // Convert rows to an array of arrays
        $data = $rows->map(function ($row) {
            return (array) $row;
        })->toArray();

        // Display the table with column headers, even if empty
        $this->table($columns, $data);
    }
}
