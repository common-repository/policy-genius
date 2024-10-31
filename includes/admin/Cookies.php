<?php
function get_website_cookies ( $paras = '', $content = '' ) {
    if ( strtolower( @$paras[ 0 ] ) == 'novalue' ) { $novalue = true; } else { $novalue = false; }

    if ( $content == '' ) { $seperator = ' : '; } else { $seperator = $content; }

    $cookie = $_COOKIE;
    ksort( $cookie );
	$cookieArray = array();
		foreach ( $cookie as $key => $val ) {
			if(!empty($val)){ $cookieArray[$key] = $val; }
		}
	delete_option("privacy_policy_cookies");	
	add_option("privacy_policy_cookies", $cookieArray);
	return $cookieArray;	
}

get_website_cookies();
// $siteData = site_register_thirdParty2();
// echo"<pre>"; print_r($siteData); echo"</pre>"; echo "xxsd"; 
$PrivacyOptions = get_option('privacy_policy_cookies'); 

?>
<table class="cookie_url_table">
   <tbody>
   <tr><th>Cookie Name</th><th>Cookie Value</th></tr>
    <?php foreach($PrivacyOptions as $key=>$val) {
		if(!empty($val)) {
		?>

      <tr>
         <td> <?php echo @$key; ?></td>
         <td>
            <p class="fields"> <?php echo @$val; ?></p>
         </td>
      </tr>
	<?php } } ?>
<tbody>
</table>
