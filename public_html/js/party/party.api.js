//party-api.js

import { get, post } from '../core/http.js';
import { state } from "../core/state.js";

export async function partyCreate() {
    const resp = await post('/party');

    const partyId = resp.party_id ?? resp.id ?? resp?.party?.id;

    console.log('partyCreate raw resp:', resp);

    if (!partyId) {
        return null;
    }

    return partyId;
}


export async function partyInvite(partyId, friendId) {
    if (!partyId || !friendId) return null;

    return await post(`/party/${partyId}/invite/${friendId}`);
}


export async function partyAccept(partyId) {
    if (!partyId) return null;

    const resp = await post(`/party/${partyId}/accept`);
    if (resp?.error) return null;

    return resp;
}

export async function partyLeave(partyId) {
    if (!partyId) return null;

    const resp = await post(`/party/${partyId}/leave`);
    if (resp?.error) return null;

    return resp;
}

export async function partyShow(partyId) {
    if (!partyId) return null;

    const party = await get(`/party/${partyId}`);
    if (party?.error) return null;

    return party;
}


export function getPartyInvites() {
    return get('/party/invites');
}

export async function partyUpdateRoles(partyId, roles) {
    return post(`/party/${partyId}/roles`, {
        roles
    });
}

