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

<article id="<?php print $node_id; ?>" class="<?php print $classes; ?>">
	<?php
		$uri = $node->field_agenda_imatge['und'][0]['uri'];
		$fileurl = image_style_url('tag-gran', $uri);
		$alt = $node->field_agenda_imatge['und'][0]['alt']; 
		
		$inici = null;
		$final = null;
		
		if (!empty($node->field_date_event['und'][0])) {
			$inici = new DateTime($node->field_date_event['und'][0]['value'], new DateTimeZone($node->field_date_event['und'][0]['timezone_db']));
			$final = new DateTime($node->field_date_event['und'][0]['value2'], new DateTimeZone($node->field_date_event['und'][0]['timezone_db']));
			$inici->setTimezone(new DateTimeZone($node->field_date_event['und'][0]['timezone']));
			$final->setTimezone(new DateTimeZone($node->field_date_event['und'][0]['timezone']));
		}	
	?>
	
	<div id="date">
		<?php
			if ($inici) print '<strong>Inici: </strong>'.$inici->format("d/m/Y \a \l\\e\s H:i");;
			if ($inici != $final) print '<br/><strong>Fi: </strong>'.$final->format("d/m/Y \a \l\\e\s H:i");;  
		?>
	</div>
		
	<div class='image'>
		<img src='<?php print $fileurl ?>' alt='<?php print $alt ?>'/>
	</div>
	<div id="sub-image-1">
		<?php echo mobile_xarxanet_get_label($node->type); ?>
		
		<div id="social-icons">
			<a href="http://www.twitter.com/share?url=<?php print $GLOBALS['base_url'].$node_url ?>">
				<img src="/<?php print path_to_theme()?>/images/pictos/social/twitter.png" alt="compartir a twitter" />
			</a>
			<a href="http://www.facebook.com/sharer/sharer.php?u=<?php print $GLOBALS['base_url'].$node_url ?>">
				<img src="/<?php print path_to_theme()?>/images/pictos/social/facebook.png" alt="compartir a twitter" />
			</a>
			<a href="http://www.plus.google.com/share?url=<?php print $GLOBALS['base_url'].$node_url ?>">
				<img src="/<?php print path_to_theme()?>/images/pictos/social/plus.png" alt="compartir a twitter" />
			</a>
			<a href="/printmail/<?php print $nid ?>">
				<img src="/<?php print path_to_theme()?>/images/pictos/social/mail.png" alt="compartir a twitter" />
			</a>
		</div>
		<div id="nothing"></div>
	</div>
	<div class="node-body-text">
		<div class="teaser"><?php print $node->field_resum['und'][0]['value']; ?></div>
		<?php print $node->body['und'][0]['value']; ?>
	</div>
	<div id="credits">
		<?php 
			if($node->field_organizer['und'][0]['value']) print '<p><strong>Organitzador: </strong>'.$node->field_organizer['und'][0]['value'].'</p>';
	        if($node->field_org_adress['und'][0]['value']) print '<p><strong>Adreça de l\'organitzador: </strong>'.$node->field_org_adress['und'][0]['value'].'</p>';
	        if($node->field_org_email['und'][0]['value']) print '<p><strong>Correu: </strong>'.$node->field_org_email['und'][0]['value'].'</p>';
	        if($node->field_org_web['und'][0]['value']) print '<p><strong>URI: </strong>'.$node->field_org_web['und'][0]['value'].'</p>';
	    ?>
		<p><a class="mesinformacio" href="<?php print $field_link['und'][0]['value']?>">Més Informació</a></p>
	</div>
</article>