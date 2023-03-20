const seats = document.getElementById('seats');
const selectSeat = document.getElementById('booking_guests');
console.log(seats, selectSeat)
async function getAvailableSeats() {
  const fetchUrl = await fetch('/booking/seats');
  return fetchUrl.json();
}

selectSeat.addEventListener('change', async function (event) {
  let wantToBookSeats = event.target.value;
  let availableSeats = await getAvailableSeats();

  if (parseInt(wantToBookSeats) > parseInt(availableSeats)) {
    seats.innerText = `Il n'y a plus de place pour ${wantToBookSeats} personnes.`;
  } else (
    seats.innerText = ""
  )
})

