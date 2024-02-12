<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <script src="https://kit.fontawesome.com/661c1762f6.js" crossorigin="anonymous"></script>
    @inertiaHead
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId            : '1368287130495002',
          xfbml            : true,
          version          : 'v19.0'
        });
      };
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
  </head>
  <body>
    @inertia
    {{-- <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "61556529386413");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>


    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v19.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script> --}}

    
    <div id="fb-root"></div>
    <div id="fb-customer-chat" class="fb-customerchat"></div>
  </body>
</html>