
$("body").on('click', '.toggle-password', function() {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $("#pass_log_id");
    if (input.attr("type") === "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });


   function switchLocale(locale) {
        // Use AJAX to update the language without refreshing the page
        fetch("{{ path('switch_locale', {'locale': ''}) }}/" + locale)
            .then(response => response.json())
            .then(data => {
                // Handle success or perform additional actions if needed
                location.reload(); // Reload the page for simplicity; you can use other approaches
            });
    }

switchLocale();