//party-invite.js
import { state } from '../core/state.js';
import { partyAccept, partyLeave } from '../party/party.api.js';
import { renderParty } from './party.js';
import {post} from "../core/http.js";

const inviteBlock = document.querySelector('.party-invite');
const acceptBtn = document.querySelector('.party-invite__accept');
const declineBtn = document.querySelector('.party-invite__decline');

export function renderPartyInvite() {
    if (!inviteBlock) return;

    const invitedMe = state.partyInvites?.length > 0;


    if (!invitedMe) {
        inviteBlock.classList.add('hidden');
        return;
    }

    inviteBlock.classList.remove('hidden');
}

acceptBtn?.addEventListener('click', async () => {
    const invite = state.partyInvites[0];
    await partyAccept(invite.party_id);

    await refreshParty();
});

declineBtn?.addEventListener('click', async () => {
    const invite = state.partyInvites[0];
    await post(`/party/${invite.party_id}/invite-seen`);
    state.partyInvites = [];
    renderPartyInvite();

    resetPartyState();
});

async function refreshParty() {
    const { partyShow } = await import('../party/party.api.js');
    await partyShow(state.party.id);
    renderParty();
    renderPartyInvite();
}

function resetPartyState() {
    state.party = { id: null, members: [], max: 5 };
    renderParty();
    renderPartyInvite();
}

export function getActiveInvite() {
    return state.partyInvites?.[0] ?? null;
}
