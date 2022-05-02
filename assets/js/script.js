jQuery(document).ready(function($){
    
    // AJAX url
    var ajax_url = plugin_ajax_object.ajax_url;
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("custom-modal-close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

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
            
            modal.style.display = "block";
          }
      });
    
  });
});
