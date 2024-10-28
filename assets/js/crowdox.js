jQuery(document).ready(function($){
//  get image background
    var bg = $('.hero.header').css('background-image');
    if(bg){
        var new_url = bg.split('"')[1];
        var url = $('.crowdox_pull_image').attr('src', new_url);
    }
}); 
