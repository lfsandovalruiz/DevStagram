
import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

if( document.getElementById('dropzone') ) {

  const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube tu imagen', 
    acceptedFiles: '.png,.jpg,.jpeg,.gig',
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles: 1,
    uploadMultiple: false,

    init: function(){
      const nombreImagen = document.querySelector('[name="imagen"]');
      
      if(!nombreImagen.value.trim()) return;

      const imagenPublicada = {};
      imagenPublicada.size = 1234; // no importa el número, solo hay que ponerlo
      imagenPublicada.name = nombreImagen.value;

      // estas ya son funciones de dropzone
      this.options.addedfile.call(this, imagenPublicada);
      this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

      // se estan agregando clases de dropzone (dz)
      imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');
    }
  });

  dropzone.on("success", (file, response) => {
    document.querySelector('[name="imagen"]').value = response.imagen;
  });

  dropzone.on("removedfile", function(){
    document.querySelector('[name="imagen"]').value = "";
  });

};

