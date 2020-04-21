<?php
namespace Optimisme;

class Cache {

    private $_cachetime;
    private $_cachefile;
    private $_cachefileUrl;
    private $_folder = __DIR__.'/../optimismeCache';

    /**
     * Initialize Optimisme Cache for a specific page or component
     *
     * @param String|null $name [Optional name if it is a reusable component]
     * @param Int $cachetime [Cache duration in seconds. Defult is 21 600s]
     */
    public function __construct(?String $name = null, Int $cachetime = 21600) {
        $url = str_replace('/', '-', $_SERVER['SCRIPT_NAME']);
        $file = $name ?? substr_replace($url ,'',-4);
        $this->_cachefile = 'cached-'.$file.'.html';
        $this->_folder = $_SERVER['DOCUMENT_ROOT'].'/optimismeCache';
        $this->_cachefileUrl = $this->_folder.'/'.$this->_cachefile;
        $this->_cachetime = $cachetime;
        if (!file_exists($this->_folder)) {
            mkdir($this->_folder);
        }
    }

    /**
     * Get cache data
     *
     * @param Callable $handler [Write the code to cache into the handler function]
     * @return void
     */
    public function cache(Callable $handler):Void {
        if ($this->open()) {
            $handler();
            $this->save();
        }
    }

    /**
     * Get cache data or open caching if there is no cached data
     *
     * @return Bool [Return is we open cashing]
     */
    public function open():Bool {
        $fileIsCached = file_exists($this->_cachefileUrl) && time() - $this->_cachetime < filemtime($this->_cachefileUrl);
        $fileIsCached ? readfile($this->_cachefileUrl) : ob_start();
        return !$fileIsCached;
    }

    /**
     * Cache code between Cache()->open() and Cache()->save()
     *
     * @return void
     */
    public function save():Void {
        $cached = fopen($this->_cachefileUrl, 'w');
        fwrite($cached, ob_get_contents());
        fclose($cached);
        ob_end_flush();
    }

}