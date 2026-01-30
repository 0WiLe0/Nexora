//party.polling.js

import { state } from '../core/state.js';
import {getPartyInvites, partyShow} from './party.api.js';
import { renderParty } from '../ui/party.js';
import {renderInviteModal} from "../ui/invite-modal.js";
import {renderPartyInvite} from "../ui/party-invite.js";
import {renderPartyToast} from "../ui/party-toast.js";
import {setPartyFromResponse} from "./party.state.js";
import {syncPartyRolesToUI} from "./party.init.js";
import {renderSelectRoles} from "../ui/render-select-roles.js";

let partyTimer = null;

export function startPartyPolling(partyId) {
    if (!partyId) return;

    stopPartyPolling();

    partyTimer = setInterval(async () => {

        if (!state.party || !state.party.id || state.party.status === 'closed') {
            stopPartyPolling();
            return;
        }


        const resp = await partyShow(partyId);
        if (!resp) return;


        setPartyFromResponse(resp);
        syncPartyRolesToUI();
        renderSelectRoles();
        renderParty();



        renderInviteModal();
        renderPartyInvite();
    }, 1500);
}

export function stopPartyPolling() {
    if (!partyTimer) return;

    clearInterval(partyTimer);
    partyTimer = null;
}

let invitesTimer = null;

export function startPartyInvitesPolling() {
    if (invitesTimer) return;

    invitesTimer = setInterval(async () => {
        const invites = await getPartyInvites();
        state.partyInvites = invites ?? [];
            renderPartyToast();
    }, 1500);
}
