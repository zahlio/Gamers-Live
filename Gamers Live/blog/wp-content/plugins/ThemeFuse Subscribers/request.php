<?php
  		if (isset ($_GET['title']) && $_GET['title']) $title = $_GET['title']; else $title = '';
		if (isset ($_GET['facebook']) && $_GET['facebook']) $facebook = $_GET['facebook']; else $facebook = '';
		if (isset ($_GET['twitter']) && $_GET['twitter']) $twitter = $_GET['twitter']; else $twitter = '';
		//if (isset ($_GET['stumbleupon']) && $_GET['stumbleupon']) $stumbleupon = $_GET['stumbleupon']; else $stumbleupon = '';
		if (isset ($_GET['in']) && $_GET['in']) $in = $_GET['in']; else $in = '';
		if (isset ($_GET['rss']) && $_GET['rss']) $rss = $_GET['rss']; else $rss = '';
		if (isset ($_GET['vimeo']) && $_GET['vimeo']) $vimeo = $_GET['vimeo']; else $vimeo = '';
		if (isset ($_GET['youtube']) && $_GET['youtube']) $youtube = $_GET['youtube']; else $youtube = '';
		if (isset ($_GET['style']) && $_GET['style']) $style = $_GET['style']; else $style = 'v1';

        $facebook_count = '';
        $twitter_count = '';
       // $stumbleupon_count = '';
        $in_count = '';
        $rss_count = '';
        $vimeo_count = '';
        $youtube_count = '';

        if (isset($twitter) && $twitter!='')
        {
            $getData = 'followers_count';
            $xml = file_get_contents('http://twitter.com/users/show.xml?screen_name=' . $twitter);
            if ($xml)
            {
                if(preg_match('/' . $getData . '>(.*)</', $xml, $match) !=0)
                $twitter_count = $match[1];
            }

        }

        if (isset($youtube) && $youtube!='')
        {
            $JSON = file_get_contents("http://gdata.youtube.com/feeds/api/videos?q={$youtube}&alt=json");
            if ($JSON)
            {
                $JSON_Data = json_decode($JSON);
                $youtube_count = $JSON_Data->{'feed'}->{'entry'}[0]->{'yt$statistics'}->{'favoriteCount'};
            }

        }

       /* if (isset($stumbleupon) && $stumbleupon != '')
        {
            $JSON = file_get_contents("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=" . $stumbleupon );
            $JSON_Data = json_decode($JSON);
            $stumbleupon_count = $JSON_Data->result->views;
        }*/

        if (isset($vimeo) && $vimeo != '')
        {
            $JSON = file_get_contents("http://vimeo.com/api/v2/video/" . $vimeo . ".json");
            if ($JSON)
            {
                $JSON_Data = json_decode($JSON);
                $vimeo_count = $JSON_Data[0]->stats_number_of_likes;
            }

        }

        if (isset($rss) && $rss != '')
        {
            $fburl='http://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=' . $rss;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $fburl);
            $stored = curl_exec($ch);
            curl_close($ch);
            $grid = new SimpleXMLElement($stored);
            $rss_count = $grid->feed->entry['circulation'];
            if ($rss_count == 0) $rss_count = '';
        }

        if (isset($facebook) && $facebook !='')
        {
            $JSON = file_get_contents("http://graph.facebook.com/" . $facebook );
            if ($JSON)
            {
                $JSON_Data = json_decode($JSON);
                $facebook_count = $JSON_Data->likes;
            }

        }

        if (isset($in) && $in != '')
        {
            $JSON = file_get_contents("http://www.linkedin.com/cws/share-count?url=http://" . $in );
            if ($JSON)
            {
                $JSON = str_replace('IN.Tags.Share.handleCount(', '', $JSON);
                $JSON_Data = json_decode($JSON);
                $in_count = $JSON_Data->count;
                if ($in_count == 0) $in_count = '';
            }

        }


        $total_count = 0;
        if (is_numeric($twitter_count)) $total_count += intval($twitter_count);
        if (is_numeric($youtube_count)) $total_count += intval($youtube_count);
       // if (is_numeric($stumbleupon_count)) $total_count += intval($stumbleupon_count);
        if (is_numeric($vimeo_count)) $total_count += intval($vimeo_count);
        if ($rss_count != '') $total_count += intval($rss_count);
        if (is_numeric($facebook_count)) $total_count += intval($facebook_count);
        if (is_numeric($in_count)) $total_count += intval($in_count);

        $output ='';
        if ($style == 'v1')
        {
            $output .= '<div class="footer_social">';
            $output .= '<h3>' . $title . '</h3>';
                if (is_numeric($facebook_count)) $output .= '<a href="http://www.facebook.com/' . $facebook . '" class="icon-facebook" target="_blank">Facebook</a> ';
                if (is_numeric($twitter_count)) $output .= '<a href="http://twitter.com/#!/' . $twitter . '" class="icon-twitter" target="_blank">Twitter</a>' ;
                if (is_numeric($vimeo_count)) $output .= '<a href="http://vimeo.com/' . $vimeo . '" class="icon-vimeo" target="_blank">Vimeo</a>' ;
                if (is_numeric($youtube_count)) $output .= '<a href="http://www.youtube.com/watch?v=' . $youtube . '" class="icon-youtube" target="_blank">Youtube</a>' ;
                if ($rss_count != '') $output .= '<a href="#" class="icon-rss" onclick="return false;">RSS</a>' ;
                if (is_numeric($in_count)) $output .= '<a href="#" class="icon-in" onclick="return false;">IN</a>' ;
            $output .=' <div class="clear"></div>';
            $output .= '<span class="link-readers">' . $total_count . '  Readers</span>';
            $output .='</div>';
        }

        /*<h3>Follow us</h3>
        <div class="footer_social">
        	<a href="#" class="icon-facebook">Facebook</a>
            <a href="#" class="icon-twitter">Twitter</a>
            <a href="#" class="icon-vimeo">Vimeo</a>
            <a href="#" class="icon-flickr">Flickr</a>
            <a href="#" class="icon-rss">RSS</a>
            <div class="clear"></div>
			<span class="link-readers">24,336  Readers</span>
        </div>   */


        echo $output;




?>