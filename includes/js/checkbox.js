// Izvēles rūtiņu funkcija, kas pārbauda vai ir atzīmēta tikai viena rūtiņa.
// Ja ir atzīmēta vairāk, tad atzīmētā rūtiņa noņemas una atzīmē uzspiesto.
function toggleCheckboxes(checkBoxHome, checkBoxAway, id) {
    // Iegūtie dati no atzīmētās rūtiņas
    const homeBox = document.getElementById('checkBoxHome-' + id);
    const awayBox = document.getElementById('checkBoxAway-' + id);
    // console.log(homeBox);
    // console.log(awayBox);
    // Pārbauda vai ir atzīmēta rūtiņa
    homeBox.addEventListener('change', function () {
        // Ja ir atzīmēta, tad noņem atzīmi no otrās rūtiņas
        if (homeBox.checked) {
            awayBox.checked = false;
            homeBox.setAttribute('data-checked', 'true');
            awayBox.setAttribute('data-checked', 'false');
        } else {
            // Ja nav atzīmēta, tad noņem atzīmi no abām rūtiņām
            homeBox.setAttribute('data-checked', 'false');
            awayBox.setAttribute('data-checked', 'false');
        }
    });
    //Pārbauda vai ir atzīmēta rūtiņa
    awayBox.addEventListener('change', function () {
        // Ja ir atzīmēta, tad noņem atzīmi no otrās rūtiņas
        if (awayBox.checked) {
            homeBox.checked = false;
            awayBox.setAttribute('data-checked', 'true');
            homeBox.setAttribute('data-checked', 'false');
        } else {
            // Ja nav atzīmēta, tad noņem atzīmi no abām rūtiņām
            homeBox.setAttribute('data-checked', 'false');
            awayBox.setAttribute('data-checked', 'false');
        }
    });
}

