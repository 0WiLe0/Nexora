// party.js

import { state } from "../core/state.js";
import { partyCreate, partyShow } from "../party/party.api.js";
import {renderInviteModal} from "./invite-modal.js";
import { partyLeave } from '../party/party.api.js';
import {startPartyInvitesPolling, stopPartyPolling} from "../party/party.polling.js";
import {initParty} from "../party/party.init.js";



const partySlots = document.querySelector('.party__slots');
const partyModal = document.querySelector('.party-modal');
const partyModalClose = document.querySelector('.party-modal__close');
const partyModalOverlay = document.querySelector('.party-modal__overlay');
const leaveBtn = document.querySelector('.party-leave-btn');

const ROLE_ICONS = {
    carry: '../img/roles/carry.svg',
    mid: '../img/roles/mid.svg',
    offlane: '../img/roles/offlane.svg',
    support: '../img/roles/soft.svg',
    hard_support: '../img/roles/hard.svg',
};



startPartyInvitesPolling();

export function renderParty() {
    partySlots.innerHTML = '';

    if (state.party.id) {
        leaveBtn?.classList.remove('hidden');
    } else {
        leaveBtn?.classList.add('hidden');
    }


    if (!state.party.id) {
        renderVirtualLeader();
        return;
    }

    if (!state.party?.id && state.party?.members?.length === 0) {
        renderVirtualLeader();
        return;
    }


    const max = state.party.max ?? 5;


    const members = [...state.party.members].sort((a, b) => {

        if (a.role === 'leader') return -1;
        if (b.role === 'leader') return 1;


        if (a.is_me) return -1;
        if (b.is_me) return 1;


        return 0;
    });

    let rendered = 0;

    members.forEach(member => {
        const slot = document.createElement('div');
        slot.classList.add('party__slot');

        slot.classList.add(
            member.role === 'leader'
                ? 'party__slot--owner'
                : 'party__slot--member'
        );


        if (member.status === 'invited') {
            slot.classList.add('party__slot--invited');

            if (member.avatar) {
                slot.innerHTML = `<img src="${member.avatar}" alt="">`;
                slot.classList.add('party__slot--pending');
            } else {
                slot.innerHTML = '<span>Invited</span>';
            }
        }

        else if (member.avatar) {
            slot.innerHTML = `<img src="${member.avatar}" alt="">`;

            if (!member.is_friend && !member.is_me) {
                slot.classList.add('party__slot--hidden-avatar');
            }

            slot.classList.add('ready');
        }

        else {
            slot.classList.add('placeholder');
            slot.innerHTML = '<span>+</span>';
        }

        const rolesWrap = document.createElement('div');
        rolesWrap.classList.add('party__roles');

        if (member.roles && member.roles.length) {
            member.roles.forEach((role, index) => {
                const img = document.createElement('img');
                img.src = ROLE_ICONS[role];
                img.classList.add('party__role-icon');

                if (index === 0) {
                    img.classList.add('primary');
                }

                if (index === 1) {
                    img.classList.add('secondary');
                }

                img.alt = role;
                rolesWrap.appendChild(img);
            });
        }


        slot.appendChild(rolesWrap);


        partySlots.appendChild(slot);
        rendered++;
    });


    while (rendered < max) {
        const empty = document.createElement('div');
        empty.classList.add('party__slot', 'party__slot--empty');
        empty.innerHTML = '<span>+</span>';
        partySlots.appendChild(empty);
        rendered++;
    }
}

function renderVirtualLeader() {
    const max = state.party.max ?? 5;

    const leader = document.createElement('div');
    leader.classList.add('party__slot', 'party__slot--owner');

    leader.innerHTML = `
        <img src="${window.__ME_AVATAR__ ?? '/img/avatar.png'}" alt="">
    `;

    partySlots.appendChild(leader);

    for (let i = 1; i < max; i++) {
        const empty = document.createElement('div');
        empty.classList.add('party__slot', 'party__slot--empty');
        empty.innerHTML = '<span>+</span>';
        partySlots.appendChild(empty);
    }
}




async function handleInviteClick() {

    openInviteModal();
}


partySlots.addEventListener('click', async (e) => {
    const emptySlot = e.target.closest('.party__slot--empty');
    if (!emptySlot) return;


    handleInviteClick();
});


partyModalClose?.addEventListener('click', () => {
    partyModal.classList.add('hidden');
});

partyModalOverlay?.addEventListener('click', () => {
    partyModal.classList.add('hidden');
});



function openInviteModal() {
    partyModal.classList.remove('hidden');

    renderInviteModal();
}



leaveBtn?.addEventListener('click', async () => {
    if (!state.party.id) return;
    const oldPartyId = state.party.id;
    await partyLeave(oldPartyId);

    state.partyInvites = [];
    state.partyInvite = null;

    await initParty();

    stopPartyPolling();
    renderParty();
});



