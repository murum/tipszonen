class Module

  # Confirm box to remove a user
  $("a.user-remove").on "click", ->
    false unless confirm("Är du säker på att du vill ta bort den här användaren?")
