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
                echo "response_time.label Temps de reponse" . PHP_EOL;
                echo "response_time.info Le temps (en ms) que le site a mis a repondre" . PHP_EOL;
                echo "response_code.label Code de reponse" . PHP_EOL;
                exit(0);
                break;
            default:
                /* exit out */
                print "invalid argument: " . $arg . "\n";
                exit(1);
                break;
        }
    }

    /**
     * WebsiteTest constructor.
     * @param $website string Le nom du site
     * @param $url string l'url à check
     * @param $type string le type de requete
     * @param $guzzle_params array params du constructeur de guzzle (outil pour faire les requetes http)
     * @param array $http_params paramètres de la requette
     * @param null|string $arg Argument de la CLI
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    function __construct($website, $url, $type, $guzzle_params, $http_params = [] ,$arg = null)
    {
        /* check command line arguments */
        if(!is_null($arg))
            $this->getConfig($arg, $website, $url);

        $client = new GuzzleHttp\Client($guzzle_params);
        $one = microtime(true);
        $res = $client->request($type, $url, $http_params);
        $req_code = $res->getStatusCode();
        $req_time = microtime(true) - $one;

        if($req_code == 200)
            $req_code = 0;
        else
            $req_code = $req_code * 0.001;

        echo 'response_time.value ' . $req_time . PHP_EOL;
        echo 'response_code.value ' . $req_code . PHP_EOL;

    }
}