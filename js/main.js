const showHiddenPass = (loginPass, loginEye) => {
   const input = document.getElementById(loginPass),
      iconEye = document.getElementById(loginEye)

   iconEye.addEventListener('click', () => {

      if (input.type === 'password') {

         input.type = 'text'


         iconEye.classList.add('ri-eye-line')
         iconEye.classList.remove('ri-eye-off-line')
      } else {

         input.type = 'password'

         iconEye.classList.remove('ri-eye-line')
         iconEye.classList.add('ri-eye-off-line')
      }
   })
}

showHiddenPass('password', 'r-eye')

function validarFechaNacimiento() {
   var fechaNacimiento = document.getElementById("fecha_nacimiento").value;
   var hoy = new Date();
   var fecha = new Date(fechaNacimiento);
   var edad = hoy.getFullYear() - fecha.getFullYear();
   var mes = hoy.getMonth() - fecha.getMonth();
   if (mes < 0 || (mes === 0 && hoy.getDate() < fecha.getDate())) {
      edad--;
   }
   if (edad < 9 || edad > 12) {
      alert("Debes tener entre 9 y 12 años para registrarte.");
      return false;
   }
   return true;
}

