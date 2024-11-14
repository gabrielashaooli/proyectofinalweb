document.addEventListener('DOMContentLoaded', () => {
    const currencyForm = document.getElementById('currencyForm');
    const resultDiv = document.getElementById('conversionResult');
    const apiKey = '4d147981ea8a464570a579ce';

    currencyForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const amount = parseFloat(document.getElementById('amount').value);
        const fromCurrency = document.getElementById('fromCurrency').value.trim().toUpperCase();
        const toCurrency = document.getElementById('toCurrency').value.trim().toUpperCase();

        if (!isNaN(amount) && fromCurrency && toCurrency && fromCurrency.length === 3 && toCurrency.length === 3) {
            getExchangeRate(amount, fromCurrency, toCurrency);
        } else {
            resultDiv.innerHTML = "<h6>Por favor, ingrese un monto y códigos de moneda válidos de tres letras.</h6>";
        }
    });

    async function getExchangeRate(amount, fromCurrency, toCurrency) {
        const url = `https://v6.exchangerate-api.com/v6/${apiKey}/pair/${fromCurrency}/${toCurrency}`;

        try {
            const response = await fetch(url);
            const data = await response.json();

            if (data.result === "success") {
                const rate = data.conversion_rate;
                const convertedAmount = (amount * rate).toFixed(2);
                resultDiv.innerHTML = `<h5>${amount} ${fromCurrency} = ${convertedAmount} ${toCurrency}</h4>`;
            } else {
                resultDiv.innerHTML = `<h6>No se pudo obtener la tasa de cambio. Verifique los códigos de moneda e intente nuevamente.</h6>`;
            }
        } catch (error) {
            console.error('Error al obtener la tasa de cambio:', error);
            resultDiv.innerHTML = `<h6>Error al obtener la tasa de cambio. Por favor, inténtelo de nuevo más tarde.</h6>`;
        }
    }
});
