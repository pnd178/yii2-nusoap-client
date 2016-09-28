<?php

namespace ilayer;

use lib\nusoap;

class NusoapClient extends Component
{
    public $url;
    
    public $options = [];
    
    private $_client;
    
    public $answer;
 
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->url === null) {
            throw new InvalidConfigException('The "url" property must be set.');
        }
        $this->_client = new nusoap_client($this->url, 'WSDL'); 
        
        $error = $this->_client->getError();
        if ($error) {
            return $error;
        }
    }
    
    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function call($name, $arguments)
    {
        $answer = $this->_client->call($name, ['parameters' =>$arguments], '', '', false, true);
        $error = $this->_client->getError();
        if ($error) {
             return ("Error: {$error}\n".$this->client->response.$this->client->getDebug());
        }
        else
        {
            return $answer;
        }
    }
}


