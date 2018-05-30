<?php
/**
 * Created by PhpStorm.
 * User: cedric
 * Date: 30/05/18
 * Time: 21:25
 */

require '/usr/share/munin/popup/contrib/vendor/autoload.php';
use GuzzleHttp\Psr7\Request as GuzzleRequest;
class WebsiteTest
{
    function getConfig($arg, $website, $url)
    {
        /* see what they want us to do */
        switch ($arg) {
            case 'config';
                echo "graph_category websites" . PHP_EOL;
                echo "graph_title $website ($url)" . PHP_EOL;
                echo "graph_vlabel response" . PHP_EOL;
                echo "response_time.label Temps de réponse" . PHP_EOL;
                echo "response_time.info Le temps (en ms) que le site à mis à répondre" . PHP_EOL;
//            echo "response_time"
                echo "response_code.label Code de réponse" . PHP_EOL;
                echo "graph_args --lower-limit 0 --" . PHP_EOL;
                exit(0);
                break;
            default:
                /* exit out */
                print "invalid argument: " . $arg . "\n";
                exit(1);
                break;
        }
    }

    function __construct($website, $url, $arg = null)
    {
        /* check command line arguments */
        if(!is_null($arg))
            $this->getConfig($arg, $website, $url);

        $client = new GuzzleHttp\Client(['verify' => false]);
        $one = microtime(true);
        $res = $client->request('GET', $url);
        $req_code = $res->getStatusCode();
        $req_time = microtime(true) - $one;

        if($req_code == 200)
            $req_code = 0;
        else
            $req_code = $req_code * 0.001;

        echo 'response_time.value ' . $req_time . PHP_EOL;
        echo 'response_code ' . $req_code . PHP_EOL;

    }
}