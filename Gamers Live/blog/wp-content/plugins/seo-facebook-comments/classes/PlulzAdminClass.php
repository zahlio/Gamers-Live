<?php

// Make sure there is no bizarre coincidence of someone creating a class with the exactly same name of this plugin
if ( !class_exists("SEOFacebookCommentsAdmin") )
{
    class SEOFacebookCommentsAdmin extends PlulzAPI
    {
        protected $pluginAdminPage;
        protected $menuPageCSS;
        protected $name;
        protected $group;
        protected $css;
        protected $pageOptions = array();
        protected $options;
        protected $action;
        protected $adminStylesheet;
        protected $wordpressLinks;

        /**
         * Appends the methods to the Wordpress Admin Hooks
         * @return void
         */
        public function __construct()
        {
            if ( is_admin() )
            {
                add_action( 'init', array( &$this, 'adminReceiver' ) );

                add_action( 'admin_init', array( &$this, 'register' ) );

                add_action( 'admin_notices', array( &$this, 'welcomeMessage' ) );

                add_action( 'wp_dashboard_setup', array( &$this, 'hookDashboard' ) );

                if ( !empty($this->menuPage) )
                    add_action( 'admin_menu', array( &$this, 'page' ));
            }

            $this->_init();
        }

        /**
         *
         * Method that initializes/redirect all the values for the classe properties
         * @return void
         */
        protected function _init()
        {
            if (empty($this->name))
                throw new Exception('You must define the $name property');

            if (empty($this->group))
                throw new Exception('You must define the $group property');

            if (empty($this->pluginAdminPage))
                throw new Exception('You must configure the $pluginAdminPage string for this plugin to work');

            if (empty($this->action))
                throw new Exception('Must define the $action property otherwise the options wont be saved on the admin');
        }

        /**
         *
         * This method is used to check if theres any post request to save info for example on the database
         * appended to the init action
         *
         * @return void
         */
        public function adminReceiver()
        {
            // Check the referer, only our page plugins can access this method
            if ( !isset($_POST) )
                return;

            $referer = wp_get_referer();

            // We only want to use this method if the from page is our plugin
            if ($referer != $_POST['_wp_http_referer'])
                return;
        }

        /**
         *
         * Method that register the Plugin dependencies to be rendered on the admin panel of the blog
         * this method must be called on the admin_init hook
         * @return void
         */
        public function register()
        {
            register_setting( $this->group, $this->name );
            wp_enqueue_script( 'dashboard' );
            wp_enqueue_script( 'postbox' );
            wp_enqueue_script( 'thickbox' );
        }

        /**
         *
         * Method to add the facebook in the left menu panel of wordpress
         * @return void
         */
        public function page()
        {
            // @ref http://codex.wordpress.org/Function_Reference/add_menu_page
            $menuPageCSS = add_menu_page(
                               $this->menuPage['page_title'],                // $page_title
                               $this->menuPage['menu_title'],                // $menu_title
                               $this->menuPage['capability'],               // $capability
                               $this->menuPage['menu_slug'],                // $menu_slug
                               array(&$this, 'adminMenuPageOutputHTML'),    // $function
                               $this->menuPage['icon_url']                // $icon_url
                            );

            // Only register if we want to embed a custom stylesheet for the plugin admin pages
            if ( !empty($this->adminStylesheet) )
            {
                wp_register_style( $this->adminStylesheet['name'], $this->adminStylesheet['filedir'] . 'plulz-admin-style.css');
                add_action( 'admin_print_styles-' . $menuPageCSS , array( &$this, 'addAdminStyles' )  );
            }

            $submenu = $this->menuPage['submenus'];

            if ( isset($submenu) && is_array($submenu) && !empty($submenu) )
            {
                foreach($submenu as $menu)
                {
                    add_submenu_page(
                        $this->menuPage['menu_slug'],   // $parent_slug
                        $menu['page_title'],            // $page_title
                        $menu['menu_title'],            // $menu_title
                        $menu['capability'],            // $capability
                        $menu['menu_slug'],             // $menu_slug
                        $menu['function']               // $function
                    );
                }
            }
        }

        /**
         *
         * Method usefull to output mesages and/or warnings to the users when the plugin is active
         * have to be implemented in the children class
         * @return void
         */
        public function welcomeMessage()
        {}

        /**
         * Output Wordpress Admin stylesheets
         * @return void
         */
        public function addAdminStyles()
        {

            wp_enqueue_style( $this->adminStylesheet['name'] );
        }

        /**
         *
         * Method to register the options page available in the Admin for the plugin
         * @return void
         */
        public function adminMenuPageOutputHTML()
        {
            $url = self::$DOMAIN['www'];

            echo "<div id='plulzwrapper' class='wrap'>";
            echo "<a id='plulzico' href='{$url}' target='_blank'> {$this->menuPage['page_title']} </a>";
            echo "<h2>{$this->menuPage['page_title']}</h2>";

            $this->generalConfigMetabox();

            $this->adminSidebarOutputHMTL();

            echo "</div>"; // Close .wrap
        }

        /**
         * Method that outputs the generalConfig settings for the form, only needed if the plugin uses at least one
         * admin configuration page (when the hook for the page() method is uncommented
         * @return void
         */
        public function generalConfigMetabox()
        {
            throw new Exception('You must implement the method adminMenuPageOutputHTML');
        }

        /**
         *
         * Method that outputs a sidebar block on plugins admin configuration pages
         * @param array $args
         * @return void
         */
        public function adminSidebarOutputHMTL( $args = array() )
        {

            $toFetch = array(
                'type'      =>  'xml',
                'plugin'    =>  $this->name,
                'help'      =>  true,
                'donate'    =>  true,
                'loved'     =>  true
            );

            $default = array(
                'loved', 'donate', 'help'
            );

            $boxes = empty($args) ? $default : $args;

            $links = $this->fetchApi( $toFetch );

            $this->_createMetabox('29%');

            foreach($boxes as $box)
            {
                $function = '_' . $box;

                if($links)
                    $this->$function( $links->$box );
                else
                    $this->$function();
            }

            $this->_closeMetabox();
        }

        /*
         * This method creates the opening for the metaboxes
         * @param string $width
         * @return void;
         */
        protected function _createMetabox( $width = '50%' )
        {
            $html = "<div class='postbox-container' style='width:{$width}'>" .
                    "<div class='metabox-holder'>" .
                    "<div class='meta-box-sortables ui-sortable'>";
            echo $html;
        }

        /*
         * Method that provides the close for the _createMetabox function
         * @return void
         */
        protected function _closeMetabox()
        {
            $html = "</div></div></div>";
            echo $html;
        }

         /*
         * This method show options in the admin page about the creator, donations and helpfull links
         *
         * @return void
         */
        protected function _help( $helpLinks = null )
        {
            $html = "<div id='help' class='postbox'>" .
                        "<div class='handlediv' title='Click to Toggle'><br/></div>" .
                        "<h3 class='hndle'>Need Assistance?</h3>" .
                        "<div class='inside'>" .
                            "<p>Problems? The links bellow can be very helpful to you</p>" .
                            "<ul>";

            if (!$helpLinks)    // Api is unreachable or slow
            {
                $html .=    "<li><a href='http://wordpress.org/tags/{$this->wordpressLink}' target='_blank'>Wordpress Help Forum</a></li>";
            }
            else
            {
                foreach( $helpLinks->node as $element )
                {
                    $url = (string)$element->url;
                    $title = (string)$element->title;

                    if( !empty($url) && !empty($title) )
                        $html .= "<li><a href='{$url}' target='_blank' > {$title} </a></li>";
                }
            }
            $html .=        "</ul>" .
                        "</div>" .
                    "</div>";

            echo $html;
        }

        /*
         * This method show options in the admin page about the creator, donations and helpfull links
         *
         * @return void
         */
        protected function _loved( $links )
        {

            $html = "<div id='links' class='postbox'>" .
                        "<div class='handlediv' title='Click to Toggle'><br/></div>" .
                        "<h3 class='hndle'>Loved this Plugin?</h3>" .
                        "<div class='inside'>" .
                            "<p>Below are some links to help spread this plugin to other users</p>" .
                            "<ul>";

            if (!$links)    // Api is unreachable or slow
            {
                $html .=    "<li><a href='http://wordpress.org/extend/plugins/{$this->wordpressLink}' target='_blank'>Give it a 5 star on Wordpress.org</a></li>" .
                            "<li><a href='http://wordpress.org/extend/plugins/{$this->wordpressLink}' target='_blank'>Link to it so others can easily find it</a></li>";
            }
            else
            {
                foreach( $links->node as $element )
                {
                    $url = (string)$element->url;
                    $title = (string)$element->title;

                    if( !empty($url) && !empty($title) )
                        $html .= "<li><a href='{$url}' target='_blank' > {$title} </a></li>";
                }
            }

            $html .=        "</ul>" .
                        "</div>" .
                    "</div>";

            echo $html;
        }

        /*
         * This method show options in the admin page about the creator, donations and helpfull links
         *
         * @return void
         */
        protected function _donate( $donateLinks = null )
        {
            $html = "<div id='donate' class='postbox'>" .
                        "<div class='handlediv' title='Click to Toggle'><br/></div>" .
                        "<h3 class='hndle'>Donate via PayPal</h3>" .
                        "<div class='inside'>";
            
            if ( $donateLinks && is_string($donateLinks->description) )
                $html .= "<p>{$donateLinks->description}</p>";
            else
                $html .= "<p>I spend a lot of time making and improving this plugin, any donation would be very helpful for me, thank you very much :)</p>";

            if ( $donateLinks && is_string($donateLinks->form) )
                $html .= "{$donateLinks->form}";
            else
                $html .= '<form id="paypalform" action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="NMR62HAEAHCRL"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1"></form>';

            $html .=    "</div>" .
                    "</div>";
            echo $html;
        }

        /**
         * Method that returns the current value for the input field, accept any kinda of array
         * @param $name
         * @param $arrayToParse
         * @return string
         */
        protected function _getInputValue( $name, $arrayToParse )
        {
            $valueArr = ''; // string
            if ( is_array($name) && is_numeric(implode("", array_keys($name)))) // NOT ASSOCIATIVE ARRAY
            {
                if(count($name) > 1)
                    $valueArr = $this->_getInputValue(array_slice($name, 1), $arrayToParse[$name[0]]);
                else
                    $valueArr = $arrayToParse[$name[0]];
            }
            else if (is_array($name))   // ASSOCIATIVE ARRAYS
            {
                $key = key($name);
                $valueArr = $arrayToParse["{$key}"]["{$name[$key]}"];
            }
            else
            {
                $valueArr = $arrayToParse["{$name}"];
            }

            return $valueArr;
        }
        /**
         *
         * This method handle any nested level possible from the name attribute of the admin input fields
         * @param string|array (required) $name
         * @return string
         */
        protected function _createInputName( $name )
        {
            $nameArr = '';
            if ( is_array($name) && is_numeric(implode("", array_keys($name)))) // NOT ASSOCIATIVE ARRAY
            {
                foreach($name as $current)
                    $nameArr .= '[' . $current . ']';

                $nameArr = $this->name . $nameArr;
            }
            else if (is_array($name))   // ASSOCIATIVE ARRAYS
            {
                $key = key($name);
                $nameArr = $this->name . '[' . $key . ']' . '[' . $name[$key] . ']';
            }
            else
            {
                $nameArr = $this->name . '[' . $name . ']';
            }

            return $nameArr;
        }

        /*
         * Protected method to make life easier when outputing <input> of any type
         *
         * @param string(required) $type for the type of the input
         * @param string(required) $name
         * @param string(required) $required
         * @param string(required) $id
         * @param string(optional) $options a array for checkbox and select
         * @return void
         */
        protected function _addInput($type, $name, $required, $id = '', $options = '')
        {
            $arrName = $this->_createInputName($name);
            $arrValue = $this->_getInputValue($name, $this->options);

            if (empty($id))
                $id = "";
            else
                $id = " id='{$id}'";
            
            if ( $required )
                $required = ' aria-required="true"';
            else
                $required =  '';

            switch($type)
            {
                case 'text':

                      $input =  "<input name='{$arrName}' class='text' type='text' {$id}{$required} value='{$arrValue}' />";

                break;

                case 'checkbox':

                    if ( isset($arrValue) && $arrValue == '1')
                        $checked = 'checked="checked" ';
                    else
                        $checked = '';

                    $input = "<input type='checkbox' class='checkbox' name='{$arrName}' {$id} value='1' {$checked}/>";

                break;

                case 'textarea':

                    $input = "<textarea name='{$arrName}' class='textarea' {$id}{$required}' >{$arrValue}</textarea>";

                break;

                case 'radio':
                break;

                case 'select':

                    if( !is_array($options) || empty($options) )
                        return false;

                    $input = "<select name='{$arrName}'>";

                    foreach ($options as $option)
                    {
                        if ( $arrValue == $option)
                            $selected = 'selected="selected" ';
                        else
                            $selected = '';

                        $input .= "<option value='{$option}' {$selected}>{$option}</option>";
                    }

                    $input .= '</select>';

                break;
            }
            return $input;
        }

        /*
         *
         * Protected method to help output Rows in configuration metaboxes
         *
         * @param string(required) $name
         * @param string(required) $inputType
         * @param string(required) $label
         * @param string(required) $required
         * @param string(optional) $options array with options for check and select boxes
         * @return void
         */
        protected function _addRow($name, $inputType, $label, $required, $options = '', $msg = '')
        {
            $row =  (isset($required) && $required ) ? "<tr valign='top' class='form-field'>" : "<tr valign='top' class='form-field form-required'>";

            $row .= "<th scope='row'>" .
                    "<label for='{$name}'>{$label}";

            $row .= (isset($required) && $required ) ? ' <span class="description">(required)</span>' : '';

            $row .= "</label>" .
                    "</th><td>";

            $row .= $this->_addInput($inputType, $name, $required, $name, $options);

            $row .=  ( isset($msg) && !empty($msg) ) ? '<small>' . $msg . '</small>' : '';   // Lets show the msg only if it exists

            $row .= "</td></tr>";

            return $row;
        }

        /*
         * Hook functions to the Dashboard of Wordpress
         * @return void
         */
        public function hookDashboard()
        {
            // Hook latest news only if its allowed
            wp_add_dashboard_widget('PlulzDashNews', 'Plulz Latest News', array( &$this, 'dashboardNews'));

            // Lets try to make our widget goes to the top
            global $wp_meta_boxes;

            // Get the regular dashboard widgets array
            // (which has our new widget already but at the end)
            $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

            // Backup and delete our new dashbaord widget from the end of the array
            $example_widget_backup = array('PlulzDashNews' => $normal_dashboard['PlulzDashNews']);
            unset($normal_dashboard['PlulzDashNews']);

            // Merge the two arrays together so our widget is at the beginning
            $sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

            // Save the sorted array back into the original metaboxes
            $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
        }


       /*
         * This method show the latest news (through xml) from the plulz blog on the wordpress dashboard
         *
         * @return void
         */
        public function dashboardNews()
        {
            $news = $this->fetchRSS();

            // If somethings wrong with the feed, lets quietly leave this function...
            if (!$news)
                return;

            $maxHeadlines = 4;

            $output = '<ul>';

            // Atom or RSS ?
            if (isset($news->channel)) // RSS
            {
                for($i=0; $i<$maxHeadlines; $i++)
                {
                    $url 	= $news->channel->item[$i]->link;
                    $title 	= $news->channel->item[$i]->title;
                    $desc = $news->channel->item[$i]->description;

                    $output .= '<li><a class="rsswidget" href="'.$url.'">'.$title.'</a><div class="rssSummary">'.$desc.'</div></li>';
                }

            }
            else if (isset($news->entry)) // ATOM
            {

                for($i=0; $i<$maxHeadlines; $i++)
                {
                    $urlAtt = $news->entry->link[$i]->attributes();
                    $url	= $urlAtt['href'];
                    $title 	= $news->entry->title;
                    $desc	= strip_tags($news->entry->content);

                   $output .= '<li><a class="rsswidget" href="'.$url.'">'.$title.'</a><div class="rssSummary">'.$desc.'</div></li>';
                }
            }

            $output .=  '</ul>' .
                        '<br class="clear" />' .
                        '<div style="margin-top:10px;border-top:1px solid #ddd;padding-top:10px;text-align:left;position:relative">' .
                        '<img src="' . $this->menuPage['icon_url'] . '" style="position:absolute;bottom:0;left:0;" /><a href=' . self::$DOMAIN['www'] . ' style="padding-left:16px;");">Wordpress Plugins at Plulz</a>' .
                        '</div>';

            echo $output;
        }

        /**
         * Method that replace the default configurations
         *
         * @param array $defaultOptions
         * @param array $newOptions
         * @return array $output
         */
        protected function _replaceDefaults($defaultOptions, $newOptions)
        {
            foreach($newOptions as $name => $value)
            {
                $defaultOptions[$name] = $newOptions[$name];
            }

            return $defaultOptions;
        }
    }
}