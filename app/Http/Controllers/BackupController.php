<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function index()
    {
        return view('backuplist.create');
    }

    public function backup(Request $request)
    {
        // Get database credentials from config
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', '3306');

        // Set backup filename with timestamp
        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql.gz';
        $path = storage_path("app/backups/{$filename}");

        // Create backups directory if it doesn't exist
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }

        // Command for Hostinger VPS (compressed backup)
        $command = sprintf(
            'mysqldump -h %s -P %s -u %s -p%s %s | gzip > %s',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        $process = Process::fromShellCommandline($command);
        $process->setTimeout(300); // 5 minutes timeout

        try {
            $process->mustRun();
            
            // Check if file was created
            if (!file_exists($path)) {
                throw new \Exception('Backup file was not created');
            }
            
            return response()->download($path)->deleteFileAfterSend(true);
        } catch (ProcessFailedException $exception) {
            return back()->with('error', 'Backup failed: ' . $exception->getMessage());
        } catch (\Exception $exception) {
            return back()->with('error', 'Backup failed: ' . $exception->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file|mimetypes:application/x-gzip,application/sql,text/plain,text/sql'
        ]);

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', '3306');

        $file = $request->file('sql_file');
        $uploadPath = $file->storeAs('temp', $file->getClientOriginalName());
        $fullPath = storage_path("app/{$uploadPath}");

        // Determine if file is gzipped
        $isGzipped = pathinfo($fullPath, PATHINFO_EXTENSION) === 'gz';
        
        try {
            if ($isGzipped) {
                // Command for gzipped backup
                $command = sprintf(
                    'gunzip < %s | mysql -h %s -P %s -u %s -p%s %s',
                    escapeshellarg($fullPath),
                    escapeshellarg($host),
                    escapeshellarg($port),
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($database)
                );
            } else {
                // Command for plain SQL file
                $command = sprintf(
                    'mysql -h %s -P %s -u %s -p%s %s < %s',
                    escapeshellarg($host),
                    escapeshellarg($port),
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($database),
                    escapeshellarg($fullPath)
                );
            }

            $process = Process::fromShellCommandline($command);
            $process->setTimeout(300); // 5 minutes timeout
            $process->mustRun();

            // Clean up the uploaded file
            unlink($fullPath);

            return back()->with('success', 'Database restored successfully');
        } catch (ProcessFailedException $exception) {
            // Clean up the uploaded file if error occurs
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            return back()->with('error', 'Restore failed: ' . $exception->getMessage());
        }
    }
}