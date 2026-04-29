<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PDO;

class CreateDatabase extends Command
{
    protected $signature = 'db:create {name}';
    protected $description = 'Create a new MySQL database';

    public function handle()
    {
        $name = $this->argument('name');

        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        try {
            $pdo = new PDO(
                "mysql:host=$host;port=$port",
                $username,
                $password
            );

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $this->info("✅ Database '$name' created successfully!");
        } catch (\Exception $e) {
            $this->error("❌ Failed: " . $e->getMessage());
        }
    }
}