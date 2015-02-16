<input type="hidden" name="request_title" value="{$smarty.request.request_title}" />

{literal}
  <div id="fb-root"></div>
  <script>

    // Call FB SDK
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_PI/sdk.js#xfbml=1&appId=809195452485029&version=v2.0";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Initialise FB
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '809195452485029',
        cookie     : true,
        xfbml      : true,
        version    : 'v2.2'
      });

      FB.getLoginStatus(function(response){
        statusChangeCallback(response);
        // console.log(response);
      });

      // This is called with the results from from FB.getLoginStatus().
      function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the
        // app know the current login status of the person.
        // Full docs on the response object can be found in the documentation
        // for FB.getLoginStatus().
        if (response.status === 'connected') {
          // Logged into your app and Facebook.
          console.log('User connected to both');
        } else if (response.status === 'not_authorized') {
          // The person is logged into Facebook, but not your app.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into this app.';
        } else {
          // The person is not logged into Facebook, so we're not sure if
          // they are logged into this app or not.
          document.getElementById('status').innerHTML = 'Please log ' +
            'into Facebook.';
        }
      }


    };

  </script>

{/literal}

{* Login *}

<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false" data-scope="public_profile,email"></div>

{*Like/share buttons*}
{*<div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>*}