jQuery('.twitter-block').delegate('#twitter-widget-0','DOMSubtreeModified propertychange', function() {
  //function call to override the base twitter styles
  customizeTweetMedia();
 });
 
 var customizeTweetMedia = function() {
 
  //overrides font styles and removes the profile picture and media from twitter feed
  // jQuery('.twitter-block').find('.twitter-timeline').contents().find('.timeline-Tweet-media').css('display', 'none');
  // jQuery('.twitter-block').find('.twitter-timeline').contents().find('img.Avatar').css('display', 'none');
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('span.TweetAuthor-avatar.Identity-avatar').remove();
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('span.TweetAuthor-screenName').css('font-size', '16px');
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('span.TweetAuthor-screenName').css('font-family', 'Raleway');
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('.SandboxRoot').css('font-family', "'Raleway', sans-serif");
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('.SandboxRoot .timeline-Tweet-text').css('font-size', '14px');
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('.SandboxRoot .timeline-Tweet-text').css('color', '#555');
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('.SandboxRoot .timeline-Tweet-text').css('font-weight', '200');
 
  //also call the function on dynamic updates in addition to page load
  jQuery('.twitter-block').find('.twitter-timeline').contents().find('.timeline-TweetList').bind('DOMSubtreeModified propertychange', function() {
   customizeTweetMedia(this);
});
}