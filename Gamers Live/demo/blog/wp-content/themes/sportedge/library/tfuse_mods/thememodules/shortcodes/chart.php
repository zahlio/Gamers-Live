<?php
// ***********************Chart
function tfuse_chart($atts) {

	//extract short code attr
	extract(shortcode_atts(array('width' => 590,'height' => 250,'type' => '','title' => '','data' => '',
                                'legend' => '','label' => '', 'colors' => ''), $atts));
	
	switch($type)
	{
        case '3dpie': $type = 'p3';  break;
		case 'pie':   $type = 'p';   break;
		case 'lc':  $type = 'lc';  break;
		case 'bar':   $type = 'bvg'; break;
        default : $type = 'p3';  
	}
	if ($type == 'p3' || $type == 'p')
    {
	    $return_html = '<p><img class="noborder"  src="http://chart.apis.google.com/chart?chxs=0,555555,11.5&chxt=x&chs='.$width.'x'.$height.'&cht='.$type.'&#038;chtt='.$title.'&#038;chl='.$label.'&#038;chco='.$colors.'&#038;chs='.$width.'x'.$height.'&#038;chd=t:'.$data.'&chdl='.$legend.'&#038;chf=bg,s, '.$colors.'" alt="'.$title.'"  /></p>';
	}
    elseif ($type == 'lc')
    {
        $return_html = '<p><img class="noborder" src="http://chart.apis.google.com/chart?chs='.$width.'x'.$height.'&cht=lc&chl='.$label.'&cht=lxy&chco='.$colors.'&chd=s:_,mehmtt3sro&chdlp=b&chg=4,1,0,5&chls=1&chma=|0,10&chtt='.$title.'&chts=676767,13.5" width="'.$width.'" height="'.$height.'" alt="'.$title.'" /></p>';

    }
    elseif ($type == 'bvg')
    {
        $return_html = '<p><img class="noborder"  src="http://chart.apis.google.com/chart?chbh=a&chs='.$width.'x'.$height.'&cht=bvs&chco='.$colors.'&chd=s:mehmtt3sro&chdl='.$legend.'&chdlp=b&chg=4,1,0,5&chma=|0,10&chtt='.$title.'&chts=676767,13.5" width="'.$width.'" height="'.$height.'" alt="'.$title.'" /></p>';
	                                                           
    }
    else
    {
	    $return_html = '<p><img class="noborder"  src="http://chart.apis.google.com/chart?chxs=0,555555,11.5&chxt=x&chs='.$width.'x'.$height.'&cht='.$type.'&#038;chtt='.$title.'&#038;chl='.$label.'&#038;chco='.$colors.'&#038;chs='.$width.'x'.$height.'&#038;chd=t:'.$data.'&chdl='.$legend.'&#038;chf=bg,s, '.$colors.'" alt="'.$title.'"  /></p>';
    }

    return apply_filters('tfuse_chart', $return_html);
}
add_shortcode('chart', 'tfuse_chart');

?>