<?php

namespace Hexcores\Api\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Key Generate command for artisan.
 * This class is based on laravel key:generate commmand.
 */
class ApiKeyGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:key {--current= : Show current keys} {--print= : Print only the keys} {--replace= : Replace current keys with new}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gnerate key for API Middleware (X-API-KEY, X-API-SECRET)';

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
     * @return mixed
     */
    public function handle()
    {
        $newKey = Str::random(32);
        $newSecret = Str::random(32);

        $oldKey = env('X-API-KEY');
        $oldSecret = env('X-API-SECRET');

        // Show current keys.
        if ($this->option('current')) {
            return $this->printKeys($oldKey, $oldSecret);
        }

        // Print only the new keys.
        if ($this->option('print')) {
            return $this->printKeys($newKey, $newSecret);
        }

        $path = base_path('.env');

        if (file_exists($path)) {

            $replaceKey = $this->mergeKey($oldKey, $newKey);
            $replaceSecret = $this->mergeKey($oldSecret, $newSecret);

            $search = ['X-API-KEY='.$oldKey, 'X-API-SECRET='.$oldSecret];
            $replace = ['X-API-KEY='.$replaceKey, 'X-API-SECRET='.$replaceSecret];

            file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
        }

        $this->info("API Middleware (X-API-KEY, X-API-SECRET) keys set successfully.");
    }

    /**
     * Merge key with old and new.
     *
     * @param  string $old
     * @param  string $new
     * @return string
     */
    protected function mergeKey($old, $new)
    {
        if ( $this->option('replace')) {
            return $new;
        }

        return empty($old) ? $new : sprintf('%s,%s', $old, $new);
    }

    /**
     * Print API Keys and Secret.
     *
     * @param  string $apiKey
     * @param  string $apiSecret
     * @return void
     */
    protected function printKeys($apiKey, $apiSecret)
    {
        $this->line('<comment> X-API-KEY : '.$apiKey.'</comment>');

        $this->line('<comment> X-API-SECRET : '.$apiSecret.'</comment>');
    }
}
