// ui/roles.js
import { state } from '../core/state.js';
import { partyUpdateRoles } from '../party/party.api.js';
import { renderUI } from './render-ui.js';

document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.js-role');
    if (!btn) return;


    if (state.status !== 'idle') {
        return;
    }

    const value = btn.dataset.role;


    if (state.roles.primary === value) {
        state.roles.primary = null;
    }
    else if (state.roles.secondary === value) {
        state.roles.secondary = null;
    }
    else if (!state.roles.primary) {
        state.roles.primary = value;
    }
    else if (!state.roles.secondary) {
        state.roles.secondary = value;
    }


    const roles = [];
    if (state.roles.primary) roles.push(state.roles.primary);
    if (state.roles.secondary) roles.push(state.roles.secondary);


    if (!state.party || !state.party.id) {
        localStorage.setItem('solo_roles', JSON.stringify(roles));
        renderUI();
        return;
    }


    await partyUpdateRoles(state.party.id, roles);

    const me = state.party.members.find(m => m.is_me);
    if (me) {
        me.roles = roles;
    }

    renderUI();
});
