<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\UTCDateTime;

class SyncUsers extends Command
{
    protected $signature = 'sync:users';

    protected $description = 'Synchronize users across PostgreSQL, MySQL, and MongoDB';

    public function handle()
    {
        // Fetch users from primary PostgreSQL
        $users = DB::connection('pgsql')->table('users')->get();

        foreach ($users as $user) {
            // Sync to MySQL (upsert)
            DB::connection('mysql')->table('users')->updateOrInsert(
                ['id' => $user->id],
                (array) $user
            );

            // Sync to MongoDB (upsert; adjust for MongoDB types like timestamps)
            $mongoUser = (array) $user;
            if (isset($mongoUser['created_at'])) {
                $mongoUser['created_at'] = new UTCDateTime(strtotime($mongoUser['created_at']) * 1000);
            }
            if (isset($mongoUser['updated_at'])) {
                $mongoUser['updated_at'] = new UTCDateTime(strtotime($mongoUser['updated_at']) * 1000);
            }
            DB::connection('mongodb')->collection('users')->updateOne(
                ['_id' => $user->id],  // Use id as _id or adjust key
                ['$set' => $mongoUser],
                ['upsert' => true]
            );
        }

        $this->info('Users synchronized successfully across all databases.');
    }
}
