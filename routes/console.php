<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('school:import-sql {--fresh : Drop all tables before importing}', function () {
    $path = database_path('sql/school_management.sql');

    if (! file_exists($path)) {
        $path = base_path('school_management.sql');
    }

    if (! file_exists($path)) {
        $this->error('SQL file not found. Expected database/sql/school_management.sql or school_management.sql');
        return self::FAILURE;
    }

    $defaultConnection = config('database.default');
    if ($defaultConnection !== 'mysql') {
        $this->warn("Current DB_CONNECTION is '{$defaultConnection}'. This import is intended for MySQL on Laravel Cloud.");
    }

    $sql = file_get_contents($path);
    if ($sql === false) {
        $this->error('Unable to read SQL file.');
        return self::FAILURE;
    }

    $statements = splitSqlStatements($sql);

    if (empty($statements)) {
        $this->error('No SQL statements were found in the dump.');
        return self::FAILURE;
    }

    try {
        DB::unprepared('SET FOREIGN_KEY_CHECKS=0');

        if ($this->option('fresh')) {
            $tables = DB::select('SHOW TABLES');
            $key = 'Tables_in_' . DB::getDatabaseName();
            foreach ($tables as $table) {
                $tableName = $table->$key ?? array_values((array) $table)[0] ?? null;
                if ($tableName) {
                    DB::unprepared("DROP TABLE IF EXISTS `{$tableName}`");
                }
            }
            $this->info('Existing tables dropped.');
        }

        $count = 0;
        foreach ($statements as $statement) {
            DB::unprepared($statement);
            $count++;
        }

        DB::unprepared('SET FOREIGN_KEY_CHECKS=1');
    } catch (Throwable $e) {
        DB::unprepared('SET FOREIGN_KEY_CHECKS=1');
        $this->error('Import failed: ' . $e->getMessage());
        return self::FAILURE;
    }

    $this->info("Import completed successfully. Executed {$count} SQL statements.");
    $this->line('You can now log in with the users included in the SQL dump.');

    return self::SUCCESS;
})->purpose('Import the bundled school_management.sql dump into the configured MySQL database');

function splitSqlStatements(string $sql): array
{
    $statements = [];
    $buffer = '';
    $inSingleQuote = false;
    $inDoubleQuote = false;
    $inLineComment = false;
    $inBlockComment = false;
    $length = strlen($sql);

    for ($i = 0; $i < $length; $i++) {
        $char = $sql[$i];
        $next = $i + 1 < $length ? $sql[$i + 1] : '';
        $prev = $i > 0 ? $sql[$i - 1] : '';

        if ($inLineComment) {
            if ($char === "\n") {
                $inLineComment = false;
            }
            continue;
        }

        if ($inBlockComment) {
            if ($char === '*' && $next === '/') {
                $inBlockComment = false;
                $i++;
            }
            continue;
        }

        if (! $inSingleQuote && ! $inDoubleQuote) {
            if ($char === '-' && $next === '-') {
                $inLineComment = true;
                $i++;
                continue;
            }
            if ($char === '/' && $next === '*') {
                $inBlockComment = true;
                $i++;
                continue;
            }
        }

        if ($char === "'" && ! $inDoubleQuote && $prev !== '\\') {
            $inSingleQuote = ! $inSingleQuote;
        } elseif ($char === '"' && ! $inSingleQuote && $prev !== '\\') {
            $inDoubleQuote = ! $inDoubleQuote;
        }

        if ($char === ';' && ! $inSingleQuote && ! $inDoubleQuote) {
            $statement = trim($buffer);
            $buffer = '';

            if ($statement === '' || strtoupper($statement) === 'SET FOREIGN_KEY_CHECKS = 0' || strtoupper($statement) === 'SET FOREIGN_KEY_CHECKS = 1') {
                continue;
            }

            $statements[] = $statement;
            continue;
        }

        $buffer .= $char;
    }

    $tail = trim($buffer);
    if ($tail !== '') {
        $statements[] = $tail;
    }

    return $statements;
}
