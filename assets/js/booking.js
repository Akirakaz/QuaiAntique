const seats = document.getElementById('seats');
const selectSeat = document.getElementById('booking_guests');
const booking_date = document.getElementById('booking_date');
const submitDiv = document.getElementById('submit');

const request = (url, params = {}, method = 'GET') => {
  let options = {method};
  if ('GET' === method) {
    url += '?' + (new URLSearchParams(params)).toString();
  } else {
    options.body = JSON.stringify(params);
  }

  return fetch(url, options).then(response => response.json());
};

const get = (url, params) => request(url, params, 'GET');
const post = (url, params) => request(url, params, 'POST');

let valid = false;

async function getAvailableSeats() {
  return get('/booking/seats', {
    bookingDate: booking_date.value
  });
}

selectSeat.addEventListener('change', async function (event) {
  let wantToBookSeats = event.target.value;
  let availableSeats = await getAvailableSeats();

  if (parseInt(wantToBookSeats) > parseInt(availableSeats)) {
    seats.innerText = `Il n'y a plus de table pour ${wantToBookSeats} personnes.`;
    valid = false
    showSubmitButton(valid)
  } else {
    seats.innerText = ""
    valid = true;
    showSubmitButton(valid)
  }
})


function showSubmitButton() {
  const submitButton = document.getElementById('submitBtn')

  if (valid) {
    if (!submitButton) {
      const submitBtn = document.createElement('button')

      submitBtn.innerText = 'Réserver'
      submitBtn.id = 'submitBtn'
      submitBtn.classList.add('rounded', 'bg-slate-200', 'px-4', 'py-2', 'hover:bg-slate-300')

      submitDiv.appendChild(submitBtn)
    }

  } else {
    submitButton.remove()
  }
}

