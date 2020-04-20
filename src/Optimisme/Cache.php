<?php
namespace Optimisme;

class Cache {

    private $_cachetime;
    private $_cachefile;
    private $_cachefileUrl;
    private $_folder = __DIR__."/../optimismeCache";

    public function __construct(String $name = null, Int $cachetime = 21600) {
        $url = $_SERVER["SCRIPT_NAME"];
        $break = Explode('/', $url);
        $file = $name != null ? $name : substr_replace($break[count($break) - 1] ,"",-4);
        $this->_cachefile = 'cached-'.$file.'.html';
        $this->_cachefileUrl = $this->_folder.'/'.$this->_cachefile;
        $this->_cachetime = $cachetime;
        if (!file_exists($this->_folder)) {
            mkdir($this->_folder);
        }
    }

    public function cache(Callable $handler) {
        if (file_exists($this->_cachefileUrl) && time() - $this->_cachetime < filemtime($this->_cachefileUrl)) {
            echo "<!-- Cached copy, generated ".date('H:i', filemtime($this->_cachefileUrl))." -->\n";
            readfile($this->_cachefileUrl);
        } else {
            ob_start();
            $handler();
            $cached = fopen($this->_cachefileUrl, 'w');
            fwrite($cached, ob_get_contents());
            fclose($cached);
            ob_end_flush(); // Send the output to the browser
        }
    }

    public function open() {
        if (file_exists($this->_cachefileUrl) && time() - $this->_cachetime < filemtime($this->_cachefileUrl)) {
            readfile($this->_cachefileUrl);
            return false;
        } else {
            ob_start();
            return true;
        }
    }

    public function save() {
        $cached = fopen($this->_cachefileUrl, 'w');
        fwrite($cached, ob_get_contents());
        fclose($cached);
        ob_end_flush(); // Send the output to the browser
    }

}