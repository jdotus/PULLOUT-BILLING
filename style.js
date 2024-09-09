// Set max date for date input
const today = new Date();
const maxDate = today.toISOString().split('T')[0]; // Get only the date part

document.getElementById('sidate').max = maxDate;


        // Function to calculate and update the total amount payable
function updateTotalAmountPayable() {
    let totalAmount = 0;
    const totalPriceInputs = document.querySelectorAll('.totalprice');

    totalPriceInputs.forEach((input) => {
        totalAmount += parseFloat(input.value) || 0;
    });

    document.getElementById('total_amount_payable').value = totalAmount.toFixed(2);
    updateTotalSale(); // Update total sale price whenever total amount payable changes
    updateVAT(); // Update VAT whenever total amount payable changes
}

// Function to calculate and update the total sale price (before tax)
function updateTotalSale() {
    const totalAmountPayable = parseFloat(document.getElementById('total_amount_payable').value) || 0;
    const totalSale = totalAmountPayable / 1.12;

    document.getElementById('total_sale').value = totalSale.toFixed(2);
    updateVAT(); // Update VAT whenever total sale changes
}

// Function to calculate and update the VAT (Total Amount Payable - Total Sales)
function updateVAT() {
    const totalAmountPayable = parseFloat(document.getElementById('total_amount_payable').value) || 0;
    const totalSale = parseFloat(document.getElementById('total_sale').value) || 0;
    const vat = totalAmountPayable - totalSale;

    document.getElementById('vat').value = vat.toFixed(2);
}

// Function to calculate total price based on quantity and unit price
function updateTotalPrice(event) {
    const index = event.target.dataset.index;
    const copiesInput = document.querySelector(`.copies[data-index="${index}"]`);
    const unitPriceInput = document.querySelector(`.unitprice[data-index="${index}"]`);
    const totalPriceInput = document.querySelector(`.totalprice[data-index="${index}"]`);

    if (copiesInput && unitPriceInput && totalPriceInput) {
        const quantity = parseFloat(copiesInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const totalPrice = quantity * unitPrice;

        totalPriceInput.value = totalPrice.toFixed(2);

        // Update total amount payable
        updateTotalAmountPayable();

        console.log("Updated total price for index:", index, "Total:", totalPrice);
    }
}

// Function to initialize event listeners for all inputs
function initializeEventListeners() {
    const copiesInputs = document.querySelectorAll('.copies');
    const unitPriceInputs = document.querySelectorAll('.unitprice');
    const totalPriceInputs = document.querySelectorAll('.totalprice');

    copiesInputs.forEach(input => {
        input.addEventListener('input', updateTotalPrice);
    });

    unitPriceInputs.forEach(input => {
        input.addEventListener('input', updateTotalPrice);
    });

    totalPriceInputs.forEach(input => {
        input.addEventListener('input', updateTotalAmountPayable);
    });
}

// Adding input field dynamically
const addButton = document.getElementById('addInput');
const removeButton = document.getElementById('removeInput');
let inputIndex = 0; // Counter for input fields

addButton.addEventListener('click', () => {
    inputIndex++;

    // const newInputQuantity = document.createElement('input');
    const newModel = document.createElement('input');
    const newItemDescription = document.createElement('input');
    const newInputUnitPrice = document.createElement('input');
    const newInputTotalPrice = document.createElement('input');
    const newSerial = document.createElement('input');
    const newCopies = document.createElement('input');
    const newColorType = document.createElement('input');

    // newItemDescription.rows = 2;
    // newItemDescription.cols = 50;

    // newInputQuantity.type = 'text';
    newModel.type = 'text';
    newColorType.type = 'text';
    newItemDescription.type = 'text';
    newInputUnitPrice.type = 'text';
    newInputTotalPrice.type = 'text';
    newSerial.type = 'number';
    newCopies.type = 'number';

    // newInputQuantity.name = 'quantity[]';
    newModel.name = 'model[]';
    newColorType.name = 'colortype[]';
    newItemDescription.name = 'item_description[]';
    newInputUnitPrice.name = 'unitprice[]';
    newInputTotalPrice.name = 'totalprice[]';
    newSerial.name = 'serial[]';
    newCopies.name = 'copies[]';

    // newModel.readOnly = true;

    // newInputQuantity.classList.add('quantity');
    newModel.classList.add('model');
    newColorType.classList.add('colortype')
    newItemDescription.classList.add('item_description');
    newInputUnitPrice.classList.add('unitprice');
    newInputTotalPrice.classList.add('totalprice');
    newSerial.classList.add('serial');
    newCopies.classList.add('copies');

    // Assign a unique index to each input
    // newInputQuantity.dataset.index = inputIndex;
    newModel.dataset.index = inputIndex;
    newColorType.dataset.index = inputIndex;
    newItemDescription.dataset.index = inputIndex;
    newInputUnitPrice.dataset.index = inputIndex;
    newInputTotalPrice.dataset.index = inputIndex;
    newSerial.dataset.index = inputIndex;
    newCopies.dataset.index = inputIndex;

    // Add event listener to update the total price when quantity or unit price changes
    // newInputQuantity.addEventListener('input', updateTotalPrice);
    newInputUnitPrice.addEventListener('input', updateTotalPrice);
    newInputTotalPrice.addEventListener('input', updateTotalAmountPayable);

    // document.getElementById('inline-block-quantity').appendChild(newInputQuantity);
    document.getElementById('inline-block-model').appendChild(newModel);
    document.getElementById('inline-block-color-type').appendChild(newColorType);
    document.getElementById('inline-block-description').appendChild(newItemDescription);
    document.getElementById('inline-block-unitprice').appendChild(newInputUnitPrice);
    document.getElementById('inline-block-totalprice').appendChild(newInputTotalPrice);
    document.getElementById('inline-block-serial').appendChild(newSerial);
    document.getElementById('inline-block-copies').appendChild(newCopies);

    // Enable the remove button when inputs are added
    removeButton.disabled = false;

    // Update total price and amount payable after adding new input
    updateTotalPrice({ target: newInputQuantity }); // Trigger updateTotalPrice with the first input (quantity)
    updateTotalAmountPayable();
});

// Removing input
const removeInputs = document.getElementById('removeInput');
removeInputs.addEventListener('click', () => {
    // const copiesInputs = document.querySelectorAll('.quantity');
    const modelInputs = document.querySelectorAll('.model');
    const descriptionInputs = document.querySelectorAll('.item_description');
    const unitPriceInputs = document.querySelectorAll('.unitprice');
    const totalPriceInputs = document.querySelectorAll('.totalprice');
    const serialInputs = document.querySelectorAll('.serial');
    const copiesInput = document.querySelectorAll('.copies');
    const colorTypeInput = document.querySelectorAll('.colortype');


    if (modelInputs.length > 1) {
        // copiesInputs[copiesInputs.length - 1].remove();
        modelInputs[modelInputs.length - 1].remove();
        descriptionInputs[descriptionInputs.length - 1].remove();
        unitPriceInputs[unitPriceInputs.length - 1].remove();
        totalPriceInputs[totalPriceInputs.length - 1].remove();
        serialInputs[serialInputs.length - 1].remove();
        copiesInput[copiesInput.length - 1].remove();
        colorTypeInput[colorTypeInput.length - 1].remove();

        // Update the total amount payable after removing an input
        updateTotalAmountPayable();
    }

    // Disable the remove button if no inputs remain
    if (copiesInputs.length === 1) { // Length will be 1 because we are about to remove the last set
        removeButton.disabled = true;
    }
});
