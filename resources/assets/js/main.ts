'use strict';

+function () {
    const findElems = (className : string, context : Document | HTMLElement | HTMLFormElement = document) : NodeListOf<HTMLFormElement> | NodeListOf<HTMLElement> | null =>
            context.querySelectorAll(className),
        findElem = (className : string, context : Document | HTMLElement | HTMLFormElement | Element = document) : HTMLElement | null => context.querySelector(className),
        addClassName = (className : string, element : HTMLElement) : void => element.classList.add(className),
        arrayFrom = <T>(pseudoArray : ArrayLike<T>) : T[] => Array.from(pseudoArray);

    function validateForms() : void {
        const forms = findElems('.needs-validation');

        arrayFrom(forms).forEach(form => {
            form.addEventListener('submit', e => {
                if (!(form instanceof HTMLFormElement)) {
                    return;
                }

                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                addClassName('was-validated', form);
            }, false);
        });
    }

    function parsePhone(e : (InputEvent | FocusEvent | MouseEvent), phone : HTMLInputElement) : void {
        if (e instanceof MouseEvent && e.type === 'click') {
            return;
        }

        let tempValue : string = phone.value.replace(/^\+(38)/g, '').replace(/\D+/g, ''),
            pattern : string = '+38 (___) ___-__-__';

        const oldSelectionStart : number = phone.selectionStart;

        const setSelection = (position : number) : void => {
            phone.selectionStart = position;
            phone.selectionEnd = position;
        };

        const findPositionSelection = (string : string) : number => {
            let indexLetter : number = 0;

            while (typeof string[indexLetter] !== 'undefined' && string[indexLetter] !== '_' && string.length > indexLetter) {
                indexLetter++;
            }

            return indexLetter;
        };

        for (let numberIndex : number = 0; numberIndex < tempValue.length; numberIndex++) {
            if (typeof tempValue[numberIndex] !== 'undefined') {
                pattern = pattern.replace(/_/, tempValue[numberIndex]);
            }
        }

        phone.value = pattern;

        if (e instanceof FocusEvent && e.type === 'focus') {
            setSelection(findPositionSelection(pattern));
        } else if (oldSelectionStart < 5) {
            setSelection(5);
        } else if ('inputType' in e) {
            if (e.inputType === 'deleteContentBackward') {
                setSelection(oldSelectionStart);
            } else if (e.inputType === 'insertText') {
                if (/\s/.test(pattern[oldSelectionStart] + pattern[oldSelectionStart + 1])) {
                    setSelection(oldSelectionStart + 2);
                } else if (/[^_0-9]/.test(pattern[oldSelectionStart])) {
                    setSelection(oldSelectionStart + 1);
                } else {
                    setSelection(oldSelectionStart);
                }
            }
        } else {
            setSelection(findPositionSelection(pattern));
        }
    }

    function parsePhoneNumber() {
        arrayFrom(findElems('input[type=tel]')).forEach((phone : HTMLInputElement) : void => {
            phone.addEventListener('input', (e : InputEvent) => parsePhone(e, phone));
            phone.addEventListener('focus', (e : FocusEvent) => parsePhone(e, phone));
            phone.addEventListener('blur', (e : FocusEvent) => parsePhone(e, phone));
            phone.addEventListener('click', (e : MouseEvent) => parsePhone(e, phone));
        });
    }

    function enableTooltips() : void {
        const tooltipTriggerList : NodeListOf<HTMLElement> = findElems('[data-bs-toggle="tooltip"]');
        // @ts-ignore
        [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }

    function processInsertCostPrototype(addCostsBtn : HTMLElement, blockForAddCost : HTMLElement, inputFieldsPrototypeHtml : HTMLElement) {
        addCostsBtn.addEventListener('click', () : void => {
            const inputFieldsBlock : Node = inputFieldsPrototypeHtml.cloneNode(true),
                date = addCostsBtn.dataset.date;

            if (inputFieldsBlock instanceof Element) {
                const inputNameField : HTMLElement = findElem('[name=name]', inputFieldsBlock),
                    inputTotalField : HTMLElement = findElem('[name=total]', inputFieldsBlock);

                inputNameField.name = `cost[${date}][name][]`;
                inputTotalField.name = `cost[${date}][total][]`;
            }

            blockForAddCost.append(inputFieldsBlock);

            findElem('.d-none', blockForAddCost)?.classList.remove('d-none', 'add-costs-prototype');
        });
    }

    function addCosts() : void {
        const inputFieldsPrototypeHtml : HTMLElement | null = findElem('.add-costs-prototype'),
            blocksForAddCost : NodeListOf<HTMLElement> | null = findElems('.add-costs');

        if (!inputFieldsPrototypeHtml || !blocksForAddCost.length) {
            return;
        }

        arrayFrom(blocksForAddCost).forEach(blockForAddCost => {
            const addCostsBtn : HTMLElement | null = findElem('.costs__add-costs-btn', blockForAddCost);

            if (addCostsBtn) {
                processInsertCostPrototype(addCostsBtn, blockForAddCost, inputFieldsPrototypeHtml);
            }
        });
    }

    function addDreams() : void {
        const addDreamsBtn : HTMLElement | null = findElem('.costs__add-dreams-btn'),
            inputFieldsPrototypeHtml : HTMLElement | null = findElem('.add-dreams-prototype'),
            blockForAddDreams : HTMLElement | null = findElem('.add-dreams');

        if (!addDreamsBtn || !inputFieldsPrototypeHtml || !blockForAddDreams) {
            return;
        }

        addDreamsBtn.addEventListener('click', () : void => {
            const inputFields : Node = inputFieldsPrototypeHtml.cloneNode(true);

            blockForAddDreams.append(inputFields);

            findElem('.d-none', blockForAddDreams)?.classList.remove('d-none', 'add-dreams-prototype');
        });
    }

    validateForms();
    parsePhoneNumber();
    enableTooltips();
    addCosts();
    addDreams();
}();
