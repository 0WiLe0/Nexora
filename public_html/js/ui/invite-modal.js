import { state } from '../core/state.js';
import {
    partyCreate,
    partyInvite,
    partyShow
} from '../party/party.api.js';
import { startPartyPolling } from '../party/party.polling.js';

export function renderInviteModal() {
    const container = document.querySelector('.invite-list');
    if (!container) return;

    container.innerHTML = '';

    const members = state.party?.members ?? [];

    state.friends.forEach(friend => {
        const member = members.find(m => m.id === friend.id);

        const row = document.createElement('div');
        row.classList.add('party-modal__friend');

        row.innerHTML = `
            <img src="${friend.avatar}">
            <span>${friend.nickname}</span>
        `;

        const btn = document.createElement('button');


        if (member?.status === 'accepted') {
            btn.textContent = 'IN PARTY';
            btn.disabled = true;
        }


        else if (member?.status === 'invited') {
            btn.textContent = 'INVITED';
            btn.disabled = true;
        }


        else {
            btn.textContent = 'INVITE';

            btn.addEventListener('click', async () => {
                btn.disabled = true;
                btn.textContent = 'INVITING...';

                const ok = await onInviteClick(friend.id);

                if (!ok) {
                    btn.disabled = false;
                    btn.textContent = 'INVITE';
                    return;
                }

                btn.textContent = 'INVITED';
            });
        }

        row.appendChild(btn);
        container.appendChild(row);
    });
}

async function onInviteClick(friendId) {


    if (!state.party?.id) {
        const partyId = await partyCreate();
        if (!partyId) return false;

        await partyShow(partyId);
        startPartyPolling(partyId);
    }


    const resp = await partyInvite(state.party.id, friendId);
    if (resp?.error) return false;

    return true;
}
