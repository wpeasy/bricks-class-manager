<?php

namespace WPG_BSC\Parsers;



class Parser
{
    private $_original_file;
    private $_parsed_classes = [];
    private $_parsed_variables = [];
    private $_source_name;

    public function __construct($source_name){
        $this->_source_name = $source_name;
    }

    public function get_and_process_url($url)
    {
        $match = preg_match('/\.css/', $url, $matches);

        if(! $match)
            return new \WP_Error(400, __('Only CSS URLs allowed'));

        if($this->_original_file = file_get_contents($url)){
            /*Classes */
            preg_match_all("/\.([^\d\s][_A-Za-z0-9\-]+[^\b\s\+\~\>\.])[^}]*{/m", $this->_original_file , $matches);
            $this->parse_classes($matches[1]);

            /* Vars */
            preg_match_all("/(--\S+):/m", $this->_original_file , $vars);
            $this->parse_vars($vars[1]);
        }else{
            return new \WP_Error(400, __('Parser error getting url ' . $url ));
        }
    }

    private function parse_classes($array = []){
        $unique = array_unique($array);
        foreach ($unique as $class){
            $this->_parsed_classes[] = [
                'id' => $this->_source_name . '_' . $class,
                'name' => $class,
                'settings' => [],
                'set_name' => $this->_source_name
            ];
        }
    }

    private function parse_vars($array = []){
        $unique = array_unique($array);
        $this->_parsed_variables = $unique;
    }

    /**
     * @return array
     */
    public function get_parsed_classes(): array
    {
        return $this->_parsed_classes;
    }

    /**
     * @return array
     */
    public function get_parsed_variables(): array
    {
        return $this->_parsed_variables;
    }

    /**
     * @return mixed
     */
    public function get_original_file()
    {
        return $this->_original_file;
    }
}
/*
$p = new Parser('https://dev-wpget.wpevolve.net/wp-content/uploads/scripts-organizer/css/2936-header-compiled.css', 'f');
file_put_contents('bricks-classes.json', json_encode($p->get_parsed_classes(), JSON_PRETTY_PRINT));
file_put_contents('vars.json', json_encode($p->get_parsed_variables(), JSON_PRETTY_PRINT));
*/
