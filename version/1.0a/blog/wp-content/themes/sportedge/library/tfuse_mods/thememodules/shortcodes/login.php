<?php
//************************************* Autentificate
function tfuse_login($atts, $content = null)
{

      $return_html = '';
        if ( ! is_user_logged_in() )
        {




  $return_html .= '<div class="widget-container widget_login">
                    	<h3>' . __('Login  Form', 'tfuse') . '</h3>

                      <form action="' . home_url() . '/wp-login.php" method="post" name="loginform" id="loginform"  class="loginform">

                        <p><label>';
  $return_html .=  __('Username', 'tfuse');
  $return_html .= ' </label><br />
                        <input name="log" id="user_login" class="input" value="" size="20" tabindex="10" type="text"></p>
						<p><label>';
  $return_html .= __('Password', 'tfuse');
  $return_html .= ' </label><br /><input name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20" type="password"></p>

                        <p class="forgetmenot"><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90" />
                        <label>';
  $return_html .= __('Remember Me', 'tfuse');
  $return_html .= '</label></p>

                        <p class="forget_password"><a href="' . home_url() . '/wp-login.php?action=lostpassword">';
  $return_html .= __('Forgot Password?', 'tfuse');
  $return_html .= '</a></p>
                        <p class="submit">
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn-submit" value="LOG IN" tabindex="100" />
                            <input type="hidden" name="redirect_to" value="' . home_url() . '/wp-admin/" />
                            <input type="hidden" name="testcookie" value="1" />
                        </p>

                      </form>
                    </div>';
    }

return  $return_html;
}
add_shortcode('autentificate', 'tfuse_login');
 ?>