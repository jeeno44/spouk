(function () {
  $('.add-disc').click(function (e) {
    $.ajax({
      url: '/training/plans/disciplines/form',
      type: 'POST',
      success: function (html) {
        $('.discs-load').append(html)
      }
    });
    e.preventDefault();
  });
  $(document).on('click', '.rem-disc-row', function (e) {
    $(this).closest('.row').remove();
    e.preventDefault();
  })
})();