<?php
/**
 * This file is part of CircleRestClientBundle.
 *
 * CircleRestClientBundle is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * CircleRestClientBundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CircleRestClientBundle.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\RestClientBundle\Services;

/**
 * Sends curl requests
 *
 * @author    Tobias Hauck <tobias.hauck@teeage-beatz.de>
 * @copyright 2015 TeeAge-Beatz UG
 */
class RestClient implements RestInterface {

    /**
     * This variable stores the curl instance created through curl initiation
     *
     * @var Curl
     */
    protected $curl;

    /**
     * @var endpoint
     */
    protected $endpoint;

    /**
     * Constructor
     *
     * @param  Curl $curl
     * @throws \Circle\RestClientBundle\Exceptions\CurlException (Curl not installed.)
     */
    public function __construct(Curl $curl) {
        $this->curl = $curl;
        $this->endpoint = null;
    }

    /**
     * Set api base url
     *
     * @param string $url
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
        return $this;
    }

    /**
     * Get api base url
     *
     * @return string
     */
    public function getEndPoint()
    {
        return $this->endpoint;
    }

    /**
     * Set auth for curl request
     *
     * @param string $type
     * @param mixed $credentials
     * @return $this
     * @throws \Exception
     */
    public function setAuthentification($type, $credentials)
    {
        if (!in_array($type, array('Bearer', 'Basic', 'Token'))) {
            throw new \Exception('Not supported auth type');
        }

        if ($type === 'Basic') {
            if (!isset($credentials['username']) || !isset($credentials['password']))) {
                throw new \Exception('You must provide a username and a password for Basic auth');
            }
            $credentials = base64_encode($credentials['username'].':'.$credentials['password']);
        }

        $this->curl->setAuthentication($type, $credentials);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($url, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'GET', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function post($url, $payload, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'POST', $options, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function put($url, $payload, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'PUT', $options, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($url, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'DELETE', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function head($url, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'HEAD', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function options($url, $payload, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'OPTIONS', $options, $payload);
    }

    /**
     * {@inheritdoc}
     */
    public function trace($url, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'TRACE', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function connect($url, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'CONNECT', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($url, $payload, array $options = array()) {
        $url = (is_null($this->endpoint)) ? $url : $this->endpoint.$url;
        return $this->curl->sendRequest($url, 'PATCH', $options, $payload);
    }

    /**
     * sets the content type
     *
     * @param  $contentType
     * @return $this
     */
    public function setContentType($contentType) {
        $this->curl->setContentType($contentType);
        return $this;
    }

    /**
     * Clear curl request headers
     *
     * @return $this
     */
    public function clearHeaders()
    {
        $this->curl->clearHeaders();
        return $this;
    }
}