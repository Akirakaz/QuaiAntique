const seats = document.getElementById('seats');
const selectSeat = document.getElementById('booking_guests');
const booking_date = document.getElementById('booking_date');
const submitDiv = document.getElementById('submit');


const request = (url, params = {}, method = 'GET') => {
  let options = {
    method
  };
  if ('GET' === method) {
    url += '?' + (new URLSearchParams(params)).toString();
  } else {
    options.body = JSON.stringify(params);
  }

  return fetch(url, options).then(response => response.json());
};

const get = (url, params) => request(url, params, 'GET');
const post = (url, params) => request(url, params, 'POST');

let valid = true;

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

    test(valid)
  } else (
    seats.innerText = ""
  )
})

function test() {
  if (valid) {
    console.log(valid)

    const submitBtn = document.createElement('button')
    submitBtn.innerText = 'Réserver'
    submitBtn.classList.add('bg-green-500')
    submitDiv.appendChild(submitBtn)
  }
}

