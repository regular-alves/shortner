<?php

namespace App\Console\Commands;

use App\Urls;
use Illuminate\Console\Command;

class CrawlTitle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urls:title';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls url titles';

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
        $uncrawledUrl = Urls::whereNull( 'title' )
            ->orderBy('created_at', 'asc')
            ->limit('15')
            ->get();

        foreach( $uncrawledUrl as $url ) {
            $pageContent = @file_get_contents( $url['url'] );

            preg_match( '/<title>(.+)<\/title>/U', $pageContent, $content );

            if ( empty( $content[1] ) ) {
                continue;
            }

            $url->fill( [ 'title' => empty( $content[1] ) ? 'Untitled' :  $content[1] ] );
            $url->save();
        }

        return;
    }
}
