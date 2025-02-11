<?php
/**
 * Title: single
 * Slug: dt-the7/hidden-single
 * Inserter: no
 */
?>
<!-- wp:group {"metadata":{"name":"Header Wrapper"},"style":{"position":{"type":"sticky","top":"0px"},"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group" style="margin-top:0;margin-bottom:0"><!-- wp:template-part {"slug":"header","tagName":"header"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Post Heading"},"style":{"spacing":{"blockGap":"0","padding":{"top":"0","bottom":"0"}},"background":{"backgroundImage":{"url":"<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/a-left-6-rev-1.svg","id":4027,"source":"file","title":"a-left-6-rev (1)"},"backgroundPosition":"100% 0%","backgroundSize":"65%","backgroundRepeat":"no-repeat"},"elements":{"link":{"color":{"text":"var:preset|color|contrast-content"}}},"border":{"radius":"0px"}},"backgroundColor":"contrast-background","textColor":"contrast-content","layout":{"type":"constrained","contentSize":"1000px"}} -->
<div class="wp-block-group has-contrast-content-color has-contrast-background-background-color has-text-color has-background has-link-color" style="border-radius:0px;padding-top:0;padding-bottom:0"><!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|91","bottom":"var:preset|spacing|91"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--91);padding-bottom:var(--wp--preset--spacing--91)"><!-- wp:group {"metadata":{"name":"Post Title + Meta"},"style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|45"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:post-terms {"term":"category","textAlign":"center","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-2"},":hover":{"color":{"text":"var:preset|color|accent-2-dark"}}}},"spacing":{"padding":{"top":"0.3em","bottom":"0.3em","left":"0.5em","right":"0.4em"}}},"backgroundColor":"accent-2-transparent-2","textColor":"accent-2-light","fontSize":"small"} /-->

<!-- wp:post-date {"textAlign":"center","displayType":"modified","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-2"}}}},"textColor":"accent-2"} /--></div>
<!-- /wp:group -->

<!-- wp:post-title {"textAlign":"center","level":1,"style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast-headings"}}}},"textColor":"contrast-headings","fontSize":"7-x-large"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Post Content"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|90","bottom":"0"}}},"backgroundColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--90);padding-bottom:0"><!-- wp:post-content {"align":"full","layout":{"type":"constrained"}} /-->

<!-- wp:group {"metadata":{"name":"Post Info"},"style":{"spacing":{"blockGap":"var:preset|spacing|30","padding":{"top":"var:preset|spacing|45"}},"elements":{"link":{"color":{"text":"var:preset|color|headings"},":hover":{"color":{"text":"var:preset|color|accent-1"}}}}},"textColor":"content-2","fontSize":"small","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-content-2-color has-text-color has-link-color has-small-font-size" style="padding-top:var(--wp--preset--spacing--45)"><!-- wp:group {"metadata":{"name":"Author"},"style":{"spacing":{"blockGap":"3px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.3"}}} -->
<p style="line-height:1.3">Postes by:</p>
<!-- /wp:paragraph -->

<!-- wp:post-author-name {"isLink":true} /--></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Date"},"style":{"spacing":{"blockGap":"3px"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.3"}}} -->
<p style="line-height:1.3">Postes on:</p>
<!-- /wp:paragraph -->

<!-- wp:post-date {"style":{"elements":{"link":{"color":{"text":"var:preset|color|headings"}}}},"textColor":"headings"} /--></div>
<!-- /wp:group -->

<!-- wp:post-terms {"term":"category","prefix":"Categories: ","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} /-->

<!-- wp:post-terms {"term":"post_tag","textAlign":"left","prefix":"Tags: ","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"}}}} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"discussion","area":"uncategorized"} /-->

<!-- wp:group {"metadata":{"name":"More posts"},"style":{"spacing":{"blockGap":"var:preset|spacing|70","margin":{"top":"var:preset|spacing|91","bottom":"var:preset|spacing|91"}},"border":{"radius":"0px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="border-radius:0px;margin-top:var(--wp--preset--spacing--91);margin-bottom:var(--wp--preset--spacing--91)"><!-- wp:heading {"textAlign":"center","level":3,"style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-1"}}}},"textColor":"accent-1","fontSize":"large"} -->
<h3 class="wp-block-heading has-text-align-center has-accent-1-color has-text-color has-link-color has-large-font-size">Discover More Posts</h3>
<!-- /wp:heading -->

<!-- wp:query {"queryId":28,"query":{"perPage":"4","pages":0,"offset":"0","postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"metadata":{"categories":["posts"],"patternName":"core/query-grid-posts"},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|70"}},"layout":{"type":"grid","columnCount":null,"minimumColumnWidth":"250px"}} -->
<!-- wp:group {"style":{"spacing":{"padding":{"top":"0px","right":"0px","bottom":"0px","left":"0px"},"blockGap":"var:preset|spacing|45"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group" style="padding-top:0px;padding-right:0px;padding-bottom:0px;padding-left:0px"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"3/2","width":"100%","height":"","style":{"color":{"duotone":"unset"},"layout":{"selfStretch":"fill","flexSize":null}}} /-->

<!-- wp:post-date {"style":{"spacing":{"margin":{"bottom":"-0.3em","top":"0.2em"}}},"fontSize":"small"} /-->

<!-- wp:post-title {"level":4,"isLink":true,"style":{"elements":{"link":{"color":{"text":"var:preset|color|headings"}}}},"textColor":"headings","fontSize":"2-x-large"} /-->

<!-- wp:post-terms {"term":"category","style":{"elements":{"link":{"color":{"text":"var:preset|color|accent-1"},":hover":{"color":{"text":"var:preset|color|accent-1-dark"}}}},"spacing":{"padding":{"top":"0.3em","bottom":"0.3em","left":"0.5em","right":"0.4em"}}},"backgroundColor":"accent-1-transparent-2","textColor":"accent-1","fontSize":"x-small"} /--></div>
<!-- /wp:group -->
<!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->