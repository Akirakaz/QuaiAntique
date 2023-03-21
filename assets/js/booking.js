const seats = document.getElementById('seats');

if (seats) {
  const selectSeat = document.getElementById('booking_guests');
  const booking_date = document.getElementById('booking_date');
  const booking_hour_hour = document.getElementById('booking_hour_hour');
  const submitDiv = document.getElementById('submit');

  const request = (url, params = {}, method = 'GET') => {
    let options = {method};
    if ('GET' === method) {
      url += '?' + (new URLSearchParams(params)).toString();
    }

    return fetch(url, options).then(response => response.json());
  };

  const get = (url, params) => request(url, params, 'GET');

  let valid = false;

  async function getAvailableSeats() {
    return get('/booking/seats', {
      bookingDate: booking_date.value,
      bookingHour: booking_hour_hour.value
    });
  }

  async function checkAvailableSeat() {
    let availableSeats = await getAvailableSeats();
    if (parseInt(selectSeat.value) > parseInt(availableSeats)) {
      seats.innerText = `Il n'y a plus de table pour ${selectSeat.value} personnes à ces horaires.`;
      valid = false
      showSubmitButton(valid)
    } else {
      seats.innerText = ""
      valid = true;
      showSubmitButton(valid)
    }
  }

  [booking_date, selectSeat, booking_hour_hour].forEach((element) => {
    element.addEventListener('change', async (event) => {
      await checkAvailableSeat()
    })
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

  await checkAvailableSeat();
}