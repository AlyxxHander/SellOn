import { triggerToast } from '../utils';

// Validasi Register dengan Event Delegation
$(document).ready(function () {
  $(document).on('submit', '#form-register', function (e) {
    e.preventDefault();

    const name = $('#name').val();
    const nim = $('#nim').val();
    const email = $('#email').val();
    const major = $('#major').val();
    const wa = $('#whatsapp_no').val();
    const pass = $('#password').val();
    const passConf = $('#password_confirmation').val();
    const UMMEmail = '@webmail.umm.ac.id';
    let isValid = true;

    $('.input-field').removeClass('error');
    $('[id^="err-"]').hide();

    if (name.length === 0) {
      $('#err-name').text('Full Name must not be Empty.').show();
      isValid = false;
    }

    // Validasi NIM (15 digit angka)
    if (nim.length === 0) {
      $('#err-nim').text('NIM must not be Empty.').show();
      isValid = false;
    } else if (!/^\d{15}$/.test(nim)) {
      $('#nim').addClass('error');
      $('#err-nim').text('NIM must be 15 digits.').show();
      isValid = false;
    }

    if (!major) {
      $('#major').addClass('error');
      $('#err-major').text('Major must not be Empty.').show();
      isValid = false;
    }

    if (email.length === 0) {
      $('#err-email').text('UMM Email must not be Empty.').show();
      isValid = false;
    } else if (!email.includes(UMMEmail)) {
      $('#err-email').text('Use UMM Email (' + UMMEmail + ').').show();
      isValid = false;
    }

    // Validasi WA (Diawali 08, wajib angka)
    if (wa.length === 0) {
      $('#err-whatsapp-no').text('WhatsApp Number must not be Empty.').show();
      isValid = false;
    } else if (!/^08\d{8,12}$/.test(wa)) {
      $('#whatsapp_no').addClass('error');
      $('#err-whatsapp-no').text('Invalid WhatsApp Number (must be 08...).').show();
      isValid = false;
    }

    // Validasi Password
    if (pass.length === 0) {
      $('#err-password').text('Password must not be Empty.').show();
      isValid = false;
    } else if (pass.length < 5) {
      $('#password').addClass('error');
      $('#err-password').text('Password must be at least 5 characters.').show();
      isValid = false;
    } else if (pass !== passConf) {
      $('#password, #password_confirmation').addClass('error');
      $('#err-password-conf').text('Confirm Password does not match.').show();
      isValid = false;
    }

    if (!isValid) {
      triggerToast('toast_error', 'Please check your registration data.');
    }
    else {
      // Send to UserController for further review
      setTimeout(() => {
        e.target.submit();
      }, 1000);
    }
  });

  // Real-time Number Only Restriction untuk NIM dan WA (ID matching view)
  $(document).on('input', '#nim, #whatsapp_no', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
});


/**

import { triggerToast } from '../utils';

// Rules Validasi Register
const rules = [
  {
    input: '#name',
    error: '#err-name',
    tests: [
      { 
        condition: v => v.length === 0,
        message: 'Full Name tidak boleh kosong.' 
      },
      { 
        condition: v => v.length < 3,
        message: 'Full Name minimal 3 karakter.' 
      }
    ]
  },
  {
    input: '#nim',
    error: '#err-nim',
    tests: [
      { 
        condition: v => v.length === 0,              
        message: 'NIM tidak boleh kosong.' 
      },
      { 
        condition: v => !/^\d{15}$/.test(v),          
        message: 'NIM harus 15 digit angka.' 
      }
    ]
  },
  {
    input: '#major',
    error: '#err-jurusan',
    tests: [
      { 
        condition: v => v.length === 0,               
        message: 'Jurusan tidak boleh kosong.' 
      }
    ]
  },
  {
    input: '#email',
    error: '#err-login-email',
    tests: [
      { 
        condition: v => v.length === 0,               
        message: 'UMM Email tidak boleh kosong.' 
      },
      { 
        condition: v => !v.includes('@webmail.umm.ac.id'), 
        message: 'Gunakan email UMM (@webmail.umm.ac.id).' 
      }
    ]
  },
  {
    input: '#whatsapp_no',
    error: '#err-no-whatsapp',
    tests: [
      { 
        condition: v => v.length === 0,               
        message: 'Nomor WhatsApp tidak boleh kosong.' 
      },
      { 
        condition: v => !/^08\d{8,12}$/.test(v),       
        message: 'WhatsApp harus diawali 08 dan berisi angka.' 
      }
    ]
  },
  {
    input: '#password',
    error: '#err-password',
    tests: [
      { 
        condition: v => v.length === 0,               
        message: 'Password tidak boleh kosong.' 
      },
      { 
        condition: v => v.length < 5,                
        message: 'Password minimal 5 karakter.' 
      }
    ]
  },
  {
    input: '#password_confirmation',
    error: '#err-password-conf',
    tests: [
      {
        // `val`    : Nilai konfirmasi
        // `other`  : Password asli
        condition: (v, other) => v !== other,
        message: 'Konfirmasi password tidak cocok.'
      }
    ]
  }
];

// ------------------------------------------------------------------
// Helper untuk menampilkan/menyembunyikan error
// ------------------------------------------------------------------
function setError($input, $error, msg) {
  if (msg) {
    $input.addClass('error');
    $error.text(msg).show();
  } else {
    $input.removeClass('error');
    $error.text('').hide();
  }
}

// ------------------------------------------------------------------
// Validasi satu field
// ------------------------------------------------------------------
function validateField($input, $error, extra = null) {
  const val = ($input.val() || '').trim();

  for (const test of rules.find(r => r.input === $input.selector).tests) {
    const ok = test.condition.length === 2
      ? test.condition(val, extra)          // contoh confirm password
      : test.condition(val);

    if (ok) {
      setError($input, $error, test.message);
      return false;
    }
  }
  setError($input, $error, '');
  return true;
}

// ------------------------------------------------------------------
// Event binding
// ------------------------------------------------------------------
$(document).ready(function () {
  // Reset semua error saat halaman dimuat
  $('.input-field').removeClass('error');
  $('[id^="err-"]').hide().text('');

  // Attach listener ke setiap rule
  rules.forEach(rule => {
    const $input = $(rule.input);
    const $error = $(rule.error);

    $input.on('blur', () => {
      const extra = rule.input === '#password_confirmation' ? $('#password').val() : null;
      validateField($input, $error, extra);
    });

    $input.on('input', () => {
      const extra = rule.input === '#password_confirmation' ? $('#password').val() : null;
      validateField($input, $error, extra);
    });
  });

  // ----------------------------------------------------------------
  // Submit handling
  // ----------------------------------------------------------------
  $('#form-register').on('submit', function (e) {
    let isValid = true;

    // Validasi semua field
    rules.forEach(rule => {
      const $input = $(rule.input);
      const $error = $(rule.error);
      const extra = rule.input === '#password_confirmation' ? $('#password').val() : null;
      const ok = validateField($input, $error, extra);
      if (!ok) isValid = false;
    });

    if (!isValid) {
      e.preventDefault();                    
      triggerToast('toast_error', 'Periksa kembali data pendaftaran Anda.');
    } else {
      e.preventDefault();
      setTimeout(() => this.submit(), 500);
    }
  });

  // ----------------------------------------------------------------
  // Input numeric only (NIM & WhatsApp) – tetap dipertahankan
  // ----------------------------------------------------------------
  $(document).on('input', '#nim, #whatsapp_no', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
});

 
 */