<?php

namespace App\Console\Commands;

use App\Http\Requests\WebUrl;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;

class WebUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'web:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle(WebUrl $request)
    {
        $url = $request->validated();
        dd($url);
        $client = new Client();

        $response = $client->request('GET',$url);

        $responseStatusCode = $response->getStatusCode();

        $html = $response->getBody()->getContents();

        if($responseStatusCode == 200){
            $dom = HtmlDomParser::str_get_html($html);
            //page_contain
            $contents = $dom->find('div[class="page_contain"]');


            foreach ($contents as $content){
                $contentTitle = trim( $content->find('h4',0)->text());
                $contentParagraph = trim( $content->find('p',0)->text());
                $contentPreClass =  trim($content->find('pre[class=" language-php"]')->text());

            }
        }

    }
}

