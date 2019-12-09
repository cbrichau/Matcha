(function()
{
  if (navigator.geolocation)
  {
    var localisation = document.querySelector('form [name="localisation"]');

    var options = { enableHighAccuracy: true };
    function success(position)
    {
      localisation.value = position.coords.latitude + ":" + position.coords.longitude;
    }
    function error(err) {}

    navigator.geolocation.getCurrentPosition(success, error, options);
  }
})();
