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

  couponMatches = $("#coupon-matches")
  if $ couponMatches .exists
    rowNumbers = $("span.row-numbers")
    submitButton = $("div#coupon-submit-container")
    textContainer = $("div#rows-container")
    that = @

    changeRowNumbers = ->
      total = 1
      errors = []
      hasInvalidMatch = false

      $(that).find("li").each ->
        checkedBoxes = $(@).find("input[type='checkbox']:checked").length

        if( checkedBoxes > 0 )
          total *= checkedBoxes
        else
          hasInvalidMatch = true
          total *= 1

        rowNumbers.html(total)
        @

      if( total > 12000 )
        submitButton.hide()
        textContainer.addClass("alert-danger").removeClass("alert-success")

        message = "Din kupong får max vara 12000 rader"
        textContainer.append("<span class='row-numbers-error'>. "+message+"</span>")

      else
        submitButton.show()
        submitButton.find("input").show()
        textContainer.addClass("alert-success").removeClass("alert-danger")
        $("span.row-numbers-error").remove()
        $("div.errors").remove()

      total

    $(@).find("li input[type='checkbox']").on 'change', ->
      changeRowNumbers()
      @

    submitButton.find("input").on 'click', (e) ->
      if( changeRowNumbers() <= 12000 && $("input[name='name']").val() != "" )
        $(@).hide()
      @