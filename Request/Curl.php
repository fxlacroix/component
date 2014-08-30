<?php

namespace FXL\Component\Request;

class Curl
{
    private static $_instance = null;

    protected $url;
    protected $curl;
    protected $userAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6";
    protected $cookie = "/tmp/cookie.txt";

    protected $response;
    protected $responseStatus;

    /**
     * constructor
     */
    public function __construct($url = null)
    {

        $this->curl = curl_init();

        $this->setUrl($url)
            ->setCookieFile()
            ->setCookieJar()
            ->setFollowLocation()
            ->setPost(0)
            ->setReferer()
            ->setReturnTransfer()
            ->setSslVerifyPeer()
            ->setTimeOut()
            ->setUserAgent();
    }

    /**
     * @param void
     * @return Singleton
     */
    public static function getInstance($url)
    {

        //@todo
//    if (is_null(self::$_instance)) {

        self::$_instance = & new Curl($url);
//    }

        if ($url) {

            self::$_instance->setUrl($url);
        }


        return self::$_instance;
    }

    /**
     * static proxy create
     */
    public static function create($url)
    {
        $curl = new Curl($url);

        if ($url) {

            $curl->setUrl($url);
        }
        return $curl;
    }

    /**
     * execute curl
     *
     * @return \FXL\Component\Request\Curl
     */
    public function execute()
    {

        $this->response = curl_exec($this->curl);

        $this->responseStatus = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

        if ($this->responseStatus != 200) {

            throw new \InvalidArgumentException("request status respond " . $this->responseStatus);
        }

        curl_close($this->curl);

        return $this->response;
    }

    /**
     * alias execute curl
     *
     * @return \FXL\Component\Request\Curl
     */
    public function exec()
    {

        return $this->execute();
    }

    /**
     * get status
     *
     * @return integer
     */
    public function getStatus()
    {

        return $this->ResponseStatus;
    }

    /**
     * set cookie jar
     *
     * @param string $cookie
     */
    public function setCookieJar($cookie = null)
    {

        if (!$cookie) {

            $cookie = $this->cookie;
        }

        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $cookie);

        return $this;
    }

    /**
     * set cookie file
     *
     * @param string $cookie
     */
    public function setCookieFile($cookie = null)
    {

        if (!$cookie) {

            $cookie = $this->cookie;
        }

        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $cookie);

        return $this;
    }

    /**
     * set follow location
     *
     * @param boolean $followLocation
     */
    public function setFollowLocation($followLocation = 1)
    {

        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $followLocation);

        return $this;
    }

    /**
     * set post
     *
     * @param boolean $post
     */
    public function setPost($post)
    {
        curl_setopt($this->curl, CURLOPT_POST, $post);

        return $this;
    }

    /**
     * set post fields
     *
     * @param array $postData
     */
    public function setPostFields($postData)
    {

        $this->setPost(1);

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($postData));

        return $this;
    }

    /**
     * set referer
     *
     * @param string $referer
     */
    public function setReferer($referer = null)
    {

        if (!$referer) {

            $referer = $this->url;
        }

        curl_setopt($this->curl, CURLOPT_REFERER, $referer);

        return $this;
    }

    /**
     * set return transfer
     *
     * @param boolean $returnTransfer
     */
    public function setReturnTransfer($returnTransfer = 1)
    {

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, $returnTransfer);

        return $this;
    }

    /**
     * set ssl verify peer
     *
     * @param boolean $sslVerifyPeer
     */
    public function setSslVerifyPeer($sslVerifyPeer = 0)
    {

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $sslVerifyPeer);

        return $this;
    }

    /**
     * set time out
     *
     * @param integer $timeOut
     */
    public function setTimeOut($timeOut = 60)
    {

        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeOut);

        return $this;
    }

    /**
     * set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;

        curl_setopt($this->curl, CURLOPT_URL, $url);

        return $this;
    }

    /**
     * set user agent
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent = null)
    {

        if (!$userAgent) {

            $userAgent = $this->userAgent;
        }

        curl_setopt($this->curl, CURLOPT_USERAGENT, $userAgent);

        return $this;
    }

}
