'use strict';

+function () {
    const findElems = (className: string, context: Document | HTMLElement | HTMLFormElement = document): NodeListOf<HTMLFormElement> | NodeListOf<HTMLElement> | null =>
            context.querySelectorAll(className),
        addClassName = (className: string, element: HTMLElement): void => element.classList.add(className);

    function validateForms(): void {
        const forms = findElems('.needs-validation');

        Array.from(forms).forEach(form => {
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

    validateForms();
}();
