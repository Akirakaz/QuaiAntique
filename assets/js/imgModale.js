const modalsPreview = document.querySelectorAll('[data-modalpreview]');
modalsPreview.forEach(function (trigger) {
  trigger.addEventListener('click', function (event) {
    event.preventDefault();

    const modalValue = this.src;

    const modal = document.getElementById(this.dataset.modalpreview);
    modal.classList.add('!visible', 'opacity-100');

    const lightbox = document.createElement('div');
    lightbox.classList.add('absolute', 'h-full', 'w-full', 'cursor-zoom-out', 'bg-slate-900/80', 'modal-exit');
    modal.appendChild(lightbox);

    const modalText = document.createElement('span');
    modalText.id = "modalText";
    modalText.classList.add('text-slate-400', 'z-1');
    modalText.innerHTML = "Cliquez en dehors de la photo pour fermer ou la touche [Echap]";
    modal.append(modalText);

    const previewImage = document.createElement('img');
    previewImage.classList.add('z-1', 'p-4', 'max-h-[75%]');
    previewImage.src = modalValue;
    modal.appendChild(previewImage);

    const exits = modal.querySelectorAll('.modal-exit');

    exits.forEach(function (exit) {
      exit.addEventListener('click', function (event) {
        event.preventDefault();
        modal.classList.remove('!visible', 'opacity-100');
        lightbox.remove();
        modalText.remove()
        previewImage.remove();
      });
    });

    window.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        modal.classList.remove('!visible', 'opacity-100');
        lightbox.remove();
        modalText.remove()
        previewImage.remove();
      }
    })
  });
});
