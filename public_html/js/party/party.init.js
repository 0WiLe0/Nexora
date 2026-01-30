// party.init.js

import { state } from '../core/state.js';
import { get } from '../core/http.js';
import { renderParty } from '../ui/party.js';
import {setPartyFromResponse} from "./party.state.js";
import {renderSelectRoles} from "../ui/render-select-roles.js";

const savedRoles = localStorage.getItem('nexora.soloRoles');

if (savedRoles) {
    try {
        const parsed = JSON.parse(savedRoles);
        state.roles.primary = parsed.primary ?? null;
        state.roles.secondary = parsed.secondary ?? null;
    } catch (e) {
        localStorage.removeItem('nexora.soloRoles');
    }
}


export async function initParty() {
    const resp = await get('/party/my');


    if (!resp || resp.my_status === 'invited') {
        state.party = null;
        renderParty();
        return;
    }

    setPartyFromResponse(resp);
    syncPartyRolesToUI();
    renderSelectRoles();
    renderParty();


}

export function syncPartyRolesToUI(){


    if (!state.party) {
        return;
    }

    const me = state.party.members.find(m => m.is_me);

    if (!me || !Array.isArray(me.roles)) {
        return;
    }

    localStorage.removeItem('nexora.soloRoles');


    state.roles.primary = me.roles[0] || null;
    state.roles.secondary = me.roles[1] || null;
}

