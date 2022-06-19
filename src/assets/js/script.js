jQuery(document).ready(function($){
    
    // AJAX url
    var ajax_url = plugin_ajax_object.ajax_url;


    // When the user clicks on <span> (x), close the modal
    $('.custom-modal-close').click(function() {
      $("#myModal").css('display','none');
    });

    // Fetch userdetails (AJAX request)
    $(".get-user-details").click(function() {
      var data = {
        'action': 'userdetails',
        'id' : $(this).attr('userid'),
      };

      $.ajax({
          url: ajax_url,
          type: 'post',
          data: data,
          //dataType: 'json',
          success: function(response){
            $('.userdetails-content-area').html(response);
            $("#myModal").css('display','block');
          }
      });
    
  });
});