// Pogu aktivizēšanas funkcija un informācijas iegūšana par likmi
function activateButton(id, bet) {
    // Mainīgie un iegūtie dati
    const buttons = document.querySelectorAll('.currency-btn-' + id);
    let currency = document.getElementById("currency");
    let newCoin = currency.dataset.currency - bet;
    let homeFighter = document.getElementById("checkBoxHome-" + id);
    let awayFighter = document.getElementById("checkBoxAway-" + id);
    let koefHome = document.getElementById("koefHome-" + id);
    let koefAway = document.getElementById("koefAway-" + id);
    let mainEv = document.getElementById("mainEv-" + id).getAttribute('data-mainEv');
    let fighter, koef;

    // Paziņojums, ja nav atzīmēta rūtiņa un nospiesta poga.
    // Also checks if it has been checked afterward if true inserts value into DB
    // Kā arī pārbauda vai ir atzīmeta rūtiņa, ja ir, tad ievieto vērtību datubāzē
    if (currency.dataset.currency >= bet) {
        if (homeFighter.checked) {
            fighter = homeFighter.value;
            koef = koefHome.getAttribute('data-koef');
        } else if (awayFighter.checked) {
            fighter = awayFighter.value;
            koef = koefAway.getAttribute('data-koef');
        } else {
            const alertDiv = document.createElement('div');
            alertDiv.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'px-4', 'py-3', 'rounded', 'relative', 'mb-4', 'transition', 'opacity-0');
            alertDiv.innerHTML = `
    <strong class="font-bold">Attention!</strong>
    <span class="block sm:inline">Please choose a fighter.</span>
`;

            let alertContainer = document.getElementById('alert-container');
            if (!alertContainer) {
                alertContainer = document.createElement('div');
                alertContainer.id = 'alert-container';
                alertContainer.classList.add('fixed', 'top-4', 'right-4', 'z-50');
                document.body.appendChild(alertContainer);
            }
            alertContainer.appendChild(alertDiv);
            // Pievieno laiku, pēc kura paziņojums pazūd
            setTimeout(() => {
                alertDiv.classList.remove('opacity-0');
            }, 100);
            setTimeout(() => {
                alertDiv.classList.add('opacity-0');
                setTimeout(() => {
                    alertDiv.remove();
                }, 500);
            }, 3000);

            return;
        }

        let event = homeFighter.getAttribute('data-event');
        currency.innerHTML = newCoin;
        currency.dataset.currency = newCoin;

        // Padod datus uz funkciju, kas ievieto datus datubāzē
        updCoin(bet, fighter, event, koef, mainEv);

        // Stils priekš pogām, kad ir uzspiestas un kad nav uzspiestas.
        buttons.forEach(button => {
            button.disabled = true;
            //Nospiestai pogai, kurai klase ir active, pievieno stilu
            if (button.classList.contains('active')) {
                button.classList.add('bg-[#e4c065]');
                button.classList.add('text-[#4E4E4E]');
            } else {
                // Pievieno sarkanu ikonu, ja nav uzspiesta poga
                button.classList.add('relative', 'inline-flex', 'items-center', 'justify-center', 'px-4', 'py-2');
                button.innerHTML = '';
                let icon = document.createElement('i');
                icon.classList.add('uil', 'uil-ban', 'text-red-500');
                button.appendChild(icon);
            }
            // Pievieno klasi active
            document.getElementById('bet-' + id + '-' + bet).classList.add('active');
        });

        // Paziņojums par veiksmīgu likmi un stils
        const successMessage = document.createElement('div');
        successMessage.classList.add('bg-green-100', 'border', 'border-green-400', 'text-green-700', 'px-4', 'py-3', 'rounded', 'relative', 'mb-4', 'transition', 'opacity-0');
        successMessage.innerHTML = `
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">You have successfully placed a bet!</span>
`;

        let alertContainer = document.getElementById('alert-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.id = 'alert-container';
            alertContainer.classList.add('fixed', 'top-4', 'right-4', 'z-50');
            document.body.appendChild(alertContainer);
        }
        alertContainer.appendChild(successMessage);
        // Pievieno laiku, pēc kura paziņojums pazūd
        setTimeout(() => {
            successMessage.classList.remove('opacity-0');
        }, 100);

        setTimeout(() => {
            successMessage.classList.add('opacity-0');
            setTimeout(() => {
                successMessage.remove();
            }, 500);
        }, 3000);
    } else {
        // Ja nav pietiekami līdzekļu, tad parādas paziņojums
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('bg-red-100', 'border', 'border-red-400', 'text-red-700', 'px-4', 'py-3', 'rounded', 'relative', 'mb-4', 'transition', 'opacity-0');
        errorMessage.innerHTML = `
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">You do not have enough funds to place a bet!</span>
`;

        let alertContainer = document.getElementById('alert-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.id = 'alert-container';
            alertContainer.classList.add('fixed', 'top-4', 'right-4', 'z-50');
            document.body.appendChild(alertContainer);
        }
        alertContainer.appendChild(errorMessage);
// Pievieno laiku, pēc kura paziņojums pazūd
        setTimeout(() => {
            errorMessage.classList.remove('opacity-0');
        }, 100);

        setTimeout(() => {
            errorMessage.classList.add('opacity-0');
            setTimeout(() => {
                errorMessage.remove();
            }, 500);
        }, 3000);
    }
}

//Funkcija, kas padod iegūtos datus uz updateCurrency.php
function updCoin(newCoin, fighter, event, koef, mainEv) {
    let xhttp = new XMLHttpRequest()
    xhttp.open('POST', 'controllers/updateCurrency.php', true)
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let response = this.responseText;
            // console.log("answer from ajax: " + response);
        }
    };
    let data = 'coin=' + newCoin + '&fighter=' + fighter + '&event=' + event + '&koef=' + koef + '&mainEv=' + mainEv;
    xhttp.send(data);
    console.log('data=' + data);
}

//Funkcija, kas padod lietotāja atjaunināto valūtu uz updateUserMoney.php
function updCurrency() {
    let test = new XMLHttpRequest();
    test.open('POST', 'controllers/updateUserMoney.php', true);
    test.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    test.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let response = this.responseText;
            console.log("answer from ajax: " + response);
            if (response !== '') {
                document.getElementById('currency').innerHTML = response;
            }

        }
    };
    let data = 'getResult=1';
    test.send(data);
}


updCurrency();
