import {state} from "../core/state.js";


export function renderSelectRoles() {
    const buttons = document.querySelectorAll('.js-role');

    buttons.forEach(btn => {
        const role = btn.dataset.role;

        btn.classList.remove('primary', 'secondary');

        if (state.roles.primary === role) {
            btn.classList.add('primary');
        }

        if (state.roles.secondary === role) {
            btn.classList.add('secondary');
        }
    });
}
