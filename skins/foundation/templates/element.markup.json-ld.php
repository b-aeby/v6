<script type="application/ld+json">
    {literal}{"@context":"http://schema.org","@type":"Organization","legalName":"{/literal}{$CONFIG.store_name}{literal}","url":"{/literal}{$STORE_URL}{literal}","contactPoint":[{"@type":"ContactPoint","url":"{/literal}{$CONTACT_URL}{literal}","contactType":"customer service"}],"logo":"{/literal}{$STORE_LOGO}{literal}"{/literal}{if $SOCIAL_LINKS}{literal},"sameAs":[{/literal}{foreach from=$SOCIAL_LINKS item=link name=social_links}{literal}"{/literal}{$link.url}{literal}"{/literal}{if !$smarty.foreach.social_links.last}{literal},{/literal}{else}{literal}]{/literal}{/if}{/foreach}{/if}{literal}}{/literal}</script><script type="application/ld+json">{literal}{"@context":"http://schema.org","@type":"WebSite","name":"{/literal}{$CONFIG.store_name}{literal}","url":"{/literal}{$STORE_URL}{literal}","potentialAction":{"@type":"SearchAction","target":"{/literal}{$STORE_URL}{literal}/search{/literal}{$CONFIG.seo_ext}{literal}?search%5Bkeywords%5D={search_term}&_a=category","query-input":"required name=search_term"}}{/literal}</script>{if $SECTION_NAME=='product'}<script type="application/ld+json">{literal}{"@context":"https://schema.org/","@type":"Product",{/literal}{if !empty($MANUFACTURER)}{literal}"brand": {"@type":"Brand","name":"{/literal}{strip_tags(trim($MANUFACTURER))}{literal}"},{/literal}{/if}{literal}"description":"{/literal}{textformat wrap_char=" "}{strip_tags(trim(str_replace($PRODUCT.description,'"','\"')))}{/textformat}{literal}","sku":"{/literal}{$PRODUCT.product_code}{literal}","mpn":"{/literal}{$PRODUCT.mpn}{literal}","image":"{/literal}{$PRODUCT.source}{literal}","name":"{/literal}{$PRODUCT.name}{literal}",{/literal}{if !empty($REVIEWS)}{literal}"review": [ {/literal}{foreach from=$REVIEWS item=review}{literal} {"@type":"Review","reviewRating": {"@type":"Rating","ratingValue":"5"},"author": {"@type":"Person","name":"{/literal}{$review.name}{literal}"},"datePublished":"{/literal}{$review.date_schema}{literal}","reviewBody":"{/literal}{textformat wrap_char=" "}{strip_tags(trim(str_replace($review.review,'"','\"')))}{/textformat}{literal}"}{/literal}{if !$review@last},{/if}{/foreach}{literal}],"aggregateRating": {"@type":"AggregateRating","ratingValue":"{/literal}{$REVIEW_AVERAGE}{literal}","bestRating":"5","ratingCount":"{/literal}{count($REVIEWS)}{literal}"},{/literal}{/if}{literal}"offers": {"@type":"Offer","url":"{/literal}{$VAL_SELF}{literal}","priceCurrency":"{/literal}{$CONFIG.default_currency}{literal}","price":"{/literal}{preg_replace($PRODUCT.price_to_pay,'/[^0-9.]+/','')}{literal}","itemCondition":"https://schema.org/{/literal}{ucfirst($PRODUCT.condition)}{literal}Condition","availability":"https://schema.org/{/literal}{if $CTRL_OUT_OF_STOCK}{literal}OutOfStock{/literal}{else}{literal}InStock{/literal}{/if}{literal}","seller": {"@type":"Organization","name":"{/literal}{$CONFIG.store_name}{literal}"}}}{/literal}</script>{/if}