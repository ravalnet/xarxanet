<?php 
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/
?>
<div id="<?php print $node_id; ?>" class="<?php print $classes; ?>">
    <div class="node-inner">
        <div class="node-column-images">
		<?php
		$imatge = $node->field_agenda_imatge['und'][0];
		if(!empty($imatge)) {
			echo '	<div class="node-image">
						<a href="'.file_create_url($imatge['uri']).'" rel="lightbox" title="'.$imatge['alt'].'">'.
						theme_image_style (array('style_name' => 'imatge-article', 'path' => $imatge['uri'], 'title' => $imatge['alt'], 'alt' => $imatge['alt'])).
						'</a>
                	</div>';
		}
		?>
		<div class="more-info">
          <h2 class="minfo">Més informació</h2>
          <div class="agendainformacio">
            <?php if($node->field_organizer['und'][0]['value']):?>
              <strong>Organitzador</strong> <?php print $node->field_organizer['und'][0]['value'];?><br />
            <?php endif; ?>
            <?php if($node->field_org_adress['und'][0]['value']):?>
              <strong>Adreça de l'organitzador</strong> <?php print $field_org_adress[0]['value'];?><br/>
            <?php endif; ?>
            <?php if($node->field_org_email['und'][0]['value']):?>
              <strong>Correu</strong> <?php print $node->field_org_email['und'][0]['value'];?><br/>
            <?php endif; ?>
            <?php if($node->field_org_web['und'][0]['display_url']):?>
            <strong>URI</strong> 
            <?php
            	echo '<a href="'.$node->field_org_web['und'][0]['url'].'">'.$node->field_org_web['und'][0]['title'].'</a>';
           	?>
            <?php endif; ?>
            <?php if($node->field_link['und'][0]['value']):?>
            	<br/><br/><a class="mesinformacio" href="<?php print $node->field_link['und'][0]['value']?>">Més Informació</a>
            <?php endif; ?>
            
          </div>
          <?php 
          if (!$node->	field_esdeveniment_en_linia['und'][0]['value']){
          ?>
	          <div class="agendamapa ">
	            <?php
	            	$latitude = $node->locations[0]['latitude'];
	            	$longitude = $node->locations[0]['longitude'];
	            	$location = '' ;
	            	
	            	if ($node->locations[0]['street'] && $node->locations[0]['city']) {
						if ($node->locations[0]['name'] != '') $location .= '<b>'.$node->locations[0]['name'].'</b> <br/>';
						$location .= $node->locations[0]['street'].'<br/>'.$node->locations[0]['city'];
					} else {
						$location = $field_adreca[0]['view'];
					}            	
		            if ($latitude != 0 || $longitude != 0) {
		            	print gmap_simple_map($latitude, $longitude, '', $location, 'default', '272px', '272px');
		            }
	            ?>
	          </div>
			<?php } ?>
          <div class="agendainformacio mb">
          	<?php
          		if ($node->field_esdeveniment_en_linia['und'][0]['value']) {
					echo '<i>Esdeveniment en línia</i>';
				} else if ($location) {
					echo '<strong>Adreça</strong><br/>';
            		print strip_tags($location, '<br/>');
				}
          	?>
          </div>
        </div>

          <?php if(!empty($node->taxonomy_vocabulary_1['und'])): ?>
                <div class="node-terms">
                    <h2>Tags</h2>
                    <ul class="links tags" role="navigation">
                    <?php
						foreach($node->taxonomy_vocabulary_1['und'] as $tag) {;
						    echo '<li>'.l( ucfirst($tag['taxonomy_term']->name), 'etiquetes/general/'.str_replace(' ', '-', $tag['taxonomy_term']->name)).'</li>';						} 
                    ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php 		
			if($node->print_html_display || $node->print_mail_display || $node->print_pdf_display) {
				echo '
	                <div class="node-links block">
				    	<h2 class="block-title">'.t('Other actions').'</h2>
				    	<div class="block-content">
						<ul class="links" role="navigation">';
				if ($node->print_html_display) echo '<li class="print_html">'.l(t('Versió per imprimir'), 'print/'.$node->nid).'</li>';		
				if ($node->print_mail_display) echo '<li class="print_mail">'.l(t('Envia a un amic'), 'printmail/'.$node->nid).'</li>';
				if ($node->print_pdf_display) echo '<li class="print_pdf">'.l(t('Versió PDF'), 'printpdf/'.$node->nid).'</li>';
				
				$summary = urlencode($node->title);
				$datestart = '';
				$dateend = '';
				if (!empty($node->field_date_event['und'][0])) {
					$inici = new DateTime($node->field_date_event['und'][0]['value'], new DateTimeZone($node->field_date_event['und'][0]['timezone_db']));
					$final = new DateTime($node->field_date_event['und'][0]['value2'], new DateTimeZone($node->field_date_event['und'][0]['timezone_db']));
					$inici->setTimezone(new DateTimeZone($node->field_date_event['und'][0]['timezone']));
					$final->setTimezone(new DateTimeZone($node->field_date_event['und'][0]['timezone']));
					$datestart = urldecode($inici->getTimestamp());
					$dateend = urldecode($final->getTimestamp());
				}
				$address = urlencode(strip_tags($location));
				global $base_url;
				$uri = urlencode($base_url.url('node/'. $node->nid));
				$description = urlencode(strip_tags($field_resum[0]['value']));
				$ics_path = path_to_theme()."/scripts/ics.php";
				echo '<li class="ics">'.l(t('Afegeix a la teva agenda'), $ics_path, array('query' => array(
						'summary' => $summary,
						'datestart' => $datestart,
						'dateend' => $dateend,
						'adress' => $address,
						'description' => $description,
						'uri' => $uri))).'</li>';
				echo '</ul></div></div>';
			}
			?>	

        </div>

        <div class="node-content node-column-text">
            <?php if ($unpublished): ?>
                <div class="unpublished"><?php print t('No publicat'); ?></div>
            <?php endif; ?>

            <div class="node-intro">
                <?php print $field_resum[0]['value'] ?>
            </div><!-- .e_intro -->
             <div class="calendari">
                  <span class="floatesquerra tipusagenda"><?php print $node->field_event_type['und'][0]['value'];?></span>
                  <span class="floatdreta"><strong>Inici:</strong>
                  <?php
                  if ($node->field_date_event['und'][0]['value'] != $node->field_date_event['und'][0]['value2']):?>
                  	<?php if ($inici->format("H:i") != '00:00'):?>
                      <?php print $inici->format("d/m/Y \a \l\\e\s H:i"); ?>
                    <?php else:?>
                      <?php print $inici->format("d/m/Y \(\T\o\\t \\e\l \d\i\a\)"); ?>                      
                    <?php endif;?>
					  &nbsp;
                      <strong> Final:</strong>
                    <?php if ($final->format("H:i") != '00:00'):?>
                      <?php print $final->format("d/m/Y \a \l\\e\s H:i"); ?>
                    <?php else:?>
                      <?php print $final->format("d/m/Y \(\T\o\\t \\e\l \d\i\a\)"); ?>                      
                    <?php endif;?>
                  <?php else:?>
                    <?php if ($inici->format("H:i") != '00:00'):?>
                      <?php print $inici->format("d/m/Y \a \l\\e\s H:i"); ?>
                    <?php else:?>
                      <?php print $inici->format("d/m/Y \(\T\o\\t \\e\l \d\i\a\)"); ?>                      
                    <?php endif;?>
                  <?php endif;?>
                  </span>
             </div>
            
            <!-- Go to www.addthis.com/dashboard to customize your tools -->
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c67bc259a068b5"></script>
            <!-- Afegim el text via @xarxanetorg quan es comparteix a twitter desde AddThis-->
			<script type="text/javascript">
				var addthis_share = addthis_share || {}
				addthis_share = {
					passthrough : {
						twitter: {
							via: "xarxanetorg"
						}
					}
				}
			</script>
            <div class="node-social-links">
              <div class="addthis_sharing_toolbox"></div>
            </div>

            <div class="node-body-text">
                <?php
                	print $node->body['und'][0]['value']; ?>
            </div>
        </div>
    </div>

</div><!-- /node -->
