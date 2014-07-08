class Module

  # Confirm box to remove a user
  $("a.user-remove").on "click", ->
    false unless confirm("Är du säker på att du vill ta bort den här användaren?")

  couponWrapper = $("#coupon-wrapper")
  if $ couponWrapper .exists
    couponId = couponWrapper.data 'id'
    secondsToUpdate = $("span.update-seconds")

    interval = (ms, func) -> setInterval func, ms
    interval 20000, ->
      couponWrapper.load "/kuponger/"+couponId+"/uppdatering"
      secondsToUpdate.html 20

    interval 1000, ->
      secondsToUpdate.html parseInt(secondsToUpdate .html()) - 1


