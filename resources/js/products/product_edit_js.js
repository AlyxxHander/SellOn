import { triggerToast } from '../utils';

$(document).ready(function () {

  // Initialize: sync visibility section based on selected category
  function syncSectionsToCategory() {
    const cat = $('#category').val();
    if (cat === 'Preloved') {
      $('#condition-section').show();
      $('#stock-section').show();
    } else if (cat === 'Service') {
      $('#stock-section').hide();
      $('#condition-section').hide();
    } else {
      $('#stock-section').show();
      $('#condition-section').hide();
    }
  }
  syncSectionsToCategory(); // Run when page first load

  // Update visibility when category changed
  $(document).on('change', '#category', function () {
    syncSectionsToCategory();
    $('input[name="condition"]').prop('checked', false);
    $('#err-condition').hide();
  });

  const maxImages = 5;

  window.updateAddButtonVisibility = function () {
    const currentImages = $('.existing-image').length + $('.new-image').length;
    if (currentImages >= maxImages) {
      $('#add-image-button').hide();
    } else {
      $('#add-image-button').css('display', 'flex');
    }
  };

  // Run when page first load
  if ($('#add-image-button').length) {
    window.updateAddButtonVisibility();
  }

  // Run also every time Livewire SPA navigation (back/forward)
  document.addEventListener('livewire:navigated', function () {
    if ($('#add-image-button').length) {
      window.updateAddButtonVisibility();
    }
  });

  // Trigger file input when add image button is clicked
  $(document).on('click', '#add-image-button', function () {
    $('#input-file-cursor').click();
  });

  // Handle file input change
  $(document).on('change', '.dynamic-file-input', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const maxImages = 5;
    const maxSize = 5 * 1024 * 1024; // 5MB
    let currentImages = $('.existing-image').length + $('.new-image').length;

    if (currentImages >= maxImages) {
      triggerToast('toast_error', 'Maximum 5 images!');
      $(this).val('');
      return;
    }


    if (file.size > maxSize) {
      triggerToast('toast_error', 'Maximum 5MB image size!');
      $(this).val('');
      return;
    }

    const inputCounter = Date.now();
    const inputId = `file-input-${inputCounter}`;
    $(this).attr('id', inputId);
    $(this).removeClass('dynamic-file-input').addClass('active-file-input');

    // Create a new empty input for the next file
    $('#new-images-inputs').append('<input type="file" name="new_image_urls[]" accept="image/png, image/jpeg" class="dynamic-file-input" id="input-file-cursor">');

    const reader = new FileReader();
    reader.onload = function (e) {
      const previewHtml = `
        <div class="upload-box relative group new-image" data-input-id="${inputId}">
          <img src="${e.target.result}" alt="preview" class="w-full h-full object-cover rounded-xl border border-slate-200">
          <div class="remove-new-img absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity" data-input-id="${inputId}">✕</div>
        </div>
      `;
      $(previewHtml).insertBefore('#add-image-button');
      if (window.updateAddButtonVisibility) window.updateAddButtonVisibility();
      $('#err-foto').hide();
    };
    reader.readAsDataURL(file);
  });

  // Remove existing image
  $(document).on('click', '.remove-existing-img', function () {
    const id = $(this).data('id');
    $(this).closest('.existing-image').remove();
    $('#deleted-images-container').append(`<input type="hidden" name="deleted_images[]" value="${id}">`);
    if (window.updateAddButtonVisibility) window.updateAddButtonVisibility();
  });

  // Remove new image
  $(document).on('click', '.remove-new-img', function () {
    const inputId = $(this).data('input-id');
    $(`#${inputId}`).remove();
    $(this).closest('.new-image').remove();
    if (window.updateAddButtonVisibility) window.updateAddButtonVisibility();
  });

  // Char count for description
  $(document).on('input', '#description', function () {
    $('#char-count').text($(this).val().length);
  });

  // Validation before submit
  $(document).on('submit', '#form-product', function (e) {
    let isValid = true;

    // Validation for Product Image
    let currentImages = $('.existing-image').length + $('.new-image').length;
    if (currentImages === 0) {
      e.preventDefault();
      $('#err-foto').show();
      triggerToast('toast_error', 'Please select at least 1 product image!');
      return false;
    }

    // Validation for price range
    const priceVal = parseInt($('#price').val(), 10);
    if (isNaN(priceVal) || priceVal < 10000 || priceVal > 1000000) {
      e.preventDefault();
      $('#price').addClass('error').siblings('.err-msg').text('Harga harus antara Rp 10.000 dan Rp 1.000.000').show();
      triggerToast('toast_error', 'Harga harus antara Rp 10.000 dan Rp 1.000.000');
      isValid = false;
    }

    // Validation for stock range if visible
    if ($('#stock-section').is(':visible')) {
      const stockVal = parseInt($('#stock').val(), 10);
      if (isNaN(stockVal) || stockVal < 1 || stockVal > 999) {
        e.preventDefault();
        $('#stock').addClass('error').siblings('.err-msg').text('Stok harus antara 1 dan 999').show();
        triggerToast('toast_error', 'Stok harus antara 1 dan 999');
        isValid = false;
      }
    }


    // Validation for stock only if section-nya visible
    if ($('#stock-section').is(':visible')) {
      if ($('#stock').val() === '' || $('#stock').val() === null) {
        e.preventDefault();
        $('#stock').addClass('error').siblings('.err-msg').show();
        triggerToast('toast_error', 'Please complete the data marked in red.');
        isValid = false;
      }
    }

    // Validation for condition only if Preloved and section visible
    if ($('#category').val() === 'Preloved' && $('#condition-section').is(':visible')) {
      if (!$('input[name="condition"]:checked').val()) {
        e.preventDefault();
        $('#err-condition').show();
        triggerToast('toast_error', 'Please complete the data marked in red.');
        isValid = false;
      }
    }

    // Input Restriction for Price & Stock
    $(document).on('input', '#price', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
      if (this.value.length > 1 && this.value.startsWith('0')) {
        this.value = parseInt(this.value, 10) || '';
      }
      if (this.value !== '') {
        const val = parseInt(this.value, 10);
        if (val > 1000000) {
          this.value = 1000000;
        }
      }
    });

    // Input Restriction for Stock
    $(document).on('input', '#stock', function () {
      this.value = this.value.replace(/[^0-9]/g, '');
      if (this.value.length > 1 && this.value.startsWith('0')) {
        this.value = parseInt(this.value, 10) || '';
      }
      if (this.value !== '') {
        const val = parseInt(this.value, 10);
        if (val > 999) {
          this.value = 999;
        }
      }
    });

    // Blur Input Restriction for Price
    $(document).on('blur', '#price', function () {
      if (this.value !== '') {
        const val = parseInt(this.value, 10);
        if (val < 10000) {
          this.value = 10000;
        }
      }
    });

    // Blur Input Restriction for Stock
    $(document).on('blur', '#stock', function () {
      if (this.value !== '') {
        const val = parseInt(this.value, 10);
        if (val < 1) {
          this.value = 1;
        }
      }
    });

    // Prevent submit if invalid
    if (!isValid) return false;

    // Clean empty input
    $('.dynamic-file-input').remove();
  });
});
