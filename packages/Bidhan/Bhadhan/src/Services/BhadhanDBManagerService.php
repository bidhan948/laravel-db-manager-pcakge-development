<?php

namespace Bidhan\Bhadhan\Services;

use Illuminate\Support\Facades\DB;

class BhadhanDBManagerService
{
    public static function getCurrentDatabaseName()
    {
        return DB::connection()->getDatabaseName();
    }

    public static function getAllDbTables()
    {
        return DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\' ORDER BY table_name');
    }

    public static function getForeignKeys(string $table)
    {
        return DB::select("SELECT 
                            tc.constraint_name, 
                            kcu.column_name, 
                            ccu.table_name AS foreign_table_name,
                            ccu.column_name AS foreign_column_name
                        FROM 
                            information_schema.table_constraints AS tc 
                            JOIN information_schema.key_column_usage AS kcu
                            ON tc.constraint_name = kcu.constraint_name
                            JOIN information_schema.constraint_column_usage AS ccu
                            ON ccu.constraint_name = tc.constraint_name
                        WHERE tc.constraint_type = 'FOREIGN KEY' AND tc.table_name = ?;
                        ", [$table]);
    }

    public static function getPrimaryKey(string $table)
    {
        return DB::select("SELECT 
                            kcu.column_name
                        FROM 
                            information_schema.table_constraints tc
                        JOIN 
                            information_schema.key_column_usage kcu
                            ON tc.constraint_name = kcu.constraint_name
                            AND tc.table_schema = kcu.table_schema
                        WHERE 
                            tc.constraint_type = 'PRIMARY KEY' 
                            AND tc.table_name = ?
                            AND kcu.column_name = 'id';", [$table]);
    }
}
