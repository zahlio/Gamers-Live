if (styleid != 0 && styleid == 'icon_tabs' ){
tagtext = "["+ styleid + " title=\"Title\"]\n" +
"\t[tab icon=\"images/icons/icon_1.png\" width=\"51\" height=\"42\"]Insert your text here[/tab]\n" +
"\t[tab icon=\"images/icons/icon_2.png\" title=\"optional\" width=\"51\" height=\"42\"]You can add another shortcodes in content[/tab]\n" +
"\t[tab icon=\"images/icons/icon_3.png\" title=\"optional\" width=\"51\" height=\"42\"]Your text here[/tab]\n" +
"[/" + styleid + "]\n";
}


if (styleid != 0 && styleid == 'framed_tabs' ){
tagtext = "["+ styleid + "]\n" +
"\t[tab title=\"Tab 1\"]Insert your text here[/tab]\n" +
"\t[tab title=\"Tab 2\"]You can add another shortcodes in content[/tab]\n" +
"\t[tab title=\"Tab 3\"]Your text here[/tab]\n" +
"[/" + styleid + "]\n";
}

if (styleid != 0 && styleid == 'faq' ){
tagtext = "["+ styleid + "]\n" +
"\t[faq_question]Question[/faq_question]\n" +
"\t[faq_answer]Answer[/faq_answer]\n" +
"[/" + styleid + "]\n";
}


if (styleid != 0 && styleid == 'button' ){
tagtext = "["+ styleid + " link=\"#\" style=\"light_gray\"]Read More[/" + styleid + "]";
}

if (styleid != 0 && styleid == 'minigallery' ){
tagtext = "["+ styleid + " id=\"PostID\" style=\"box border box_white\"]";
}


if (styleid != 0 && (styleid == 'dropcap1' || styleid == 'dropcap2' ) ){
tagtext = "["+ styleid + "]A[/" + styleid + "]";
}


if (styleid != 0 && (styleid == 'check_list' || styleid == 'delete_list' || styleid == 'arrow_list')){
tagtext = "["+ styleid + "]\r<ul>\r<li>Item #1</li>\r<li>Item #2</li>\r<li>Item #3</li>\r</ul>\r[/" + styleid + "]";
}


if (styleid != 0 && styleid == 'download_box' ){
tagtext = "["+ styleid + " style=\"box_gray border\"]Place your own text here[/" + styleid + "]";
}


if (styleid != 0 && styleid == 'info_box' ){
tagtext = "["+ styleid + " style=\"box_blue border\"]Place your own text here[/" + styleid + "]";
}


if (styleid != 0 && styleid == 'warning_box' ){
tagtext = "["+ styleid + " style=\"box_green border\"]Place your own text here[/" + styleid + "]";
}


if (styleid != 0 && styleid == 'note_box' ){
tagtext = "["+ styleid + " style=\"box_light_gray border\"]Information Styled Box (Can contain other shortcodes)[/" + styleid + "]";
}


if (styleid != 0 && styleid == 'toggle_content' ){
tagtext = "["+ styleid + " title=\"Toggle Content (click to open)\"]Insert your text here[/" + styleid + "]";
}

if (styleid != 0 && styleid == 'toggle_code' ){
tagtext = "["+ styleid + " title=\"Get The Code\"]\rInsert your code here\r[/" + styleid + "]";
}

if (styleid != 0 && styleid == 'code' ){
tagtext = "["+ styleid + "]Insert your code here[/" + styleid + "]";
}

if (styleid != 0 && styleid == 'row' ){
tagtext = "["+ styleid + "]\rInsert your columns here\r[/" + styleid + "]";
}

if (styleid != 0 && styleid == 'link_more' ){
tagtext = "["+ styleid + " url=\"#\"]";
}


if (styleid != 0 && (styleid == 'quote_right' || styleid == 'quote_left')){
tagtext = "["+ styleid + "]quote text here...[/" + styleid + "]";
}


if (styleid != 0 && styleid == 'row_box'){
tagtext = "["+ styleid + " style=\"box border box_light_gray\"]Insert here another shortcodes[/" + styleid + "]\r[divider_space]";
}


if (styleid != 0 && (styleid == 'col_1_2' || styleid == 'col_1_3' || styleid == 'col_1_4' || styleid == 'col_1_5' || styleid == 'col_2_3' || styleid == 'col_2_5' || styleid == 'col_3_5')){
tagtext = "["+ styleid + " style=\"box border box_blue\"]Insert your text here[/" + styleid + "]";
}


if (styleid != 0 && (styleid == 'divider_space' || styleid == 'divider' || styleid == 'divider_thin'
|| styleid == 'clear' || styleid == 'clearboth' || styleid == 'search' || styleid == 'icon_check'
|| styleid == 'icon_x' || styleid == 'testimonials' || styleid == 'newsletter')){
tagtext = "["+ styleid + "]";
}


if (styleid != 0 && styleid == 'frame_left' || styleid == 'frame_right' || styleid == 'frame_center' ){
tagtext = "["+ styleid + "]Insert the full URL path to your image[/" + styleid + "]";
}


