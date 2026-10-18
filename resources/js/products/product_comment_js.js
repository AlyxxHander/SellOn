$(document).ready(function () {
  const ratingDescriptions = {
    1: '1 / 5 (Very Bad)',
    2: '2 / 5 (Not Satisfied)',
    3: '3 / 5 (Average)',
    4: '4 / 5 (Satisfied)',
    5: '5 / 5 (Very Good)'
  };

  // Comment Star Rating Display Function
  function updateStars(val) {
    const $container = $('#star-rating-container');
    if (!$container.length) return;

    $container.find('.star-btn').each(function () {
      const btnVal = parseInt($(this).data('value'), 10);
      const $icon = $(this).find('i');

      if (btnVal <= val) {
        $icon.removeClass('fa-regular').addClass('fa-solid');
        $(this).removeClass('text-slate-300').addClass('text-amber-400');
      } else {
        $icon.removeClass('fa-solid').addClass('fa-regular');
        $(this).removeClass('text-amber-400').addClass('text-slate-300');
      }
    });

    const $label = $('#rating-label');
    if ($label.length) {
      $label.text(ratingDescriptions[val] || `${val} / 5`);
    }
  }

  // Comment Star Rating Click Event (Event Delegation via document)
  $(document).off('click', '#star-rating-container .star-btn').on('click', '#star-rating-container .star-btn', function (e) {
    e.preventDefault();
    const val = parseInt($(this).data('value'), 10);
    $('#rating-input').val(val);
    updateStars(val);
  });

  // Comment Star Hover Effect (Preview nilai saat kursor melayang di atas bintang)
  $(document).off('mouseenter', '#star-rating-container .star-btn').on('mouseenter', '#star-rating-container .star-btn', function () {
    const hoverVal = parseInt($(this).data('value'), 10);
    updateStars(hoverVal);
  });

  // Comment Star Mouse Leave Event (Kembali ke nilai yang sedang dipilih pada input)
  $(document).off('mouseleave', '#star-rating-container').on('mouseleave', '#star-rating-container', function () {
    const currentVal = parseInt($('#rating-input').val() || 5, 10);
    updateStars(currentVal);
  });

  // Comment Star Rating Initialize Function (Default 5 stars)
  function initStarRating() {
    const currentVal = parseInt($('#rating-input').val() || 5, 10);
    updateStars(currentVal);
  }

  // Run again when the Livewire SPA page changes
  $(document).on('livewire:navigated', initStarRating);

  // Comment Delete Confirmation
  $(document).off('submit', '.delete-comment-form').on('submit', '.delete-comment-form', function (e) {
    const confirmed = confirm('Apakah Anda yakin ingin menghapus komentar ini?');
    if (!confirmed) {
      e.preventDefault();
      return false;
    }
  });

  // Word Counter
  $(document).on('input', '#comment-text', function () {
    const max = 150;
    const len = this.value.length;

    if (len > max) this.value = this.value.substring(0, max);
    $('#comment-counter').text(len + ' / ' + max);
  });

  // Run when the page is first loaded
  initStarRating();
});
