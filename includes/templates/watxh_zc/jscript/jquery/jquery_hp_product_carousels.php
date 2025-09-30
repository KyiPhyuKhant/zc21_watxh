<script type="text/javascript">

  jQuery(document).ready(function(){
    'use strict'
   
    /**
     * Initialize Carousel
     */
    jQuery('.nmx-tab-content').owlCarousel({
      items: <?php echo HPPC_ITEMS; ?>,
      itemsDesktop : [1199, <?php echo HPPC_ITEMS_DESKTOP; ?>],
      itemsDesktopSmall : [979, <?php echo HPPC_ITEMS_SMALL; ?>],
      itemsTablet: [768, <?php echo HPPC_ITEMS_TABLET; ?>],
      itemsMobile : [520, <?php echo HPPC_ITEMS_MOBILE; ?>],
      navigation: <?php echo HPPC_NAVIGATION; ?>,
      autoPlay: <?php echo HPPC_AUTOPLAY; ?>,
      lazyLoad: false
    });

  }); 

</script>
