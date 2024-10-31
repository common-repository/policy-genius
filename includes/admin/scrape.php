<?php
$options = get_option('private_policy_data');
function getScrapData() {
	$page = get_pages();
	$data  = array();
	foreach($page as $key=>$val) {
		$page_url = get_permalink($val->ID);
		$postID= $val->ID;
		if($page_url==site_url()."/profile/") { continue; } if($page_url==site_url()."/privacy-policy/") { continue; }
		if($page_url!==site_url()."/profile/"){
		$data[$postID] = scrapPage(get_permalink($val->ID)); }
	}
return $data; 	
}

if(isset($_POST['refresh'])) {
	ob_start();
	$data2 = getScrapData(); 
	$scrapArray = array();
	foreach($data2 as $key=>$val2) {
		if(!empty($val2)){		
				if($val2->length > 0){	
				  foreach($val2 as $row){
					   $phrase = htmlentities($row->nodeValue);
						$healthy = ["Get Started", "Loading...", "Registeration", "Sign up", "submit","Log In"];
						$yummy   = ["", "", "", "", "", ""];
						$newPhrase = str_replace($healthy, $yummy, $phrase);
						$scrapArray[] = array("postID"=>$key,"content"=>$newPhrase);
				  }
				  
				}
		}	
	
	}
    delete_option('private_policy_data');
	add_option( "private_policy_data", $scrapArray  );
	ob_clean();
}
if(empty($options)) {
   $scrapArray = array();
    $data = getScrapData();
	echo "<div class='site_audit_container'>";	
     echo "<table class='audit_url_table'>";
			foreach($data as $key=>$val2) {
				if(!empty($val2)){		
				if($val2->length > 0){	
					
					foreach($val2 as $row){
					echo "<tr> <td> <a class='audit_page_url' href='".get_permalink($key)."' target='_blank'>".get_the_title($key)."</a></td>";	
						$phrase = htmlentities($row->nodeValue);
						
						$healthy = ["Get Started", "Loading...", "Registeration", "Sign up", "submit","Log In"];
						$yummy   = ["", "", "", "", "", ""];
						$newPhrase = str_replace($healthy, $yummy, $phrase);
						$scrapArray[] = array("postID"=>$key,"content"=>$newPhrase);
						echo "<td><p class='fields'>".$newPhrase . "</p></td><tr>";
					}
					
				}	
				}
			}

	 echo "</table>";	
	echo"</div>";
	add_option( "private_policy_data", $scrapArray  );
} else {
	echo "<div class='site_audit_container options'>";	
     echo "<table class='audit_url_table'>";	
	     foreach($options as $row){
		   echo "<tr> <td> <a class='audit_page_url' href='".get_permalink($row['postID'])."' target='_blank'>".get_the_title($row['postID'])."</a></td>";	
		   echo "<td><p class='fields'>".$row['content'] . "</p></td><tr>";
		 }
	
		 echo "</table>";	
	echo"</div>";
	
	}
if(isset($_REQUEST['tab']) && $_REQUEST['tab']=="audit") {	
echo "</form><form method='POST' action='".site_url()."/wp-admin/admin.php?page=privacy_guru&tab=audit' class='refresh_scrap'>";
echo"<input type='hidden' name='refresh' value='refresh'>";
echo"<input type='submit' value='Refresh' name='refresh' class='button button-primary'>";
echo"</form>"; }	



function scrapPage($url) {	
$html= file_get_contents($url); //get the html returned from the following url

$pokemon_doc = new DOMDocument();

libxml_use_internal_errors(TRUE); //disable libxml errors
if(!empty($html)){ //if any html is actually returned

	$pokemon_doc->loadHTML($html);
	libxml_clear_errors(); //remove errors for yucky html
	
	$pokemon_xpath = new DOMXPath($pokemon_doc);
	//get all the h2's with an id
	return $pokemon_row = $pokemon_xpath->query('//form');
  }
 }
 
 
?>