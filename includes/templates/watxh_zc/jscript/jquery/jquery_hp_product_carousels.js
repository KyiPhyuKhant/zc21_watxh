jQuery(document).ready(function(){
  'use strict'

  /**
   * When a tab is cliked ...
   */
  jQuery('.nmx-tab').on('click', function() {

    /**
     * If the tab the user clicked does not have
     * the active class, remove it from the tab
     * that does. Once it has removed it from
     * the previous tab, add it to this tab.
     * Only tabs under the same parent nmx-plugin class will be
     * hidden, to allow for multiple carausels on a page.
     */
    if( !jQuery(this).hasClass('active') ) {
      jQuery(this).parents('.nmx-plugin').find('.nmx-tab').removeClass('active');
      jQuery(this).addClass('active');
    }

    /**
     * Select the id of the tab that the user
     * just clicked.
     */
    var $tab_content = jQuery(this).attr('id');
    var $tab_content_id = '#' + $tab_content + 'Content';

    /**
     * If the tab the user clicked does not have 
     * its content showing, hide all other content
     * and show it. If it is, then do nothing.
     * Only content under the same parent nmx-plugin class will be
     * hidden, to allow for multiple carausels on a page.
     */
    if( jQuery($tab_content_id).is(':hidden') ) {
      jQuery(this).parents('.nmx-plugin').find('.nmx-tab-content').hide().addClass('inactive');
      jQuery($tab_content_id).show().removeClass('inactive');
    }

  });

});
