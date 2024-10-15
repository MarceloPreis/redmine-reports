<?php 
namespace Opt\RedmineReports\Services;

class Redmine {
    
    private $key;

    public function __construct() {
        $this->key = $_ENV['REDMINE_API_KEY'];
    }

    function api($url, $append = false) {
        $url = 'http://fabtec.ifc-riodosul.edu.br/' . $url . '?key=' . $this->key;

        if ($append)
        $url .= '&' . $append;
    
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Retornar o resultado como string

        $response = curl_exec($ch);
    
        curl_close($ch);

        return json_decode($response);
    }

    public function issues($append = '') {
        return $this->api('issues.json', $append . '&limit=100')->issues;
    }

    public function projects($append = '') {
        return $this->api('projects.json', $append . '&limit=100')->projects;
    } 

    public function project($id) {
        return $this->api('projects.json', "&id=$id")->projects[0];
    } 
}


?>