(function($){

  /* WordPress Media Uploader
  -------------------------------------------------------*/
  var deleteButton = $('.deo-image-delete-button');

  var mediaUploader = wp.media.frames.file_frame = wp.media({
    title: 'Select an Image',
    button: {
      text: 'Use This Image'
    },
    multiple: false
  });

  $('body').on('click', '.deo-image-upload-button', function(e) {
    e.preventDefault();

    if ( mediaUploader ) {
      mediaUploader.open();
    }

    mediaUploader.on('select', function() {
      var attachment = mediaUploader.state().get('selection').first().toJSON(); 
      $('.deo-hidden-input').focus().change();
      $('.deo-hidden-input').val(attachment.url);
      $('.deo-media-image').attr('src', attachment.url);
    });

    mediaUploader.open();

  });
  
  $('body').on('click', '.deo-image-delete-button', function(e) {
      $('.deo-media-image').attr('src', '');
      $('.deo-hidden-input').val('');
  });

})(jQuery);
