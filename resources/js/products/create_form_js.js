import { triggerToast } from "../utils";

$(document).ready(function () {
  document.addEventListener('livewire:navigated', function () {
    window.uploadedFilesCount = 0;
  });

  // --- 2. Logika Upload Gambar (Preview & Validasi Size) ---
  $(document).on('change', '.file-input', function (e) {
    const boxId = $(this).data('box');
    const file = e.target.files[0];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (file) {
      if (file.size > maxSize) {
        triggerToast('toast_error', 'Image size must be less than 5MB!');
        $(this).val(''); // Reset
        return;
      }

      const reader = new FileReader();
      reader.onload = function (e) {
        $(`#img-preview-${boxId}`).attr('src', e.target.result).show();
        $(`.remove-img[data-box="${boxId}"]`).css('display', 'flex');
        window.uploadedFilesCount++;
        $('#err-foto').hide(); // Sembunyikan error jika ada gambar
      }
      reader.readAsDataURL(file);
    }
  });

  // Hapus gambar
  $(document).on('click', '.remove-img', function (e) {
    e.preventDefault(); // Mencegah trigger label input file
    const boxId = $(this).data('box');
    $(`.file-input[data-box="${boxId}"]`).val('');
    $(`#img-preview-${boxId}`).attr('src', '').hide();
    $(this).hide();
    window.uploadedFilesCount--;
  });

  // --- 3. Logika Kondisional (Kategori -> Preloved) ---
  $(document).on('change', '#category', function () {
    $('.input-field').removeClass('error'); // Clear errors on change
    if ($(this).val() === 'Preloved') {
      $('#condition-section').slideDown(200);
      $('#stock-section').slideDown(200);
    } else if ($(this).val() === 'Service') {
      $('#stock-section').slideUp(200);
      $('#condition-section').slideUp(200);
      $('input[name="condition"]').prop('checked', false); // Reset radio
      $('#err-condition').hide();
    } else {
      $('#stock-section').slideDown(200);
      $('#condition-section').slideUp(200);
      $('input[name="condition"]').prop('checked', false); // Reset radio
      $('#err-condition').hide();
    }
  });

  // --- 4. Counter Karakter Deskripsi ---
  $(document).on('input', '#description', function () {
    const len = $(this).val().length;
    $('#char-count').text(len);
  });

  // --- 5. Validasi dan Submit Form ---
  $(document).on('submit', '#form-product', function (e) {
    e.preventDefault();
    let isValid = true;

    // Reset semua error styling
    $('.input-field').removeClass('error');
    $('.err-msg').hide();
    $('#err-foto, #err-condition').hide();

    // Validasi Foto (Min 1)
    let hasImage = false;
    $('.file-input').each(function () {
      if ($(this).val() !== '') hasImage = true;
    });
    if (!hasImage) {
      $('#err-foto').show();
      isValid = false;
    }

    // Validasi Input Teks, Select, Textarea (tanpa #stock, dihandle terpisah)
    const requiredFields = ['#name', '#category', '#price', '#description'];
    requiredFields.forEach(function (field) {
      if ($(field).val() === '' || $(field).val() === null) {
        $(field).addClass('error').siblings('.err-msg').show();
        isValid = false;
      }
    });

    // Price range validation (10.000 - 1.000.000)
    const priceVal = parseInt($('#price').val(), 10);
    if (isNaN(priceVal) || priceVal < 10000 || priceVal > 1000000) {
      $('#price').addClass('error').siblings('.err-msg').text('Price must be between Rp 10.000 and Rp 1.000.000').show();
      isValid = false;
    }

    // Validasi range stock (1 - 999) jika section stock terlihat
    if ($('#stock-section').is(':visible')) {
      const stockVal = parseInt($('#stock').val(), 10);
      if (isNaN(stockVal) || stockVal < 1 || stockVal > 999) {
        $('#stock').addClass('error').siblings('.err-msg').text('Stock must be between 1 and 999').show();
        isValid = false;
      }
    }

    // Validate stock only if stock section is visible
    if ($('#stock-section').is(':visible')) {
      if ($('#stock').val() === '' || $('#stock').val() === null) {
        $('#stock').addClass('error').siblings('.err-msg').show();
        isValid = false;
      }
    }

    // Validate condition only if condition section is visible
    if ($('#category').val() === 'Preloved' && $('#condition-section').is(':visible')) {
      if (!$('input[name="condition"]:checked').val()) {
        $('#err-condition').show();
        isValid = false;
      }
    }

    // Final Eksekusi
    if (isValid) {
      // Collect all data here via FormData/AJAX
      triggerToast('toast_success', 'Product has been successfully saved!');

      // Simulate redirect / reset
      setTimeout(() => {
        e.target.submit();
      }, 1000);
    } else {
      triggerToast('toast_error', 'Please complete the data marked in red.');
    }
  });

  // Validate price and stock (Only numbers, remove leading zero, and set max value instantly)
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

  // Validate stock (Only numbers, remove leading zero, and set max value instantly)
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

  // Validate price and stock (Only numbers, remove leading zero, and set min value instantly)
  $(document).on('blur', '#price', function () {
    if (this.value !== '') {
      const val = parseInt(this.value, 10);
      if (val < 10000) {
        this.value = 10000;
      }
    }
  });

  // Validate stock (Only numbers, remove leading zero, and set min value instantly)
  $(document).on('blur', '#stock', function () {
    if (this.value !== '') {
      const val = parseInt(this.value, 10);
      if (val < 1) {
        this.value = 1;
      }
    }
  });

});