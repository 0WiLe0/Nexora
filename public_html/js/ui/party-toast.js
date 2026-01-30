//party-toas.js

import { state } from "../core/state.js";
import { partyAccept, partyLeave } from "../party/party.api.js";
import { initParty } from "../party/party.init.js";
import {post} from "../core/http.js";



export function renderPartyToast() {
    const toast = document.querySelector(".party-toast");
    if (!toast) return;

    const acceptBtn = toast.querySelector(".party-toast__accept");
    const declineBtn = toast.querySelector(".party-toast__decline");



    acceptBtn.disabled = false;
    declineBtn.disabled = false;


    const invite = state.partyInvites?.[0] ?? null;

    if (!invite) {
        toast.classList.add("hidden");
        return;
    }

    const inviter = invite.members.find(m => m.id === invite.leader_id);
    if (!inviter) {
        toast.classList.add("hidden");
        return;
    }

    const avatarEl = toast.querySelector(".party-toast__avatar img");
    const nicknameEl = toast.querySelector(".party-toast__nickname");
    const ratingWrap = toast.querySelector(".party-toast__rating");
    const ratingEl = toast.querySelector(".party-toast__rating span");

    avatarEl.src = inviter.avatar ?? "/img/avatar.png";
    nicknameEl.textContent = inviter.nickname ?? "Unknown";

    if (inviter.rating) {
        ratingWrap.style.display = "";
        ratingEl.textContent = inviter.rating;
    } else {
        ratingWrap.style.display = "none";
    }



    acceptBtn.onclick = async () => {
        console.log('accept');
        acceptBtn.disabled = true;
        declineBtn.disabled = true;

        const currentPartyId = state.party?.id;
        const invitePartyId = invite.party_id;


        if (currentPartyId && currentPartyId !== invitePartyId) {
            await partyLeave(currentPartyId);
        }


        const resp = await partyAccept(invitePartyId);
        if (resp?.error) {
            acceptBtn.disabled = false;
            declineBtn.disabled = false;
            return;
        }



        await partyAccept(invitePartyId);


        state.partyInvites = [];
        toast.classList.add("hidden");


        await initParty();
    };

    declineBtn.onclick = async () => {
        console.log('decline');
        declineBtn.disabled = true;

        await post(`/party/${invite.party_id}/invite-seen`);

        state.partyInvites = [];
        toast.classList.add("hidden");

        await initParty();
    };

    toast.classList.remove("hidden");
}
