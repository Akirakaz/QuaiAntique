const getTotalSeat = document.getElementById('getTotalSeat');

if (getTotalSeat) {
  const setTotalSeatsInput = document.getElementById('setTotalSeatsInput');
  const setTotalSeatsButton = document.getElementById('setTotalSeatsButton');

  setTotalSeatsButton.addEventListener('click', async function (event) {
    let response = await fetch('/admin/settings/seats/edit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json;charset=utf-8'
      },
      dataType:'json',
      body: JSON.stringify({
        seats: setTotalSeatsInput.value,
      })
    });

    getTotalSeat.innerText = JSON.parse(await response.json());
  })
}