<?php
/**
 * Title: Data Liberation Guides List
 * Slug: wporg-main-2022/data-liberation-guides
 * Inserter: no
 */

?>

<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|80"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:heading {"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30","top":"0"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--30)">Guides</h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"wide","className":"wporg-events__filters","style":{"spacing":{"margin":{"top":"40px","bottom":"40px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide wporg-events__filters" style="margin-top:40px;margin-bottom:40px">
	<!-- wp:group {"className":"wporg-events__filters__search","layout":{"type":"flex","flexWrap":"wrap"}} -->
	<div class="wp-block-group wporg-events__filters__search">
		<!-- wp:search {"showLabel":false,"placeholder":"Search guides...","width":100,"widthUnit":"%","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true,"className":"is-style-secondary-search-control"} /-->

		<!-- wp:query {"queryId":0,"query":{"perPage":500,"pages":0,"offset":0,"postType":"and-handbook","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false,"parents":[]}} -->
			<!-- wp:wporg/query-total /-->
		<!-- /wp:query -->
	</div> <!-- /wp:group -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"className":"wporg-query-filters","layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group wporg-query-filters">
		<!-- wp:wporg/query-filter {"key":"format_type","multiple":false} /-->
		<!-- wp:wporg/query-filter {"key":"event_type","multiple":true} /-->
		<!-- wp:wporg/query-filter {"key":"month","multiple":true} /-->
		<!-- wp:wporg/query-filter {"key":"country","multiple":true} /-->
	</div> <!-- /wp:group -->

</div> <!-- /wp:group -->

<!-- wp:group {"style":{"border":{"bottom":{"color":"var:preset|color|light-grey-1","width":"1px"},"top":[],"right":[],"left":[]}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--light-grey-1);border-bottom-width:1px"><!-- wp:query {"queryId":2,"query":{"perPage":10,"pages":0,"offset":0,"postType":"and-handbook","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"style":{"spacing":{"blockGap":"0"}}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"margin":{"top":"0","bottom":"0"}},"border":{"top":{"width":"1px","color":"var:preset|color|light-grey-1"},"right":{"width":"1px","color":"var:preset|color|light-grey-1"},"bottom":{"width":"0px","style":"none"},"left":{"width":"1px","color":"var:preset|color|light-grey-1"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="border-top-color:var(--wp--preset--color--light-grey-1);border-top-width:1px;border-right-color:var(--wp--preset--color--light-grey-1);border-right-width:1px;border-bottom-style:none;border-bottom-width:0px;border-left-color:var(--wp--preset--color--light-grey-1);border-left-width:1px;margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"margin":{"top":"0","bottom":"0"}},"typography":{"fontStyle":"normal","fontWeight":"700"},"elements":{"link":{"color":{"text":"var:preset|color|blueberry-1"}}}},"textColor":"blueberry-1","fontSize":"normal","fontFamily":"inter"} /-->

<!-- wp:post-excerpt {"style":{"spacing":{"margin":{"top":"0","bottom":"0"}}}} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template -->

<!-- wp:query-pagination -->
<!-- wp:query-pagination-previous /-->

<!-- wp:query-pagination-numbers /-->

<!-- wp:query-pagination-next /-->
<!-- /wp:query-pagination --></div>
<!-- /wp:query --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->