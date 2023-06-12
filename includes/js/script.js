// Funckijas, kas ir paredzēta, lai iegūtu php failus, kas ir paredzēti priekš reģistrācijas un pieslēgšanās formām
function getInput(inputCtrl, event, inputForm) {
    // Novērš notikuma noklusējuma uzvedību.
    event.preventDefault();
    // Iegūst msg id no faila, kurā ir ievietots paziņojums par kļūdu.
    let msg = document.getElementById('msg');
    // Iegūst formu no faila, kurā ir ievietota forma.
    let form = document.getElementById(inputForm);
    let xmlhttp = new XMLHttpRequest();
    // Iegūst datus no formas.
    let formData = new FormData(form);
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // Pārbauda, vai atgrieztā vērtība ir "true".
            if (this.responseText === "true") {
                const successMessage = "You have successfully logged in!";
                // Ja ir "true", tad pārslēdz uz index.php un ievieto paziņojumu.
                window.location = `index.php?message=${encodeURIComponent(successMessage)}`;
            } else {
                msg.innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("POST", "controllers/" + inputCtrl, true);
    xmlhttp.send(formData);
}

// Parāda paziņojumu, ja ir veiksmīgi reģistrējies.
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        showSuccessMessage(message);
    }
});

// Veiksmīgas reģistrācijas paziņojums.
function showSuccessMessage(message) {
    const successBox = document.createElement('div');
    successBox.classList.add('fixed', 'bottom-4', 'right-4', 'z-50', 'transition-opacity', 'duration-3000', 'opacity-100');
    successBox.innerHTML = `
        <div class="bg-[#4e4e4e] text-[#e4c065] px-6 py-4 rounded-lg shadow-lg">
            <p class="text-xl font-bold">${message}</p>
        </div>
    `;
    document.body.appendChild(successBox);

    setTimeout(function () {
        successBox.classList.remove('opacity-100');
        successBox.classList.add('opacity-0');
        setTimeout(function () {
            successBox.remove();
        }, 3000);
    }, 3000);
}

// Iegūst ievadformu datus un padod tos tālāk uz php failiem. Izmanto priekš lietotāja profila konfigurēšanas.
function getValue(inputCtrl, event, profileForm, id) {
    // Novērš notikuma noklusējuma uzvedību.
    event.preventDefault();
    // Iegūst msg id no faila, kurā ir ievietots paziņojums par kļūdu.
    let msg = document.getElementById('msg' + id);
    let form = document.getElementById(profileForm);
    // Iegūst datus no formas.
    let formData = new FormData(form);

    fetch('controllers/' + inputCtrl, {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            msg.innerHTML = data;
        })

        .catch(error => {
            console.error('Error:', error);
        });
    console.log(msg)
}

// Funkcija, kas izdzēš lietotāju no datubāzes un parvieto to uz reģistrācijas lapu.
function deleteUser(userID) {
    let msg = document.getElementById('deleteUser');
    let xmlhttp = new XMLHttpRequest();
    // Iegūst datus no formas.
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText == 0) {
                // Ja ir "true", tad lietotāju izdzēš un pārslēdz uz reģistrācijas lapu.
                window.location = "register.php";
            } else {
                msg.innerHTML = this.responseText;
            }
        }
    };
    xmlhttp.open("GET", "controllers/deleteUser.php?" + userID, true);
    xmlhttp.send();
}

// Funkcija, kas ļauj lietotājam pārvietoties no reģistrācijas uz pieslēgšanās lapu un otrādi.
function displayShow() {
    // Novērš notikuma noklusējuma uzvedību.
    event.preventDefault();
    // Meklē divReg no faila, kurā ir ievietota reģistrācijas forma.
    let x = document.getElementById("divReg");
    // Pievieno attiecīgo stilu un tekstu.
    if (x.style.display === "none") {
        btn.textContent = 'Login';
        text.textContent = "Don't have an account?";
        x.style.display = "flex";
    } else {
        btn.textContent = 'Register';
        text.textContent = "Have an account?";
        x.style.display = "none";
    }
    // Meklē divLog no faila, kurā ir ievietota pieslēgšanās forma.
    let y = document.getElementById("divLog");
    // Pievieno attiecīgo stilu un tekstu.
    if (y.style.display == "flex") {
        btn.textContent = 'Login';
        text.textContent = "Have an account?";
        y.style.display = "none";
    } else {
        btn.textContent = 'Register';
        text.textContent = "Don't have an account?";
        y.style.display = "flex";
    }
}

// Funkcija, kas pārvērš navigācijas joslu uz hamburgera navigāciju.
function hamburger() {
    let menu = document.getElementById("mobile-menu-2");
    let menuVisible = menu.style.display === "flex";
    // Ja navigācijas josla ir redzama, tad hamurgera navigācija ir neredzama un otrādi.
    if (menuVisible) {
        menu.style.display = "none";
        document.removeEventListener("click", hamburger);
    } else {
        menu.style.display = "flex";
        document.addEventListener("click", hamburger);
    }
}





