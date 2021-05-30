const URL = '../src/saveData.php';

const sentForm = async (data) => {
  let response = await fetch(URL, {
    method: 'post',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(data),
  });

  return await response.json();
}

const getDataFromForm = () => {
  const nameField = document.getElementById('formName');
  const emailField = document.getElementById('formEmail');
  const subjectField = document.getElementById('formSubject');
  const messageField = document.getElementById('formMessage');

  return {
    'name': nameField.value || '',
    'email': emailField.value || '',
    'subject': subjectField.value || '',
    'message': messageField.value || '',
  }
}

const displayInfo = (data) => {
  if (data.hasOwnProperty('is_save')) {
    if (data['is_save']) {
      document.querySelector('.contact__success').style.display = 'flex';
      document.querySelector('.contact__form').style.display = 'none';
      return;
    } else {
      document.querySelector('.form-error_common').style.display = 'block';
      return;
    }
  }

  const fields = document.querySelectorAll('.form-row');
  for (let field of fields) {
    const input = field.querySelector('.form-field, .form-textarea');
    if (input) {
      const error = field.querySelector('.form-error');
      const inputName = input.getAttribute('name');
      const errorName = inputName + '_error_msg';

      if (data.hasOwnProperty(errorName)) {
        error.textContent = data[errorName];
      } else {
        error.textContent = '';
      }
    }
  }
}

const run = () => {
  const form = document.getElementById('form');

  form.onsubmit = async (e) => {
    e.preventDefault();

    const data = getDataFromForm();
    const response = await sentForm(data);

    displayInfo(response);
  };
}

window.onload = run;
