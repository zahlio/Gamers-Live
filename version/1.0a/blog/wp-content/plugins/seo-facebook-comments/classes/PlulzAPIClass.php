<?php
/*
 * Class Name: Plulz
 * Reference URI: http://www.plulz.com
 * Copyright 2011  Fabio Alves Zaffani ( email : fabiozaffani@gmail.com )
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 */

// Make sure there is no bizarre coincidence of someone creating a class with the exactly same name of this plugin
if ( !class_exists("PlulzAPI") )
{
	class PlulzAPI
	{
        /**
         * Default curl options
         * @var array
         */
        public static $CURLOPT = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_USERAGENT      => 'plulz-php-1.0'
        );

        /**
         * Default domain links from Plulz
         * @var array
         */
        public static $DOMAIN = array(
            'www'   =>  'http://www.plulz.com',
            'feed'  =>  'http://www.plulz.com/feed',
            'api'   =>  'http://api.plulz.com'
        );

        /**
         * Method responsible for checking and connecting to the pazzani tech API
         * @param array $args
         * @param array|string $params

         *
         * @return array
         */
        protected function _requestAPI( $args, $params = array() )
        {
            // First check if curl is enabled
            if ( !function_exists('curl_init') )
                throw new Exception('PlulzAPI needs the CURL PHP extension.');

            $default = array(
                'api'   =>  0,
                'feed'  =>  1
            );

            // overwrite the default values (if there is any new values)
            if ( is_array($args) )
                $services = array_merge( $default, $args );
            else
                $services = $default;

            if ($services['api'])
            {
                if ( !empty($params) )
                {
                    $api = curl_init();
                    $apiOpts = self::$CURLOPT;

                    $apiOpts[CURLOPT_URL] = self::$DOMAIN['api'];
                    $apiOpts[CURLOPT_POST] = 1;
                    $apiOpts[CURLOPT_POSTFIELDS] = http_build_query($params, null, '&');
                    $apiOpts[CURLOPT_HTTPHEADER] = array("Content-Type: application/x-www-form-urlencoded; charset=UTF-8");

                    curl_setopt_array($api, $apiOpts);

                    $apiResults = curl_exec($api);

                    curl_close($api);
                }
                else
                    $apiResults = 'You need to send some params to fetch from the API';
            }

            if ($services['feed'])
            {
                $feed = curl_init();
                $feedOpts = self::$CURLOPT;

                $feedOpts[CURLOPT_URL] = self::$DOMAIN['feed'];

                curl_setopt_array($feed, $feedOpts);

                $feedResults = curl_exec($feed);

                curl_close($feed);
            }

            return array(
                    'api'   =>  isset($apiResults) ? $apiResults : '',
                    'feed'  =>  isset($feedResults) ? $feedResults : ''
            );
        }

        /**
         *
         * Get the latest news from Pazzani Tech blog
         * @return xml
         */
        public function fetchRSS()
        {
            $args = array(
                'feed'     =>  1
            );

            $results = $this->_requestAPI( $args );
            
            // Return the fetched XML converted to an SimpleXML object
            if ( $results['feed'] && !empty($results['feed']) )
                return simplexml_load_string($results['feed']);
            else
                return false;
        }

        /**
         *
         * Method that returns the newest releases plugins from Plulz
         * @param $args
         * @return array
         */
        public function fetchApi( $args )
        {
            if (empty($args))
                return false;

            $services = array(
                            'feed'  =>  0,
                            'api'   =>  1
                        );

            if (is_array($args))
            {
                foreach ($args as $key => $value) // the params passed could be like 'help' => true or type => 'xml'..
                    $data[$key] = $value;
            }
            else
                $data = array($args => true);

            $results = $this->_requestAPI($services, $data);

            // Return the fetched XML converted to an object
            if ( $results['api'] && !empty($results['api']) )
                return simplexml_load_string($results['api']);
            else
                return false;

        }
    }
}